<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmployeeAccount;
use App\Models\Employee;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class EmployeeProfileController extends Controller
{
    public function verifyLoginStatus(Request $request)
    {
        try {
            $employeeAccountID = Auth::guard('employee')->id();

            if (!$employeeAccountID) {
                return redirect()->route('admin.login')->with('error', 'You must be logged in to access this page.');
            }
        
            return $employeeAccountID;
        } catch (\Exception $e) {
            \Log::error('Failed to verify login status: ' . $e->getMessage());
            return redirect()->route('admin.login')->with('error', 'Session verification failed. Please log in again.');
        }
    }

    public function showEmployeeProfile(Request $request)
    {    
        try {
            $employeeAccountID = $this->verifyLoginStatus($request);

            $employeeAccount = EmployeeAccount::find($employeeAccountID);
            $employee = $employeeAccount->employee;

            return view('admin.empProfile', compact('employeeAccount', 'employee'));
        } catch (\Exception $e) {
            \Log::error('Failed to load employee profile: ' . $e->getMessage());
            return redirect()->route('admin.login')->with('error', 'Failed to load employee profile. Please try again later.');
        }
    }

    public function updateBio(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'bio' => 'required|string|max:255',
            ]);

            $employeeAccountID = $this->verifyLoginStatus($request);
            $employee = Employee::where('employee_account_id', $employeeAccountID)->first();
            $employee->bio = $validatedData['bio'];
            $employee->save();

            return redirect()->route('empProfile')->with('bio_success', 'Updated');
        } catch (\Exception $e) {
            \Log::error('Failed to update bio: ' . $e->getMessage());
            return redirect()->route('empProfile')->with('error', 'Failed to update bio. Please try again later.');
        }
    }

    public function updatePersonalInfo(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'email' => 'required|email|max:255',
                'address' => 'required|string|max:255',
                'contact_number' => 'required|string|max:20',
                'emergency_contact_number' => 'required|string|max:20',
            ]);

            $employeeAccountID = $this->verifyLoginStatus($request);
            $employee = Employee::where('employee_account_id', $employeeAccountID)->first();
            $employee->email = $validatedData['email'];
            $employee->address = $validatedData['address'];
            $employee->contact_number = $validatedData['contact_number'];
            $employee->emergency_contact_number = $validatedData['emergency_contact_number'];
            $employee->save();

            return redirect()->route('empProfile')->with('personal_info_success', 'Updated successfully');
        } catch (\Exception $e) {
            \Log::error('Failed to update personal info: ' . $e->getMessage());
            return redirect()->route('empProfile')->with('error', 'Failed to update personal information. Please try again later.');
        }
    }

    public function updateAccountInfo(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'current_password' => 'required|string',
                'new_password' => 'required|string|min:5|confirmed',
            ]);

            $employeeAccountID = $this->verifyLoginStatus($request);
            $employeeAccount = EmployeeAccount::find($employeeAccountID);

            if (!Hash::check($validatedData['current_password'], $employeeAccount->password)) {
                return redirect()->route('empProfile')->with('password_update_error', 'Current password is incorrect');
            }

            $employeeAccount->password = Hash::make($validatedData['new_password']);
            $employeeAccount->save();

            \Log::info("Updated password hash for employee ID {$employeeAccountID}: " . $employeeAccount->password);

            return redirect()->route('empProfile')->with('password_update_success', 'Password updated successfully');
        } catch (\Exception $e) {
            \Log::error('Failed to update account info: ' . $e->getMessage());
            return redirect()->route('empProfile')->with('error', 'Failed to update account information. Please try again later.');
        }
    }

    public function updateEmployeePicture(Request $request)
    {
        try {
            $employeeAccountID = $this->verifyLoginStatus($request);
            $employeeAccount = EmployeeAccount::find($employeeAccountID);

            $request->validate([
                'profile_image' => 'required',
            ]);

            $employee = $employeeAccount->employee;
            $rawBase64ImageData = $request->profile_image;
            $imageData = base64_decode(preg_replace('/^data:image\/\w+;base64,/', '', $rawBase64ImageData));
            $employee->profile_image = $imageData;
            $employee->save();

            return back()->with('success', 'Profile image updated successfully.');
        } catch (\Exception $e) {
            \Log::error('Failed to update profile image: ' . $e->getMessage());
            return back()->with('error', 'Failed to update profile image. Please try again later.');
        }
    }
}

