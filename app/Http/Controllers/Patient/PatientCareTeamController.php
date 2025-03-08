<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\CareDelivery;
use App\Models\Employee;
use App\Models\Caregiver_Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PatientCareTeamController extends Controller
{
    public function is_verified(Request $request)
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

    public function showCareTeamPage(Request $request)
    {
        try {
            $this->is_verified($request);

            $employees = Employee::all();

            return view('patient.patientCareTeam', compact('employees'));
        } catch (\Exception $e) {
            \Log::error('Failed to load care team page: ' . $e->getMessage());
            return redirect()->route('patient.login')->with('error', 'Failed to load care team page. Please try again later.');
        }
    }

    public function getCaregiverDetails(Request $request, $id)
    {
        try {
            $patientAccountID = $this->is_verified($request);
        
            $caregiver = Employee::findOrFail($id);
        
            $patient = Patient::where('patient_account_id', $patientAccountID)->firstOrFail();
            
            $history_of_appointments = Appointment::where('patient_id', $patient->id)
                                                ->where('assigned_employee_id', $id)
                                                ->get();
        
            $history_of_careDelivery = CareDelivery::where('patient_id', $patient->id)
                                                ->where('assigned_employee', $id)
                                                ->get();
        
            $combinedHistory = $history_of_appointments->merge($history_of_careDelivery);
            $sortedHistory = $combinedHistory->sortBy(function($entry) {
                return $entry->date ?? $entry->appointment_date;
            });
        
            return view('patient.caregiverDetails', compact('caregiver', 'sortedHistory'));
        } catch (\Exception $e) {
            \Log::error('Failed to retrieve caregiver details: ' . $e->getMessage());
            return redirect()->route('patient.login')->with('error', 'Failed to retrieve caregiver details. Please try again later.');
        }
    }
}

