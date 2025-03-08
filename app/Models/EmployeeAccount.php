<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;
use App\Models\Role;
use Illuminate\Foundation\Auth\User as Authenticatable;

class EmployeeAccount extends Authenticatable
{
    use HasFactory;
    
    public function Employee()
    {
        return $this->hasOne(Employee::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
