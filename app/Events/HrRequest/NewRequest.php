<?php

namespace App\Events\HrRequest;

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
    public function __construct($hrRequest)
    {
        $this->title = 'New Certification/Document Request:';
        $this->message = view('broadcast.hr-request.new')->with([
            'hrRequest' => $hrRequest,
        ])->render();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('hr-request'),
        ];
    }
    public function broadcastAs(){
        return 'new-request';
    }
}
