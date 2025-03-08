<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Prescription_Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use DateTime;

class PatientController extends Controller
{
    public function is_verified(Request $request)
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

    public function getAllPatientData(Request $request)
    {
        try {
            $this->is_verified($request);

            $patients = Patient::paginate(10);
            $totalPatients = Patient::count();
            return View("admin.patientInfo", compact('patients', 'totalPatients'));
        } catch (\Exception $e) {
            \Log::error('Failed to retrieve patient data: ' . $e->getMessage());
            return redirect()->route('admin.login')->with('error', 'Failed to retrieve patient data. Please try again later.');
        }
    }

    public function showPatientDetails(Request $request, $id)
    {
        try {
            $this->is_verified($request);

            $patient = Patient::findOrFail($id);

            $upcomingAppointments = $patient->appointments()
                                            ->where('appointment_date', '>', now())
                                            ->where('status', '=', 'approved')
                                            ->orderBy('appointment_date', 'asc')
                                            ->get();

            $passedAppointments = $patient->appointments()
                                          ->where('status', '=', 'completed')
                                          ->orderBy('appointment_date', 'asc')
                                          ->get();

            return view('admin.patientDetails', compact('patient', 'upcomingAppointments', 'passedAppointments'));
        } catch (\Exception $e) {
            \Log::error('Failed to retrieve patient details: ' . $e->getMessage());
            return redirect()->route('admin.login')->with('error', 'Failed to retrieve patient details. Please try again later.');
        }
    }

    public function updatePatientPicture(Request $request, $id)
    {
        try {
            $this->is_verified($request);

            $patient = Patient::findOrFail($id);
        
            $request->validate([
                'profile_image' => 'required',
            ]);
        
            $rawBase64ImageData = $request->input('profile_image');
        
            $imageData = base64_decode(preg_replace('/^data:image\/\w+;base64,/', '', $rawBase64ImageData));

            $patient->patient_image = $imageData;
            $patient->save();
        
            return back()->with('patient_image_success', 'Profile image updated successfully.');
        } catch (\Exception $e) {
            \Log::error('Failed to update patient picture: ' . $e->getMessage());
            return back()->with('error', 'Failed to update profile image. Please try again later.');
        }
    }
    
