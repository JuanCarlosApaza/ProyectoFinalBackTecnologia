<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Faker\Factory as FakerFactory;
use Faker\Generator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Configurar Faker en español (España)
        $this->app->singleton(Generator::class, function () {
            return FakerFactory::create('es_ES'); // Puedes cambiar a 'es_MX', 'es_AR', etc.
        });
    }
}
