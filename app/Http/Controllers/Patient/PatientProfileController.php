<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\Patient;
use App\Models\Patient_Account;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;

class PatientProfileController extends Controller
{
    public function verifyLoginStatus(Request $request)
    {
        try {
            $patientAccountID = Auth::guard('patient')->id();

            if (!$patientAccountID) {
                return redirect()->route('admin.login')->with('error', 'You must be logged in to access this page.');
            }
        
            return $patientAccountID;
        } catch (\Exception $e) {
            \Log::error('Failed to verify login status: ' . $e->getMessage());
            return redirect()->route('patient.login')->with('error', 'Session verification failed. Please log in again.');
        }
    }

    public function showPatientProfile(Request $request)
    {
        try {
            $patientAccountID = $this->verifyLoginStatus($request);

            $patientAccount = Patient_Account::findOrFail($patientAccountID);
            $patient = $patientAccount->patient;

            return view('patient.patientProfile', compact('patientAccount', 'patient'));
        } catch (\Exception $e) {
            \Log::error('Failed to load patient profile: ' . $e->getMessage());
            return redirect()->route('patient.login')->with('error', 'Failed to load patient profile. Please try again later.');
        }
    }

    public function updateBio(Request $request)
    {
        $validatedData = $request->validate([
            'bio' => 'required|string|max:255'
        ]);

        try {
            $patientAccountID = $this->verifyLoginStatus($request);

            $patient = Patient::where('patient_account_id', $patientAccountID)->firstOrFail();
            $patient->bio = $validatedData['bio'];
            $patient->save();

            return redirect()->route('patientProfile')->with('bio_success', 'Bio updated successfully.');
        } catch (\Exception $e) {
            \Log::error('Failed to update bio: ' . $e->getMessage());
            return redirect()->route('patientProfile')->with('bio_error', 'Failed to update bio. Please try again later.');
        }
    }

    public function updatePersonalInfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'state' => 'required|string|max:10',
            'city' => 'required|string|max:20',
            'postal_code' => 'required|string|max:10',
            'contact' => 'required|string|max:20',
            'dob' => 'required|date',
            'gender' => 'required|string|max:20',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    
        try {
            $patientAccountID = $this->verifyLoginStatus($request);
            $patient = Patient::where('patient_account_id', $patientAccountID)->firstOrFail();
    
            $patient->email = $validator->validated()['email'];
            $patient->address_line_1 = $validator->validated()['address_line_1'];
            $patient->address_line_2 = $validator->validated()['address_line_2'] ?? null;
            $patient->state = $validator->validated()['state'];
            $patient->city = $validator->validated()['city'];
            $patient->postal_code = $validator->validated()['postal_code'];
            $patient->contact = $validator->validated()['contact'];
            $patient->date_of_birth = $validator->validated()['dob'];
            $patient->gender = $validator->validated()['gender'];
    
            $patient->save();
    
            return redirect()->back()->with('personal_info_success', 'Personal information updated successfully.');
        } catch (\Exception $e) {
            \Log::error('Failed to update personal information: ' . $e->getMessage());
            return redirect()->back()->with('personal_info_error', 'Failed to update personal information. Please try again later.');
        }
    }

    public function updateAccountInfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:5|confirmed',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    
        try {
            $patientAccountID = $this->verifyLoginStatus($request);
            $patientAccount = Patient_Account::findOrFail($patientAccountID);
    
            if (!Hash::check($validator->validated()['current_password'], $patientAccount->password)) {
                return redirect()->back()->with('password_update_error', 'Current password is incorrect');
            }
    
            $patientAccount->password = Hash::make($validator->validated()['new_password']);
            $patientAccount->save();
    
            return redirect()->back()->with('password_update_success', 'Password updated successfully.');
        } catch (\Exception $e) {
            \Log::error('Failed to update account information: ' . $e->getMessage());
            return redirect()->back()->with('password_update_error', 'Failed to update password. Please try again later.');
        }
    }

    public function updatePatientProfilePicture(Request $request)
    {
        try {
            $patientAccountID = $this->verifyLoginStatus($request);
        
            $patientAccount = Patient_Account::findOrFail($patientAccountID);

            $request->validate([
                'profile_image' => 'required',
            ]);
        
            $rawBase64ImageData = $request->profile_image;

            $imageData = base64_decode(preg_replace('/^data:image\/\w+;base64,/', '', $rawBase64ImageData));

            $patientAccount->profile_picture = $imageData;
            $patientAccount->save();
        
            return redirect()->back()->with('success', 'Profile picture updated successfully.');
        } catch (\Exception $e) {
            \Log::error('Failed to update profile picture: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update profile picture. Please try again later.');
        }
    }
}

