<?php

namespace App\Providers;


use App\Charts\ArtistChart;
use App\Charts\GenreChart;
use App\Charts\PlayDaysChart;
use ConsoleTVs\Charts\Registrar as Charts;
use Illuminate\Support\Facades\Schema;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Charts $charts)
    {
        Schema::defaultStringLength(191);
        $charts->register([
            PlayDaysChart::class,
            GenreChart::class,
            ArtistChart::class,
        ]);
    }
}
