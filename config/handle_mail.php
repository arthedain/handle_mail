<?php

return [

    /*
     * Here you can write multiple emails to send mail to them
     */
    'email' => [
        //
    ],

    /*
     * Models path
     */
    'models' => [
        'handle_mail' => Arthedain\HandleMail\Models\HandleMail::class,
        'failed_jobs' => Arthedain\HandleMail\Models\FailedJobs::class,
    ],

    /*
     * Mail path
     */
    'mail' => Arthedain\HandleMail\Mail\HandleMail::class,

    /*
     * Mail job path
     */
    'job' => Arthedain\HandleMail\Jobs\HandleMailJob::class,

];
