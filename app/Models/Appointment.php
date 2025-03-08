<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;
use App\Models\Employee;
class Appointment extends Model
{
    use HasFactory;

    //protected $fillable = [
        //'patient_id', 
        //'requestID',
        //'assigned_employee',
        //'location',
        //'appointment_date',
       // 'appointment_time',
       // 'status',
       // 'appointment_types',
        //'notes',
        
        
    //];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'assigned_employee_id');
    }
}
