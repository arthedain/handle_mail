<?php

namespace Arthedain\HandleMail\Services;

use Arthedain\HandleMail\Models\FailedJobs;
use Arthedain\HandleMail\Models\HandleMail;
use Arthedain\HandleMail\Jobs\HandleMailJob;

class JobService
{
    private ArtisanService $artisanService;

    private ConfigService $configService;

    public function __construct(ArtisanService $artisanService, ConfigService $configService)
    {
        $this->artisanService = $artisanService;
        $this->configService = $configService;
    }

    public function create(string $subject, array $content, string $id): void
    {
        $emails = $this->configService->email();
        $view = $this->configService->view();

        foreach ($emails as $email) {
            HandleMailJob::dispatch($subject, $content, $email, $view, $id)->onQueue('handle-mail');
        }
    }

    public function retryJob(string $id): void
    {
        $job = FailedJobs::where('id', $id)->first();
        $mail_id = $job->getCommandAttribute()->id;
        HandleMail::where('id', $mail_id)->update([
            'status' => 'process',
        ]);

        $this->artisanService->queueRetry($id);
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

        $this->artisanService->queueRetry();
    }

    public function delete(string $id): bool
    {
        if (FailedJobs::where('id', $id)->delete()) {
            return true;
        }

        return false;
    }
}
