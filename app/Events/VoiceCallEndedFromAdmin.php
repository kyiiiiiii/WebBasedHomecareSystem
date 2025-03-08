<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VoiceCallEndedFromAdmin implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $roomUrl;
    public $patient_id;

    public function __construct($roomUrl, $patient_id)
    {
        $this->roomUrl = $roomUrl;
        $this->patient_id = $patient_id;
    }

    public function broadcastWith()
    {
        return [
            'callUrl' => $this->roomUrl,
            'patientId' => $this->patient_id,
        ];
    }

    public function broadcastOn()
    {
        return new Channel('global-notifications');
    }
}
