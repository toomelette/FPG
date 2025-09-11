<?php

namespace App\Events\MisRequest;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewRequest implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $message;
    public $title;
    public $simpleMessage;
    public $tag;
    public $redirectTo;
    public function __construct($misRequest)
    {

        $this->title = 'New MIS Request:';
        $this->message = view('broadcast.mis-request.new')->with([
            'misRequest' => $misRequest,
        ])->render();
        $this->simpleMessage = 'A new request from '.$misRequest->requisitioner.' - '.$misRequest->request_details;
        $this->tag = $misRequest->slug.\Carbon::now()->format('Y-m-dH:i');
        $this->redirectTo = route('dashboard.mis_requests.index',[],false);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('mis-request'),
        ];
    }
    public function broadcastAs(){
        return 'new-request';
    }
}
