<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;
class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $data, $email_subject,$from_email, $attachment, $template,$to;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $email_subject,$from, $attachment, $template,$to)
    {
        $this->data = $data;
        $this->email_subject = $email_subject;
        $this->from_email = $from;
        $this->attachment = $attachment;
        $this->template = $template;
        $this->to = $to;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->to)->send(new SendEmail($this->data, $this->email_subject,$this->from_email, $this->attachment, $this->template));
    }
}
