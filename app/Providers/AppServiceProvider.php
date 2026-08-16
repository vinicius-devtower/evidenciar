<?php

namespace App\Providers;

use App\Services\PlanFeatureService;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
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
        $this->app->singleton(PlanFeatureService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::addNamespace('templates', resource_path('templates'));

        // @feature('eva') ... @endfeature  — gate no Blade
        Blade::if('feature', function (string $feature) {
            return app(PlanFeatureService::class)->userHas(auth()->user(), $feature);
        });
    }
}