    public function getPatientAges(Request $request)
    {
        try {
            $ages = Patient::select('age')->get();
            return response()->json($ages);
        } catch (\Exception $e) {
            \Log::error('Failed to retrieve patient ages: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to retrieve patient ages. Please try again later.'], 500);
        }
    }

    public function getPatientDensityData(Request $request)
    {
        try {
            $patientData = Patient::select(
                DB::raw('age as age_group'),
                DB::raw('count(*) as total')
            )
            ->groupBy('age_group')
            ->orderBy('age_group', 'asc')
            ->get();

            return response()->json($patientData);
        } catch (\Exception $e) {
            \Log::error('Failed to retrieve patient density data: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to retrieve patient density data. Please try again later.'], 500);
        }
    }

    public function getPatientGenderData()
    {
        try {
            $maleCount = Patient::where('gender', 'Male')->count();
            $femaleCount = Patient::where('gender', 'Female')->count();

            return response()->json([
                'male' => $maleCount,
                'female' => $femaleCount,
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to retrieve patient gender data: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to retrieve patient gender data. Please try again later.'], 500);
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
        
        $validatedData = $request->validate([
            'medical_history_file' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);
    
        if ($request->hasFile('medical_history_file')) {
            $file = $request->file('medical_history_file');
            $fileContent = file_get_contents($file->getRealPath());
    
            if ($fileContent === false) {
                return redirect()->back()->with('medical_history_error', 'Failed to read file content.');
            }
    
            try {
                $patient = Patient::findOrFail($id);
                $patient->medical_history = $fileContent;
    
                if (!$patient->save()) {
                    return redirect()->back()->with('medical_history_error', 'Failed to save patient record.');
                }
            } catch (\Illuminate\Database\QueryException $e) {
                \Log::error('Database error while updating medical history: ' . $e->getMessage());
                return redirect()->back()->with('medical_history_error', 'Database error: ' . $e->getMessage());
            } catch (\Exception $e) {
                \Log::error('General error while updating medical history: ' . $e->getMessage());
                return redirect()->back()->with('medical_history_error', 'General error: ' . $e->getMessage());
            }
        } else {
            return redirect()->back()->with('medical_history_error', 'No file was uploaded.');
        }
    
        return redirect()->back()->with('medical_history_success', 'Medical history updated successfully.');
    }

    public function getPatientActivityDataByDay($id)
    {
        try {
            $appointments = Appointment::where('patient_id', $id)
                                        ->selectRaw('DATE(appointment_date) as date, COUNT(*) as count')
                                        ->groupBy('date')
                                        ->orderBy('date', 'asc')
                                        ->get();
        
            $prescriptionDeliveries = Prescription_Request::where('patient_id', $id)
                                                          ->selectRaw('DATE(prescription_date) as date, COUNT(*) as count')
                                                          ->groupBy('date')
                                                          ->orderBy('date', 'asc')
                                                          ->get();
        
            $activities = [];
        
            foreach ($appointments as $appointment) {
                $date = $appointment->date;
                if (!isset($activities[$date])) {
                    $activities[$date] = 0;
                }
                $activities[$date] += $appointment->count;
            }
        
            foreach ($prescriptionDeliveries as $delivery) {
                $date = $delivery->date;
                if (!isset($activities[$date])) {
                    $activities[$date] = 0;
                }
                $activities[$date] += $delivery->count;
            }
        
            $formattedData = [];
            foreach ($activities as $date => $count) {
                $formattedData[] = [
                    'date' => $date,
                    'count' => $count,
                ];
            }
        
            return response()->json($formattedData);
        } catch (\Exception $e) {
            \Log::error('Failed to retrieve patient activity data: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to retrieve patient activity data. Please try again later.'], 500);
        }
    }

    public function updatePatientData(Request $request, $id)
    {
        try {
                $this->is_verified($request);
                $employee = Auth::guard('employee')->user()->load('role');

                if ($employee->role->role_name == "admin") {
                    // Validate the incoming request data
                $validatedData = $request->validate([
                    'first_name' => 'required|string|max:255',
                    'last_name' => 'required|string|max:255',
                    'address_line_1' => 'nullable|string|max:255',
                    'address_line_2' => 'nullable|string|max:255',
                    'city' => 'nullable|string|max:100',
                    'state' => 'nullable|string|max:100',
                    'postal_code' => 'nullable|string|max:20',
                    'emergency_contact_name' => 'nullable|string|max:255',
                    'emergency_relationship' => 'nullable|string|max:100',
                    'emergency_contact' => 'nullable|string|max:20',
                ]);
        
                // Find the patient by ID
                $patient = Patient::findOrFail($id);
        
                // Update the patient's data
                $patient->first_name = $validatedData['first_name'];
                $patient->last_name = $validatedData['last_name'];
                $patient->address_line_1 = $validatedData['address_line_1'];
                $patient->address_line_2 = $validatedData['address_line_2'];
                $patient->city = $validatedData['city'];
                $patient->state = $validatedData['state'];
                $patient->postal_code = $validatedData['postal_code'];
                $patient->emergency_contact_name = $validatedData['emergency_contact_name'];
                $patient->emergency_relationship = $validatedData['emergency_relationship'];
                $patient->emergency_contact = $validatedData['emergency_contact'];
                $patient->save();
                // Return a success message
                return redirect()->back()->with('update_patient_success', 'Patient data updated successfully!');
                
                
            }else {
                // If the user is not an admin, you can redirect or show a specific view/message
                return redirect()->back()->with('access_denied', 'this action requires admin priviledges ');
            }
        } catch (\Exception $e) {
            // Handle any errors and return an error message
            return redirect()->back()->with('error', 'An error occurred while updating patient data: ' . $e->getMessage());
        }
    }
    

    public function deletePatientData(Request $request, $id)
    {
        try {
            $this->is_verified($request);

            $employee = Auth::guard('employee')->user()->load('role');

            if ($employee->role->role_name == "admin") {
                $patient = Patient::findOrFail($id);
    
                $patient->appointments()->delete();
                $patient->careDeliveries()->delete();
                $patient->prescriptionRequest()->delete();
                if ($patient->patientAccount) {
                    $patient->patientAccount()->delete();
                }
                $patient->delete();

                return redirect()->back()->with('delete_patient_success', 'patient deleted successfully, 1 item deleted.');
            } else {
                return redirect()->back()->with('delete_patient_error', 'You do not have permission to delete this patient.');
            }
            
        } catch (\Exception $e) {
            \Log::error('Error deleting patient: ' . $e->getMessage());
    
            return redirect()->back()->with('delete_patient_error', 'Failed to delete data. Please try again later.');
        }
    }
}

