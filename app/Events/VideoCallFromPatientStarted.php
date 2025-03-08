<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class VideoCallFromPatientStarted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $chatId;
    public $videoCallUrl;
    
    public function __construct($chatId, $videoCallUrl)
    {
        $this->chatId = $chatId;
        $this->videoCallUrl = $videoCallUrl;

    }

   
    public function broadcastOn()
    {
        return new Channel('chat.' . $this->chatId);    
    }

    /**
     * The data to broadcast with the event.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'videoCallUrl' => $this->videoCallUrl,
            'chatId' => $this->chatId,
        ];
    }
}
