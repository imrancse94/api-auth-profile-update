<?php

namespace App\Http\Traits;

use App\Jobs\SendEmailJob;

trait SendEmailTrait{

    public function sendEmail($data, $email_subject,$from, $attachment, $template,$to){
        dispatch((new SendEmailJob($data, $email_subject,$from, $attachment, $template,$to)));
    }

}