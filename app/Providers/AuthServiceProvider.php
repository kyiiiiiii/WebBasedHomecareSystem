<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::define('delete-appointment', function ($employee) {
            Log::info('Gate check for delete-appointment triggered', [
                'employee_id' => $employee->id,
                'role_name' => $employee->role->role_name
            ]);
    
            // Temporarily allow all employees for debugging
            return true;
        });
    
        // Add this to see if any gate is being checked
        Gate::before(function ($user, $ability) {
            Log::info("Checking gate policy for: $ability", ['user_id' => $user->id]);
        });
        
    }
}
