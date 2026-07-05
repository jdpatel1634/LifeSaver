<?php

namespace App\Providers;

use App\Models\SerologyTest;
use App\Observers\SerologyTestObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Application services can be bound here when needed.
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerModelObservers();
        $this->configureEloquentStrictMode();
    }

    /**
     * Register model observers used by the application.
     */
    private function registerModelObservers(): void
    {
        SerologyTest::observe(SerologyTestObserver::class);
    }

    /**
     * Enable stricter Eloquent behaviour outside production to catch mistakes early.
     */
    private function configureEloquentStrictMode(): void
    {
        Model::preventLazyLoading(! $this->app->isProduction());
    }
}
