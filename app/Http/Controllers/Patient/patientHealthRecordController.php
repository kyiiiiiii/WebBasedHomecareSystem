<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class patientHealthRecordController extends Controller
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

    public function showPatientHealthRecord(Request $request)
    {
        try {
            $patientAccountID = $this->is_verified($request);

            $patient = Patient::where('patient_account_id', $patientAccountID)->firstOrFail();

            $upcomingAppointments = $patient->appointments()
                                            ->where('appointment_date', '>', now())
                                            ->where('status', '=', 'approved')
                                            ->orderBy('appointment_date', 'asc')
                                            ->get();

            $passedAppointments = $patient->appointments()
                                          ->where('status', '=', 'completed')
                                          ->orderBy('appointment_date', 'asc')
                                          ->get();

            return view('patient.patientHealthRecord', compact('patient', 'upcomingAppointments', 'passedAppointments'));
        } catch (\Exception $e) {
            \Log::error('Failed to retrieve patient health record: ' . $e->getMessage());
            return redirect()->route('patient.login')->with('error', 'Failed to retrieve patient health record. Please try again later.');
        }
    }

    public function downloadPatientMedicalHistory(Request $request, $id)
    {
        $this->is_verified($request);
        try {
            $patient = Patient::findOrFail($id);
            $fileContent = $patient->medical_history;
            $fileName = 'medical_history_' . $patient->name . '.pdf';
    
            if ($fileContent) {
                $headers = [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'attachment; filename="'.$fileName.'"',
                ];
    
                return response($fileContent, 200, $headers);
            } else {
                return redirect()->back()->with('medical_history_error', 'No medical history found.');
            }
        } catch (\Exception $e) {
            \Log::error('Failed to download medical history: ' . $e->getMessage());
            return redirect()->back()->with('medical_history_error', 'Failed to download medical history. Please try again later.');
        }
    }
    
    public function updateMedicalHistory(Request $request, $id)
    {
        $this->is_verified($request);
    
        $validator = Validator::make($request->all(), [
            'medical_history_file' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        
        if ($request->hasFile('medical_history_file')) {
            $file = $request->file('medical_history_file');
            $fileContent = file_get_contents($file->getRealPath());
    
            if ($fileContent === false) {
                \Log::error('Failed to read file content for patient ID: ' . $id);
                return redirect()->back()->with('medical_history_error', 'Failed to read file content.');
            }
    
            try {
                $patient = Patient::findOrFail($id);
                $patient->medical_history = $fileContent;
    
                if (!$patient->save()) {
                    \Log::error('Failed to save medical history for patient ID: ' . $id);
                    return redirect()->back()->with('medical_history_error', 'Failed to save patient record.');
                }
    
                \Log::info('Session data before redirect:', session()->all());
    
                return redirect()->back()->with('medical_history_success', 'Medical history updated successfully.');
    
            } catch (\Illuminate\Database\QueryException $e) {
                \Log::error('Database error while updating medical history for patient ID ' . $id . ': ' . $e->getMessage());
                return redirect()->back()->with('medical_history_error', 'Database error: ' . $e->getMessage());
            } catch (\Exception $e) {
                \Log::error('General error while updating medical history for patient ID ' . $id . ': ' . $e->getMessage());
                return redirect()->back()->with('medical_history_error', 'General error: ' . $e->getMessage());
            }
        } else {
            \Log::error('No file was uploaded for patient ID: ' . $id);
            return redirect()->back()->with('medical_history_error', 'No file was uploaded.');
        }
    }
    

}

