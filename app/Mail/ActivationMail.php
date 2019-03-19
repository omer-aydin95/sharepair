<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ActivationMail extends Mailable
{
    use Queueable, SerializesModels;

    private $activation_link;

    public function __construct($a_link)
    {
        $this->activation_link = $a_link;
    }

    public function build()
    {
        return $this->view('mailtemplate')->with('link', $this->activation_link);
    }
}































