<?php

namespace Arthedain\HandleMail;

use Laravel\Nova\Nova;
use Laravel\Nova\Events\ServingNova;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Route;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\ServiceProvider;
use Illuminate\Queue\Events\JobProcessed;
use Arthedain\HandleMail\Services\MailService;
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
        $this->registerPublishes();

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'handle-mail');

        $this->app->booted(function () {
            $this->routes();
        });

        Nova::serving(function (ServingNova $event) {
            //
        });

//        php artisan queue:work --stop-when-empty --queue=handle-mail

        Queue::after(function (JobProcessed $event) {
            MailService::updateMailStatus($event, 'success');
        });

        Queue::failing(function (JobFailed $event) {
            MailService::updateMailStatus($event, 'error');
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

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    public function registerPublishes()
    {
        $this->publishes([
            __DIR__.'/Jobs/HandleMailJob.php' => app_path('/Jobs/HandleMailJob.php'),
        ], 'job');
        $this->publishes([
            __DIR__.'/Mail/HandleMail.php' => app_path('/Mail/HandleMail.php'),
        ], 'mail');
        $this->publishes([
            __DIR__.'/../resources/views/mail.blade.php' => resource_path('/views/vendor/handle-mail/mail.blade.php'),
            __DIR__.'/../resources/views/telegram/message.blade.php' => resource_path('/views/vendor/handle-mail/telegram/message.blade.php'),
        ], 'view');
        $this->publishes([
            __DIR__.'/../assets/handle-mail.js' => public_path('/assets/handle-mail.js'),
        ], 'script');
        $this->publishes([
            __DIR__.'/../config/handle-mail.php' => config_path('handle-mail.php'),
        ], 'config');
        $this->publishes([
            __DIR__.'/../database/migrations/create_handle_mails_table.php' => database_path('/migrations/'.date('Y_m_d_His', time()).'_create_handle_mails_table.php'),
        ], 'migration');

        $this->publishes([
            __DIR__.'/../resources/views/mail.blade.php' => resource_path('/views/vendor/handle-mail/mail.blade.php'),
            __DIR__.'/../resources/views/telegram/message.blade.php' => resource_path('/views/vendor/handle-mail/telegram/message.blade.php'),
            __DIR__.'/../assets/handle-mail.js' => public_path('/assets/handle-mail.js'),
            __DIR__.'/../config/handle-mail.php' => config_path('handle-mail.php'),
            __DIR__.'/../database/migrations/create_handle_mails_table.php' => database_path('/migrations/'.date('Y_m_d_His', time()).'_create_handle_mails_table.php'),
        ], 'default');

        $this->publishes([
            __DIR__.'/../config/honeypot.php' => config_path('honeypot.php'),
        ], 'config-honeypot');
    }
}
