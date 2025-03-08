<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\CareDelivery;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PatientHomeController extends Controller
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

    public function showPatientHome(Request $request)
    {
        try {
            $patientAccountID = $this->verifyLoginStatus($request);

            $patient = Patient::where('patient_account_id', $patientAccountID)
                              ->with(['appointments' => function($query) {
                                  $query->where('status', 'approved')
                                        ->whereDate('appointment_date', '>', Carbon::today());
                              }])
                              ->firstOrFail();

            $careDeliveries = CareDelivery::select('id', 'care_delivery_type', 'time', 'date', 'status')
                              ->where('patient_id', $patient->id)
                              ->where('status', 'approved')
                              ->whereDate('date', '>', Carbon::today())
                              ->orderBy('date')
                              ->get();
        
            return view('patient.patientHome', compact('patient', 'careDeliveries'));
        } catch (\Exception $e) {
            \Log::error('Failed to load patient home page: ' . $e->getMessage());
            return redirect()->route('patient.login')->with('error', 'Failed to load patient home page. Please try again later.');
        }
    }

    public function showPatientAppointmentCalendar(Request $request)
    {
        try {
            $patientAccountID = $this->verifyLoginStatus($request);
        
            $patient = Patient::where('patient_account_id', $patientAccountID)->firstOrFail();
        
            $appointments = Appointment::select('appointment_type', 'appointment_time', 'appointment_date', 'patient_id', 'assigned_employee_id')
                ->where('patient_id', $patient->id)
                ->where('status', 'approved')
                ->get()
                ->map(function ($appointment) {
                    return [
                        'title' => $appointment->employee->name ?? 'No Assigned Employee',
                        'start' => Carbon::parse($appointment->appointment_date . ' ' . $appointment->appointment_time)->toIso8601String(),
                        'type' => $appointment->appointment_type,
                    ];
                });
        
            return response()->json($appointments);
        } catch (\Exception $e) {
            \Log::error('Failed to load patient appointment calendar: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to load patient appointment calendar. Please try again later.'], 500);
        }
    }
}

