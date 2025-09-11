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
    public $simpleMessage;
    public $tag;
    public $redirectTo;
    public function __construct($hrRequest)
    {
        $this->title = 'New Certification/Document Request:';
        $this->message = view('broadcast.hr-request.new')->with([
            'hrRequest' => $hrRequest,
        ])->render();

        $this->simpleMessage = $hrRequest->employee_full.' requested for a '.$hrRequest->document;
        $this->tag = $hrRequest->slug.\Carbon::now()->format('Y-m-dH:i');
        $this->redirectTo = route('dashboard.hr_requests.index',[],false);
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
