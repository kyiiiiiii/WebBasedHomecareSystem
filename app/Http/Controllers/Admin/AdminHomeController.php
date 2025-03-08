<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Employee;
use App\Models\Prescription_Request;
use App\Models\Patient;
use App\Models\CareDelivery;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;  // Add this for logging
use Illuminate\Http\Request;

class AdminHomeController extends Controller
{
    public function verifyLoginStatus()
    {
        try {
            Log::info('Verifying employee login status...');  // Log login verification start

            $employeeAccountID = Auth::guard('employee')->id();

            if (!$employeeAccountID) {
                Log::warning('Employee not logged in or session expired.');  // Log failure to find employee session
                return redirect()->route('admin.login')->with('error', 'You must be logged in to access this page.');
            }

            Log::info('Employee login verified.', ['employeeAccountID' => $employeeAccountID]);  // Log successful login verification
            return $employeeAccountID;
        } catch (\Exception $e) {
            Log::error('Error during login status verification: ' . $e->getMessage());  // Log error during login verification
            return redirect()->route('admin.login')->withErrors('Session error: ' . $e->getMessage());
        }
    }

    public function showAdminHome(Request $request)
    {
        try {
            Log::info('Loading admin home page...');  // Log home page load start

            // Verify login status
            $employeeAccountID = $this->verifyLoginStatus();
            if (!$employeeAccountID) {
                Log::warning('EmployeeAccountID is null after login verification.');  // Log if employeeAccountID is not found
                return redirect()->route('admin.login')->with('error', 'You must be logged in to access this page.');
            }

            // Retrieve employee information
            $employee = Employee::where('employee_account_id', $employeeAccountID)->first();

            if (!$employee) {
                Log::error('Employee not found with employeeAccountID: ' . $employeeAccountID);  // Log employee not found error
                return redirect()->route('admin.login')->with('error', 'Employee not found.');
            }

            Log::info('Employee found.', ['employeeID' => $employee->id]);  // Log successful employee retrieval

            // Fetch counts for dashboard
            $totalPatients = Patient::count();
            $totalAppointments = Appointment::where('status', 'pending')->count();
            $totalPrescriptions = Prescription_Request::where('status', 'pending')->count();
            $totalEmployees = Employee::count();

            Log::info('Counts fetched for admin dashboard.', [
                'totalPatients' => $totalPatients,
                'totalAppointments' => $totalAppointments,
                'totalPrescriptions' => $totalPrescriptions,
                'totalEmployees' => $totalEmployees
            ]);

            // Fetch tasks for the logged-in employee
            $appointmentTasks = Appointment::where('assigned_employee_id', $employee->id)
                                            ->where('status', 'approved')
                                            ->get();

            $careDeliveryTasks = CareDelivery::where('assigned_employee', $employee->id)->get();

            Log::info('Tasks for employee fetched.', [
                'appointmentTasks' => count($appointmentTasks),
                'careDeliveryTasks' => count($careDeliveryTasks)
            ]);

            return view('admin.adminHome', compact(
                'totalPatients', 
                'totalAppointments', 
                'totalPrescriptions', 
                'totalEmployees', 
                'appointmentTasks', 
                'careDeliveryTasks'
            ));

        } catch (\Exception $e) {
            Log::error('Error displaying admin home: ' . $e->getMessage());  // Log error during admin home page load
            return redirect()->route('admin.login')->with('error', 'An unexpected error occurred while loading the admin home. Please try again later.');
        }
    }

    public function getAppointmentsByWeek()
    {
        try {
            Log::info('Fetching appointments grouped by week.');  // Log start of appointment fetch

            // Query to group appointments by week and count them
            $appointmentsByWeek = Appointment::selectRaw('COUNT(*) as count, WEEK(created_at) as week')
                ->groupBy('week')
                ->orderByRaw('WEEK(created_at)')
                ->get();

            Log::info('Appointments fetched by week.', ['appointmentCount' => count($appointmentsByWeek)]);  // Log successful fetch

            // Prepare data for JSON response
            $labels = $appointmentsByWeek->pluck('week');
            $data = $appointmentsByWeek->pluck('count');

            return response()->json([
                'labels' => $labels,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching appointments by week: ' . $e->getMessage());  // Log error during fetch
            return response()->json([
                'error' => 'Failed to retrieve appointments: ' . $e->getMessage()
            ], 500);
        }
    }
}
