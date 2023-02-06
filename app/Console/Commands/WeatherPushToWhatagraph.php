<?php
namespace App\Console\Commands;

use App\Exceptions\WGException;
use App\Services\Weather\GetLocationWeatherService;
use App\Services\Geocoder\SearchLocationService;
use App\Services\Whatagraph\CreateLocationSourceDataService;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Spatie\LaravelData\DataCollection;

class WeatherPushToWhatagraph extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather:pull-and-push-to-whatagraph';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'The command will pull the submitted locations from openweathermap and push it back to whatagraph';

    private SearchLocationService $searchLocationService;

    private GetLocationWeatherService $getLocationWeatherService;

    private CreateLocationSourceDataService $createLocationSourceDataService;

    private DataCollection $temporaryStoredLocations;

    private Collection $selectedLocations;

    private int $maximumLocations = 5;

    /**
     * Execute the console command.
     *
     * @param SearchLocationService $searchLocationService
     * @param GetLocationWeatherService $getLocationWeatherService
     * @param CreateLocationSourceDataService $createLocationSourceDataService
     * @return int
     * @throws WGException
     */
    public function handle(
        SearchLocationService $searchLocationService,
        GetLocationWeatherService $getLocationWeatherService,
        CreateLocationSourceDataService $createLocationSourceDataService
    ): int {
        $this->searchLocationService = $searchLocationService;
        $this->getLocationWeatherService = $getLocationWeatherService;
        $this->createLocationSourceDataService = $createLocationSourceDataService;

        $this->selectedLocations = collect();

        $this->initCycle();

        $this->info('Data pushed to Whatagraph successfully');

        return Command::SUCCESS;
    }


    private function getLocationSearchResults(): void
    {
        $locationName = $this->ask('Please enter the location name');
        $this->temporaryStoredLocations = $this->searchLocationService->execute($locationName);
        if ($this->temporaryStoredLocations->count() == 0) {
            $this->info('No results found!');
            $this->initCycle();
        }
        $this->storeChosenSearchResult();
    }

    private function storeChosenSearchResult(): void
    {
        $choices = [];
        $this->temporaryStoredLocations->each(function ($item, $key) use (&$choices) {
            $choices[$key] = "$item->name - $item->state - $item->country";
        });
        $selectedChoiceString = $this->choice('Choose a search result from the following', $choices);
        $selectedChoiceIndex = array_search($selectedChoiceString, $choices);

        $selectedChoice = $this->temporaryStoredLocations->offsetGet($selectedChoiceIndex);
        $selectedChoice->locationWeatherData = $this->getLocationWeatherService->execute($selectedChoice->lat, $selectedChoice->lon);

        $this->selectedLocations->push($selectedChoice);
        $this->initCycle();
    }

    /**
     * If there is no locations submitted or the user want to add more location and didn't reach the maximum locations
     * the cycle will start from the beginning, otherwise it will submit the data to Whatagraph
     *
     * @throws WGException
     */
    private function initCycle(): void
    {
        if (
            $this->selectedLocations->count() == 0 ||
            (
                $this->selectedLocations->count() < $this->maximumLocations &&
                $this->confirm('Would you like to submit another location?', false)
            )
        ) {
            $this->getLocationSearchResults();

            return;
        }
        $this->createLocationSourceDataService->execute($this->selectedLocations);
    }
}
