<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VideoCallFromAdminStarted implements ShouldBroadcast
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

    public function broadcastWith()
    {
        return [
            'videoCallUrl' => $this->videoCallUrl,
            'chatId' => $this->chatId,
        ];
    }
}