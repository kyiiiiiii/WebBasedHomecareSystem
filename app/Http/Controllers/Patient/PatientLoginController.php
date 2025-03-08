<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient_Account;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class PatientLoginController extends Controller
{

    public function showLoginForm()
    {
        return view('patient.patientLogin');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:5',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->with('patient_login_error', 'Invalid email or password');
        }
    
        try { 
            $patientAccount = Patient_Account::where('email', $request->input('email'))->first();
    
            if (!$patientAccount) {
                return redirect()->back()->with('patient_login_error', 'Invalid email or password');
            }
    
            if (Hash::check($request->input('password'), $patientAccount->password)) {
                
                session([
                    'patientAccountName' => $patientAccount->username,
                    'patientAccountID'=> $patientAccount->id,
                    
                ]);
                Auth::guard('patient')->login($patientAccount);
    
                return redirect()->route('showPatientHome'); 
            } else {
                return redirect()->back()->with('patient_login_error', 'Invalid email or password');
            }
    
        } catch (\Exception $e) {
            Log::error('Patient login failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again later.')->withInput();
        }
    }
    
    public function patientLogout(Request $request)
    {
        try {
            Auth::guard('patient')->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('patient.login');
        } catch (\Exception $e) {
            Log::error('Patient logout failed: ' . $e->getMessage());
            return redirect()->route('patient.login')->with('error', 'An unexpected error occurred during logout. Please try again.');
        }
    }
}
