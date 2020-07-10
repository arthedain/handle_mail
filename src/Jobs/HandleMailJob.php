<?php

namespace Arthedain\HandleMail\Jobs;

use App\Mail\HandleMail;
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

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($subject, $content, $id)
    {
        $this->subject = $subject;
        $this->content = $content;
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $mail = config('handle_mail', HandleMail::class);

        $emails = config('handle_mail.email', ['admin@mail.com']);

        foreach($emails as $email){
            Mail::to($email)->send(new $mail($this->subject, $this->content));
        }
    }
}
