<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    
    protected $fillable = ['patient_id', 'employee_id'];

    public function patient()
    {
        return $this->belongsTo(Patient_Account::class);
    }

    public function employee()
    {
        return $this->belongsTo(EmployeeAccount::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
