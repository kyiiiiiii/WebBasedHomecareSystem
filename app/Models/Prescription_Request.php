<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;
use App\Models\Employee;

class Prescription_Request extends Model
{
    protected $table = 'prescription_requests';
    use HasFactory;

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function Employee()
    {
        return $this->hasOne(Employee::class);
    }
}
