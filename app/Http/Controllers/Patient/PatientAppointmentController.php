<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Employee;
use App\Models\Appointment;
use App\Models\CareDelivery;
use App\Models\Patient_Account;
use App\Models\Prescription_Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PatientAppointmentController extends Controller
{
    public function verifyLoginStatus(Request $request)
    {
        try {
            $patientAccountID = Auth::guard('patient')->id();

            if (!$patientAccountID) {
                throw new \Exception('User is not logged in.');
            }
        
            return $patientAccountID;
        } catch (\Exception $e) {
            \Log::error('Failed to verify login status: ' . $e->getMessage());
            return redirect()->route('patient.login')->with('error', 'Session verification failed. Please log in again.');
        }
    }

    public function showAppointmentForm(Request $request)
    {
        try {
            $patientAccountID = $this->verifyLoginStatus($request);
            $patient = Patient::where("patient_account_id", $patientAccountID)->firstOrFail();
            return view('patient.requestAppointment', compact('patient'));
        } catch (\Exception $e) {
            \Log::error('Failed to load appointment form: ' . $e->getMessage());
            return redirect()->route('patient.login')->with('error', 'Failed to load appointment form. Please try again later.');
        }
    }

    public function addAppointment(Request $request)
    {
        $patientAccountID = $this->verifyLoginStatus($request);
    
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required',
            'notes' => 'nullable|string|max:1000',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    
        try {
            $patient = Patient::where('patient_account_id', $patientAccountID)->first();
    
            $appointment = new Appointment();
            $appointment->patient_id = $patient->id;
            $appointment->appointment_type = $request->type;
            $appointment->appointment_date = $request->date;
            $appointment->appointment_time = $request->time;
            $appointment->requested_by_patient = $patientAccountID;
            $appointment->status = "pending";
            $appointment->approved_time = null;
            $appointment->notes = $request->notes;
    
            $appointment->save();
    
            return redirect()->back()->with('add_patient_appointment_success', 'Appointment added successfully');
        } catch (\Exception $e) {
            \Log::error('Error adding appointment: ' . $e->getMessage());
            return redirect()->back()->with('add_patient_appointment_error', 'Failed to add appointment. Please try again.');
        }
    }

    public function showAppointmentPage(Request $request)
    {
        try {
            $patientAccountID = $this->verifyLoginStatus($request);
            $patient = Patient::where('patient_account_id', $patientAccountID)->first();
            
            // Fetch appointments
            $pendingAppointments = Appointment::where("status", "pending")
                                               ->where('patient_id', $patient->id)
                                               ->with('employee')
                                               ->get();
            
            $approvedAppointments = Appointment::where("status", "approved")
                                                ->where('patient_id', $patient->id)
                                                ->with('employee')
                                                ->get();
            
            $completedAppointments = Appointment::where("status", "completed")
                                                 ->where('patient_id', $patient->id)
                                                 ->with('employee')
                                                 ->get();
            
            // Fetch prescriptions
            $approvedPrescriptions = Prescription_Request::where("status", "approved")
                                                 ->where('patient_id', $patient->id)
                                                 ->get();
            $pendingPrescriptions = Prescription_Request::where("status", "pending")
                                                 ->where('patient_id', $patient->id)
                                                 ->get();
            $completedPrescriptions = Prescription_Request::where("status", "completed")
                                                 ->where('patient_id', $patient->id)
                                                 ->get();
            $completedCaredeliveries = CareDelivery::where("status", "completed")
                                                 ->where('patient_id', $patient->id)
                                                 ->with('employee')
                                                 ->get();
            $pendingCaredeliveries = CareDelivery::where("status", "pending")
                                                 ->where('patient_id', $patient->id)
                                                 ->with('employee')
                                                 ->get();
            $approvedCaredeliveries = CareDelivery::where("status", "approved")
                                                 ->where('patient_id', $patient->id)
                                                 ->with('employee')
                                                 ->get();
     
            
            // Return all data to the view
            return view('patient.patientAppointment', compact(
                'pendingAppointments', 'approvedAppointments', 'completedAppointments',
                'approvedPrescriptions','pendingPrescriptions','completedPrescriptions',
                'pendingCaredeliveries','completedCaredeliveries','approvedCaredeliveries',
            ));
        } catch (\Exception $e) {
            \Log::error('Failed to load appointment page: ' . $e->getMessage());
            return redirect()->route('patient.login')->with('error', 'Failed to load appointment page. Please try again later.');
        }
    }
    

    public function showAppointmentDetails(Request $request, $id)
    {
        try {
            $this->verifyLoginStatus($request);

            $appointment = Appointment::findOrFail($id);
            return view('patient.patientAppointmentDetails', compact('appointment'));
        } catch (\Exception $e) {
            \Log::error('Failed to load appointment details: ' . $e->getMessage());
            return redirect()->route('patient.login')->with('error', 'Failed to load appointment details. Please try again later.');
        }
    }

}

