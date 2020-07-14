<?php

namespace Arthedain\HandleMail;

use Arthedain\HandleMail\Models\FailedJobs;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;
use Arthedain\HandleMail\Http\Middleware\Authorize;
use Illuminate\Support\Facades\Queue;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobFailed;
use Arthedain\HandleMail\Models\HandleMail;

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
        $this->publishes([
            __DIR__.'/public/view/mail.blade.php' => resource_path('/views/vendor/handle-mail/mail.blade.php')
        ], 'view');
        $this->publishes([
            __DIR__.'/public/assets/handle-mail.js' => public_path('/assets/handle-mail.js')
        ], 'script');
        $this->publishes([
            __DIR__.'/../config/handle_mail.php' => config_path('handle-mail.php')
        ], 'config');
        $this->publishes([
            __DIR__.'/public/migrations/2020_06_30_080754_create_handle_mails_table.php' => database_path('/migrations/2020_06_30_080754_create_handle_mails_table.php')
        ], 'migration');

        $this->publishes([
            __DIR__.'/public/view/mail.blade.php' => resource_path('/views/vendor/handle-mail/mail.blade.php'),
            __DIR__.'/public/assets/handle-mail.js' => public_path('/assets/handle-mail.js'),
            __DIR__.'/../config/handle_mail.php' => config_path('handle-mail.php'),
            __DIR__.'/public/migrations/2020_06_30_080754_create_handle_mails_table.php' => database_path('/migrations/2020_06_30_080754_create_handle_mails_table.php'),
        ], 'default');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'handle-mail');

        $this->app->booted(function () {
            $this->routes();
        });

        $this->app->singleton('HandleMailModel', config('handle_mail.models.handle_mail', HandleMail::class));
        $this->app->singleton('FailedJobsModel', config('handle_mail.models.failed_jobs', FailedJobs::class));


        Nova::serving(function (ServingNova $event) {
            //
        });

//        php artisan queue:work --stop-when-empty --queue=handle-mail

        Queue::after(function (JobProcessed $event) {
            $this->updateMailStatus($event, 'success');
        });

        Queue::failing(function (JobFailed $event) {
            $this->updateMailStatus($event, 'error');
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
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
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

    public function updateMailStatus($event, $status){
        if($event->job->getQueue()){
            $mail_id = unserialize($event->job->payload()['data']['command'])->id;
            \DB::table('handle_mails')->where('id', $mail_id)->update([
                'status' => $status
            ]);
        }
    }
}
