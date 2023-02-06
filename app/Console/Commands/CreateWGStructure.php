<?php
namespace App\Console\Commands;

use App\Exceptions\WGException;
use App\Services\Whatagraph\{CreateDimensionService, CreateMetricService};
use Illuminate\Console\Command;

class CreateWGStructure extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'WG:create-structure';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will create WG metrics/dimension report structure';

    /**
     * Execute the console command.
     *
     * @param CreateMetricService $createMetricService
     * @param CreateDimensionService $createDimensionService
     * @return int
     * @throws WGException
     */
    public function handle(
        CreateMetricService $createMetricService,
        CreateDimensionService $createDimensionService
    ): int {
        $metrics = config('whatagraph.metrics');
        $dimensions = config('whatagraph.dimensions');

        foreach ($metrics as $metric) {
            $createMetricService->execute($metric['name'], $metric['external_id'], $metric['type']);
        }

        foreach ($dimensions as $dimension) {
            $createDimensionService->execute($dimension['name'], $dimension['external_id'], $dimension['type']);
        }

        return Command::SUCCESS;
    }
}
