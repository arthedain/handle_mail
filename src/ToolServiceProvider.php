<?php

namespace Arthedain\HandleMail;

use App\Nova\Metrics\TestTrend;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;
use Arthedain\HandleMail\Http\Middleware\Authorize;

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/Jobs/HandleMailJob.php' => app_path('/Jobs/HandleMailJob.php'),
        ], 'job');
        $this->publishes([
            __DIR__.'/Mail/HandleMail.php' => app_path('/Mail/HandleMail.php'),
        ], 'mail');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'handle-mail');

        $this->app->booted(function () {
            $this->routes();
        });

        Nova::serving(function (ServingNova $event) {
            //
        });
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['nova', Authorize::class])
                ->prefix('nova-vendor/handle-mail')
                ->group(__DIR__.'/../routes/api.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
