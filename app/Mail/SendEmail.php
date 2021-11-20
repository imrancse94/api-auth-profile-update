<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $data, $email_subject,$from_email, $attachment, $template;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $email_subject,$from, $attachment, $template)
    {
        $this->data = $data;
        $this->email_subject = $email_subject;
        $this->from_email = $from;
        $this->attachment = $attachment;
        $this->template = $template;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->email_subject)
                ->from($this->from_email)
                ->markdown($this->template)
                ->with(['data' => $this->data]);
        //return $this->view($this->template);
    }
}
