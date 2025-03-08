<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PatientBpmUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $bpmValue;
    public $patientId;

    public function __construct($bpmValue, $patientId)
    {
        $this->bpmValue = $bpmValue;
        $this->patientId = $patientId;
    }

    public function broadcastOn()
    {
        return new Channel('bpm-channel');  // Public channel (can also be PrivateChannel)
    }

    public function broadcastWith()
    {
        return [
            'bpm_value' => $this->bpmValue,
            'patient_id' => $this->patientId,
        ];
    }
}

