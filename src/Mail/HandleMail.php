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

    public $view;

    /**
     * Create a new message instance.
     *
     * @param string $subject
     * @param array  $content
     * @param string $view
     */
    public function __construct(string $subject = '', array $content = [], string $view = 'vendor.handle-mail.mail')
    {
        $this->subject = $subject;
        $this->content = $content;
        $this->view = $view;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view($this->view, ['subject' => $this->subject, 'content' => $this->content]);
    }
}
