<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Message extends Model
{
    use HasFactory;
    protected $fillable = [
        'chat_id',       // Add this line to make chat_id mass assignable
        'sender_type',
        'sender_id',    // Add other fields as necessary
        'message',
    ];
    // Define relationships
    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    public function sender()
    {
        return $this->morphTo();
    }
}

// Adding the morphMap configuration in the same file (directly below the class definition)
Relation::morphMap([
    'patient' => \App\Models\Patient::class,
    'employee' => \App\Models\Employee::class,
]);
