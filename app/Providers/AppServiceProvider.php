<?php
namespace App\Providers;

use App\Adapters\Geocoding\Contracts\GeocodingAdapterInterface;
use App\Adapters\Geocoding\OpenWeatherGeocodingAdapter;
use App\Adapters\Weather\Contracts\WeatherAdapterInterface;
use App\Adapters\Weather\OneCallAdapter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(GeocodingAdapterInterface::class, OpenWeatherGeocodingAdapter::class);
        $this->app->singleton(WeatherAdapterInterface::class, OneCallAdapter::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
    }
}
