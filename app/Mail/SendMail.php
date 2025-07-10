<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $testMailData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($testMailData)
    {
        $this->testMailData = $testMailData;
        $this->mailer = 'aaa';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('SRA Web Portal')
            ->from('no-reply@sra.gov.ph','SRA Web Portal Notifications')
            ->replyTo('aaa@sra.gov.ph')
            ->to(['geraldjesterguance01@gmail.com'])
            ->bcc(['gguance221@gmail.com'])
            ->view('emails.testMail');
    }
}
