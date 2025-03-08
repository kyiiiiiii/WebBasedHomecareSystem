<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmployeeAccount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AdminLoginController extends Controller
{
    // Show admin login form
    public function showLoginForm()
    {
        return view('admin.adminLogin');
    }

    // Handle admin login request
    public function login(Request $request)
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('admin_login_error', 'Invalid email or password');
        }

        try {
            $employeeAccount = EmployeeAccount::where('email', $request->input('email'))->first();

            if (!$employeeAccount) {
                return redirect()->back()->with('admin_login_error', 'Invalid email or password');
            }

            if (Hash::check($request->input('password'), $employeeAccount->password)) {
                
                Auth::guard('employee')->login($employeeAccount);

                session([
                    'employeeAccountName' => $employeeAccount->username,
                    'employeeAccountID' => $employeeAccount->id,
                    'employeeProfilePicture' => $employeeAccount->profile_picture
                ]);

                return redirect()->route('showAdminHome');
            } else {
                return redirect()->back()->with('admin_login_error', 'Invalid email or password');
            }
        } catch (\Exception $e) {
            Log::error('Admin login failed: ' . $e->getMessage());
            return redirect()->back()->with('admin_login_error', 'Invalid email or password');
        }
    }

    public function logout(Request $request)
    {
        try {
            Auth::guard('employee')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('admin.login');
        } catch (\Exception $e) {
            Log::error('Logout failed: ' . $e->getMessage());
            return redirect()->route('admin.login')->with('error', 'An unexpected error occurred during logout. Please try again.');
        }
    }
}
