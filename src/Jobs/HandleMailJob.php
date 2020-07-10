<?php

namespace Arthedain\HandleMail\Jobs;

use Arthedain\HandleMail\Mail\HandleMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;

class HandleMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $subject = '';
    public $content = '';
    public $id;
    public $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($subject, $content, $email, $id = 0)
    {
        $this->subject = $subject;
        $this->content = $content;
        $this->id = $id;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $mail = config('handle_mail.mail', HandleMail::class);


        Mail::to($this->email)->send(new $mail($this->subject, $this->content));
    }
}
