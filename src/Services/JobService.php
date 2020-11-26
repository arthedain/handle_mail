<?php

namespace Arthedain\HandleMail\Services;

use Illuminate\Support\Facades\Artisan;
use Arthedain\HandleMail\Models\FailedJobs;
use Arthedain\HandleMail\Models\HandleMail;
use Arthedain\HandleMail\Jobs\HandleMailJob;

class JobService
{
    /**
     * @param string $subject
     * @param array  $content
     * @param string $id
     */
    public function create(string $subject, array $content, string $id): void
    {
        $emails = config('handle-mail.email', []);

        foreach ($emails as $email) {
            HandleMailJob::dispatch($subject, $content, $email, $id)->onQueue('handle-mail');
        }
    }

    /**
     * @param string $id
     */
    public function retryJob(string $id): void
    {
        $job = FailedJobs::where('id', $id)->first();
        $mail_id = $job->getCommandAttribute()->id;
        HandleMail::where('id', $mail_id)->update([
            'status' => 'process',
        ]);

        Artisan::call("queue:retry {$id}");
    }

    public function retryAllJob(): void
    {
        $jobs = FailedJobs::all();
        $keys = [];

        foreach ($jobs as $item) {
            array_push($keys, $item->getCommandAttribute()->id);
        }

        HandleMail::whereIn('id', $keys)->update([
            'status' => 'process',
        ]);

        Artisan::call('queue:retry all');
    }

    /**
     * @param string $id
     *
     * @return bool
     */
    public function delete(string $id): bool
    {
        if (FailedJobs::where('id', $id)->delete()) {
            return true;
        }

        return false;
    }
}
