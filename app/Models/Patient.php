<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Appointment;
use App\Models\Prescription_Request;
use App\Models\Patient_Account;
use App\Models\CareDelivery;

class Patient extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'dob',
        'gender',
        'address',
        'state',
        'city',
        'email',
        'contact_number',
        'patient_account_id',
        // Add other fields as per your schema
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function careDeliveries()
    {
        return $this->hasMany(CareDelivery::class);
    }

    public function prescriptionRequest()
    {
        return $this->hasMany(Prescription_Request::class);
    }

    public function patientAccount()
    {
        return $this->belongsTo(Patient_Account::class, 'patient_account_id');
    }

    public function EcgData()
    {
        return $this->hasOne(EcgData::class);
    }
}