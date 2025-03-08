<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Patient_Account extends Authenticatable
{
    use HasFactory;
    
    protected $table = 'patient_accounts';

    public function patient()
    {
        return $this->hasOne(Patient::class, 'patient_account_id');
    }

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }
}


