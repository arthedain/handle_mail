<?php

namespace Arthedain\HandleMail\Jobs;

use Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Arthedain\HandleMail\Mail\HandleMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class HandleMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $subject = '';

    public array $content = [];

    public string $id;

    public string $email;

    public string $view;

    /**
     * Create a new job instance.
     *
     * @param string $subject
     * @param array  $content
     * @param string $email
     * @param string $id
     */
    public function __construct(string $subject, array $content, string $email, string $id = '0')
    {
        $this->subject = $subject;
        $this->content = $content;
        $this->id = $id;
        $this->email = $email;
        $this->view = $view = config('handle-mail.view', 'vendor.handle-mail.mail');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)->send(new HandleMail($this->subject, $this->content));
    }
}
