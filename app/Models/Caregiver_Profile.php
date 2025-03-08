<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caregiver_Profile extends Model
{
    use HasFactory;
    protected $table = 'caregiver_profiles';
    protected $fillable = [
        'employee_id',
        'years_of_experience',
        'specializations',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
