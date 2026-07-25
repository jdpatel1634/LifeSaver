<?php

namespace App\Providers;

use Laravel\Sanctum\Sanctum;
use Illuminate\Support\ServiceProvider;
use App\Providers\Filament\AdminPanelProvider;
use App\Models\SerologyTest;
use App\Observers\SerologyTestObserver;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Sanctum::ignoreMigrations();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (app()->environment('production')) 
        {
        URL::forceScheme('https');
        }
        SerologyTest::observe(SerologyTestObserver::class);
    }
}
