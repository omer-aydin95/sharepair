<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetMail extends Mailable
{
    use Queueable, SerializesModels;

    private $reset_link;

    public function __construct($r_link)
    {
        $this->reset_link = $r_link;
    }

    public function build()
    {
        return $this->view('resetmailtemplate')->with('link', $this->reset_link);
    }
}
