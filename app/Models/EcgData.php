<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcgData extends Model
{
    use HasFactory;
    protected $table = 'ecg_data';

    protected $fillable = [
        'patient_id',
        'ecg_value',
    ];
    
    public function Patient()
    {
        return $this->belongsTo(Patient::class);
    }

    
}
