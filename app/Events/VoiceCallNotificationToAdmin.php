<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VoiceCallNotificationToAdmin implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $roomUrl;
    public $employee_id;

    public function __construct($roomUrl,$employee_id)
    {
        $this->roomUrl = $roomUrl;
        $this->employee_id = $employee_id;
    }
    public function broadcastWith()
    {
        return [
            'callUrl' => $this->roomUrl,
            'employeeId' => $this->employee_id,
        ];
    }

    public function broadcastOn()
    {
        return new Channel('global-notifications');
    }
}
