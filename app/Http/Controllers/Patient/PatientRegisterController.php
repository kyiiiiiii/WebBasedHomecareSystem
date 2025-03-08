<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Patient_Account;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PatientRegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view("registerPatientAccount");
    }

    public function registerPatient(Request $request)
    {
        
        try {
            // Create new Patient Account
            $patient_account = new Patient_Account;
            $patient_account->username = $request->username;
            $patient_account->email = $request->email;
            $patient_account->password = Hash::make($request->password); // Hashing the password
            $patient_account->save();
    
            // Calculate the age based on DOB
            $dob = new \DateTime($request->dob);
            $now = new \DateTime();
            $age = $now->diff($dob)->y;
    
            // Create new Patient
            $patient = new Patient;
            $patient->gender = $request->gender;
            $patient->first_name = $request->first_name;
            $patient->last_name = $request->last_name;
            $patient->name = $request->first_name . ' ' . $request->last_name; // Correct string concatenation
            $patient->age = $age; // Calculating the age
            $patient->email = $request->email;
            $patient->address_line_1 = $request->address_line_1;
            $patient->address_line_2 = $request->address_line_2;
            $patient->contact = $request->contact;
            $patient->date_of_birth = $request->dob;
            $patient->patient_account_id = $patient_account->id;
            $patient->save();
    
            // Redirect to login route with success message
            return redirect()->route('patient.login')->with('patient_register_error', 'Patient registered and logged in successfully!');
    
        } catch (\Exception $e) {
            // Log the error and return with failure message
            \Log::error('Patient registration failed: ' . $e->getMessage());
            return redirect()->back()->with('patient_register_error', 'Failed to register patient. Please try again later.');
        }
    }
    
}
