<?php

namespace App\Mail;

use App\Models\MisRequestsEmailRecipients;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class MisRequestCreate extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $data;
    public $r;
    public $user;
    public function __construct($data, $r, $user)
    {
        $this->data = $data;
        $this->r = $r;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $data = $this->data;
        $r = $this->r;
        $user = $this->user;
        $recipients_arr = [];

        $recipients = MisRequestsEmailRecipients::query()->where('active','=',1)->get();
        if(!empty($recipients)){
            foreach ($recipients as $recipient){
                array_push($recipients_arr,$recipient->email);
            }
            return $this
                ->to($recipients_arr)
                ->subject('MIS Service Request - '.$r->nature_of_request . ' '.strtoupper(Str::random(5)))
                ->view('mailables.mis_requests.inform')->with(['data' => $data,'r'=> $r,'user'=> $user]);
        }


    }
}
