<?php

namespace Arthedain\HandleMail\Traits;

use Arthedain\HandleMail\Jobs\HandleMailJob;

trait HandleJob
{
    public function createJob($subject, $content, $id){
        $job = config('handle-mail.job', HandleMailJob::class);

        $emails = config('handle-mail.email', ['admin@mail.com']);

        foreach($emails as $email) {
            (new $job($subject, $content, $email, $id))->dispatch($subject, $content, $email, $id)->onQueue('handle-mail');
        }
    }
}
