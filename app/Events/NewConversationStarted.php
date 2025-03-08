<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use App\Models\Chat;

class NewConversationStarted implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $chat;

    public function __construct(Chat $chat)
    {
        $this->chat = $chat;
    }

    public function broadcastOn()
    {
        return new Channel('conversations'); // Global channel for all conversations
    }

    public function broadcastWith()
    {
        return [
            'chat_id' => $this->chat->id,
            'patient_name' => $this->chat->patient->username,
            'employee_name' => $this->chat->employee->name,
            'employee_id' => $this->chat->employee->id
        ];
    }
}

