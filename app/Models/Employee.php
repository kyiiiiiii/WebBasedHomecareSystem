<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Appointment;
use App\Models\CareDelivery;
use App\Models\Caregiver_Profile;
use App\Models\Prescription_Request;
use App\Models\EmployeeAccount;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'dob',
        'gender',
        'address' ,
        'state' ,
        'city' ,
        'email' ,
        'contact_number' ,
        'emergency_contact_number' ,
        'department' ,
        'admission_date' ,

    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'assigned_employee_id');
    }

    public function careDeliveries()
    {
        return $this->hasMany(CareDelivery::class);
    }

    public function prescriptionRequest()
    {
        return $this->hasMany(Prescription_Request::class);
    }

    public function caregiverProfile()
    {
        return $this->hasOne(Caregiver_Profile::class);
    }

    public function employeeAccount()
    {
        return $this->belongsTo(EmployeeAccount::class);
    }

}
