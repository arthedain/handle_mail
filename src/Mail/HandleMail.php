<?php

namespace Arthedain\HandleMail\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class HandleMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;

    public $content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject = '', $content = '')
    {
        $this->subject = $subject;
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $view = config('handle-mail.view', 'vendor.handle-mail.mail');

        return $this->view($view, ['subject' => $this->subject, 'content' => $this->content]);
    }
}
