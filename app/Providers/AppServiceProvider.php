<?php

namespace App\Providers;

use Laravel\Sanctum\Sanctum;
use Illuminate\Support\ServiceProvider;
use App\Providers\Filament\AdminPanelProvider;
use App\Models\SerologyTest;
use App\Observers\SerologyTestObserver;

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
        SerologyTest::observe(SerologyTestObserver::class);
    }
}
