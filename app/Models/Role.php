<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EmployeeAccount;

class Role extends Model
{
    use HasFactory;
    public function users()
    {
        return $this->belongsToMany(EmployeeAccount::class, 'user_roles');
    }

    public function employees()
    {
        return $this->hasMany(EmployeeAccount::class, 'role_id');
    }
}
