<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Employee;
use App\Models\Patient;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AppointmentController extends Controller
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
            \Log::error('Session verification failed: ' . $e->getMessage());
            return redirect()->route('admin.login')->with('error', 'Session verification failed. Please log in again.');
        }
    }

    public function showAppointmentForm(Request $request)
    {
        try {
            $employeeAccountID = $this->is_verified($request);
            return view('admin.apptForm'); 
        } catch (\Exception $e) {
            \Log::error('Failed to load appointment form: ' . $e->getMessage());
            return redirect()->route('admin.login')->with('error', 'Failed to load the appointment form. Please try again later.');
        }
    }

    public function addAppointment(Request $request)
    {
        try {
            $employeeAccountID = $this->is_verified($request);

            $validator = Validator::make($request->all(), [
                'patientID' => 'required|exists:patients,id',
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

            //$is_verified = Employee::where('employee_account_id', $employeeAccountID)->firstOrFail();

            

                $appointment = new Appointment();
                $appointment->patient_id = $request->patientID;
                $appointment->appointment_type = $request->type;
                $appointment->appointment_date = $request->date;
                $appointment->appointment_time = $request->time;
                $appointment->requested_by_employee = $employeeAccountID;
                $appointment->status = "pending"; 
                $appointment->approved_time = null;
                $appointment->notes = $request->notes;

                $appointment->save();

                return redirect()->back()->with('add_appoinment_success', 'Appointment added successfully');
           
        } catch (\Exception $e) {
            \Log::error('Failed to add appointment: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to add appointment. Please try again later.')->withInput();
        }
    }

    public function getAllAppointment(Request $request)
    {
        try {
            $employeeAccountID = $this->is_verified($request);
        
            $appointments = Appointment::where('status', 'approved')
                           ->orderBy('appointment_date', 'desc')
                           ->paginate(10);

            $pendingAppointment = Appointment::where('status','pending')->count();
            return view("admin.appointment", compact('appointments','pendingAppointment'));
        } catch (\Exception $e) {
            \Log::error('Failed to retrieve appointments: ' . $e->getMessage());
            return redirect()->route('admin.login')->with('error', 'Failed to retrieve appointments. Please try again later.');
        }
    }
    
    public function getAppointmentDetails(Request $request, $id)
    {
        try {
            $this->is_verified($request); 
            $appointment = Appointment::with('patient')->findOrFail($id);
            return view("admin.apptDetails", compact('appointment'));
        } catch (\Exception $e) {
            \Log::error('Failed to retrieve appointment details: ' . $e->getMessage());
            return redirect()->route('admin.login')->with('error', 'Failed to retrieve appointment details. Please try again later.');
        }
    }
    
    public function validatePatientID($id)
    {
        try {
            $patient = Patient::find($id);

            if ($patient) {
                return response()->json(['exists' => true]);
            }

            return response()->json(['exists' => false]);
        } catch (\Exception $e) {
            \Log::error('Failed to validate patient ID: ' . $e->getMessage());
            return response()->json(['exists' => false, 'error' => 'An error occurred. Please try again later.'], 500);
        }
    }

    public function getPendingAppointment(Request $request)
    {
        try {
            $employeeAccountID = $this->is_verified($request);
        
            $appointments = Appointment::where('status', 'pending')
                ->with('patient')
                ->orderBy('created_at', 'desc')
                ->get()
                ->groupBy(function ($appointment) {
                    return $appointment->created_at->format('d/m/Y');
                });
        
            $employees = Employee::all();
        
            return view('admin.upcomingAppt', compact('appointments', 'employees'));
        } catch (\Exception $e) {
            \Log::error('Failed to retrieve pending appointments: ' . $e->getMessage());
            return redirect()->route('admin.login')->with('error', 'Failed to retrieve pending appointments. Please try again later.');
        }
    }
       
    public function assignCaregiver(Request $request, $id)
    {
        try {
            $this->is_verified($request); 
    
            $employee = Auth::guard('employee')->user()->load('role');
    
            if ($employee->role->role_name == "admin") {
                $appointment = Appointment::find($id);
    
                if ($appointment) {
                    // Assign the caregiver to the appointment
                    $appointment->assigned_employee_id = $request->caregiver_id;
                    $appointment->save();
    
                    // Retrieve the caregiver's information
                    $caregiver = Employee::find($request->caregiver_id);
    
                    // Respond with the caregiver's name in JSON (for AJAX requests)
                    return response()->json(['success' => true, 'caregiver_name' => $caregiver->name]);
                }
    
                // Respond if the appointment was not found
                return response()->json(['success' => false, 'message' => 'Appointment not found']);
            } else {
                // Respond with access denied if not an admin
                return response()->json(['success' => false, 'message' => 'You do not have permission to make this request.'], 403);
            }
        } catch (\Exception $e) {
            // Log the error and return a failure response
            \Log::error('Failed to assign caregiver: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to assign caregiver. Please try again later.'], 500);
        }
    }
    

    public function approveAppointment(Request $request, $id)
    {
        try {
            $this->is_verified($request); 
            $appointment = Appointment::find($id);
            if ($appointment) {
                if (!$appointment->assigned_employee_id) {
                    return response()->json(['success' => false, 'message' => 'Caregiver not assigned']);
                }
                $appointment->status = 'approved';
                $appointment->save();
                return response()->json(['success' => true]);
            }
            return response()->json(['success' => false, 'message' => 'Appointment not found']);
        } catch (\Exception $e) {
            \Log::error('Failed to approve appointment: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to approve appointment. Please try again later.'], 500);
        }
    }

    public function getAppointmentsDataForCircle()
    {
        try {
            $pendingCount = Appointment::where('status', 'pending')->count();
            $approvedCount = Appointment::where('status', 'approved')->count();
            $completedCount = Appointment::where('status', 'completed')->count();

            return response()->json([
                'pending' => $pendingCount,
                'approved' => $approvedCount,
                'completed' => $completedCount,
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to retrieve appointment data for circle: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to retrieve appointment data. Please try again later.'], 500);
        }
    }

    public function showAppointmentsOnCalendar()
    {
        try {
            $appointments = Appointment::select('appointment_type', 'appointment_time', 'appointment_date', 'patient_id')
                ->with('patient:id,name') 
                ->get()
                ->map(function ($appointment) {
                    return [
                        'title' => $appointment->patient->name, 
                        'start' => Carbon::parse($appointment->appointment_date)->toDateString()
                    ];
                });
        
            return response()->json($appointments);
        } catch (\Exception $e) {
            \Log::error('Failed to show appointments on calendar: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to show appointments on calendar. Please try again later.'], 500);
        }
    }

    public function getAppointmentsList(Request $request)
    {
        try {
            $appointments = Appointment::where('status', 'approved')->get();
        
            $events = $appointments->map(function ($appointment) {
                return [
                    'title' => $appointment->appointment_type . " with " . $appointment->patient->name,
                    'start' => $appointment->appointment_date . 'T' . $appointment->appointment_time,
                    'extendedProps' => [
                        'status' => $appointment->status
                    ]
                ];
            });
        
            return response()->json($events);
        } catch (\Exception $e) {
            \Log::error('Failed to retrieve appointments list: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to retrieve appointments list. Please try again later.'], 500);
        }
    }
    
    public function viewPatientDetails(Request $request, $id)
    {
        try {
            $this->is_verified($request);
        
            $appointment = Appointment::findOrFail($id);
        
            return redirect()->route('patientDetails', ['id' => $appointment->patient->id]);
        } catch (\Exception $e) {
            \Log::error('Failed to view patient details: ' . $e->getMessage());
            return redirect()->route('admin.login')->with('error', 'Failed to view patient details. Please try again later.');
        }
    }

    public function deleteAppointment(Request $request, $id)
    {
        try {
            // Ensure the user is verified
            $this->is_verified($request);
    
            // Get the authenticated employee using the 'employee' guard
            $employee = Auth::guard('employee')->user()->load('role');
    
            if ($employee->role->role_name == "admin") {
                $appointment = Appointment::findOrFail($id);
                $appointment->delete();
    
                return redirect()->back()->with('delete_appointment_success', 'Appointment deleted successfully.');
            } else {
                return redirect()->back()->with('delete_appointment_error', 'You do not have permission to delete this appointment.');
            }
    
        } catch (\Exception $e) {
            \Log::error('Error deleting appointment: ' . $e->getMessage());
    
            return redirect()->back()->with('delete_appointment_error', 'Failed to delete appointment. Please try again later.');
        }
    }
    
    
    
    
    

    public function completeAppointment(Request $request, $id)
    {
        try {
            $this->is_verified($request);
        
            $appointment = Appointment::findOrFail($id);
            $appointment->status = 'completed';
            $appointment->save();
    
            return redirect()->back()->with('appointment_complete_success', 'Appointment completed successfully.')->withInput();
                
        } catch (\Exception $e) {
            \Log::error('Error completing appointment: ' . $e->getMessage());
        
            return redirect()->back()->with('appointment_complete_error', 'Failed to complete appointment. Please try again later.');
        }
    }
    
    
}

