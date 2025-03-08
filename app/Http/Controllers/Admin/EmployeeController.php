<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\EmployeeAccount;
use App\Models\CareDelivery;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use DateTime;

class EmployeeController extends Controller
{
    public function verifyLoginStatus()
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

    public function getEmployeedata()
    {
        try {
            $this->verifyLoginStatus();
            $employees = Employee::paginate(10);
            $totalEmployees = Employee::count();
            $employee = Auth::guard('employee')->user()->load('role');
            if ($employee->role->role_name == "admin") {
                return View("admin.empInfo",compact('employees','totalEmployees'));
            }else {
                // If the user is not an admin, you can redirect or show a specific view/message
                return redirect()->route('access.denied')->with('error', 'Access denied. Only admins can view employee data.');
            }
           
        } catch (\Exception $e) {
            \Log::error('Failed to retrieve employee data: ' . $e->getMessage());
            return redirect()->route('access.denied')->with('error', 'Failed to retrieve employee data. Please try again later.');
        }
    }

    public function showEmployeeDetails($id)
    {
        try {
            $this->verifyLoginStatus();
            
            $employee = Auth::guard('employee')->user()->load('role');

            if ($employee->role->role_name == "admin") {
                $employee = Employee::findOrFail($id);
                return view('admin.empDetails', compact('employee'));
            }else {
                // If the user is not an admin, you can redirect or show a specific view/message
                return redirect()->route('access.denied')->with('error', 'Access denied. Only admins can view employee data.');
            }
            
        } catch (\Exception $e) {
            \Log::error('Failed to retrieve employee details: ' . $e->getMessage());
            return redirect()->route('access.denied')->with('error', 'Failed to retrieve employee details. Please try again later.');
        }
    }

    public function showEmployeeForm()
    {
        try {
            return view('admin.empForm');
        } catch (\Exception $e) {
            \Log::error('Failed to load employee form: ' . $e->getMessage());
            return redirect()->route('admin.login')->with('error', 'Failed to load employee form. Please try again later.');
        }
    }
    
    public function addEmployee(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'empName' => 'required|string|max:255',
                'birthdate' => 'required|date',
                'gender' => 'required|in:male,female',
                'religion' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'state' => 'required|string|max:255',
                'city' => 'required|string|max:255',
                'empEmail' => 'required|email|max:255',
                'contact' => 'required|string|max:255',
                'Econtact' => 'required|string|max:255',
                'department' => 'required|string|max:255',
                'Ename' => 'required|string|max:255',
                'admissionDate' => 'required|date',
                'role' => 'required|string|max:255',
                'race' => 'required|string|max:255',
                'type' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
            }

            $employee = new Employee;
            $employee->name = $request->empName;
            $employee->dob = $request->birthdate;
            $employee->gender = $request->gender;
            $employee->religion = $request->religion;
            $employee->address = $request->address;
            $employee->state = $request->state;
            $employee->city = $request->city;
            $employee->email = $request->empEmail;
            $employee->contact_number = $request->contact;
            $employee->emergency_contact_number = $request->Econtact;
            $employee->department = $request->department;
            $employee->emergency_contact_name = $request->Ename;
            $employee->admission_date = $request->admissionDate;
            $employee->role = $request->role;
            $employee->race = $request->race;
            $employee->type = $request->type;
            $employee->save();

            return redirect()->route('showEmpForm')->with('success', 'Employee added successfully.');
        } catch (\Exception $e) {
            \Log::error('Failed to add employee: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to add employee. Please try again later.')->withInput();
        }
    }

    public function getEmployeeDataForDoughnut()
    {
        try {
            $fullTimeCount = Employee::where('type', 'Fulltime')->count();
            $partTimeCount = Employee::where('type', 'Parttime')->count();
        
            return response()->json([
                'fullTime' => $fullTimeCount,
                'partTime' => $partTimeCount,
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to retrieve employee data for doughnut chart: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to retrieve data. Please try again later.'], 500);
        }
    }

    public function updateNewEmployeePicture(Request $request, $id)
    {
        try {
            $employee = Employee::findOrFail($id);
        
            $request->validate([
                'profile_image' => 'required',
            ]);
        
            $rawBase64ImageData = $request->profile_image;
            $imageData = base64_decode(preg_replace('/^data:image\/\w+;base64,/', '', $rawBase64ImageData));
            $employee->profile_image = $imageData;
            $employee->save();
        
            return back()->with('image_success', 'Profile image updated successfully.');
        } catch (\Exception $e) {
            \Log::error('Failed to update employee picture: ' . $e->getMessage());
            return back()->with('error', 'Failed to update profile image. Please try again later.');
        }
    }

    public function getEmployeeDataLine(Request $request)
    {
        try {
            $hiresAndResignations = Employee::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('SUM(CASE WHEN status = "retain" THEN 1 ELSE 0 END) as new_hires'),
                DB::raw('SUM(CASE WHEN status = "resign" THEN 1 ELSE 0 END) as resignations')
            )
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

            return response()->json($hiresAndResignations);
        } catch (\Exception $e) {
            \Log::error('Failed to retrieve employee data line: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to retrieve data. Please try again later.'], 500);
        }
    }

    public function updateEmployeeData(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'dob' => 'required|date',
            'state' => 'required|string|max:100',
            'gender' => 'required|string|max:50',
            'religion' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'race' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'contact_number' => 'required|string|max:15',
            'emergency_contact_number' => 'required|string|max:15',
            'emergency_contact_name' => 'required|string|max:100',
        ]);
        
        try {
            $employee = Employee::findOrFail($id);
            $employee->name = $validatedData['name'];
            $employee->dob = $validatedData['dob'];
            $employee->race = $validatedData['race'];
            $employee->gender = $validatedData['gender'];
            $employee->religion = $validatedData['religion'];
            $employee->address = $validatedData['address'];
            $employee->state = $validatedData['state'];
            $employee->city = $validatedData['city'];
            $employee->email = $validatedData['email'];
            $employee->contact_number = $validatedData['contact_number'];
            $employee->emergency_contact_number = $validatedData['emergency_contact_number'];
            $employee->emergency_contact_name = $validatedData['emergency_contact_name'];
            $employee->save();
            
            return redirect()->back()->with('success', 'Employee data updated successfully.');
        } catch (\Exception $e) {
            \Log::error('Failed to update employee data: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update employee data. Please try again.');
        }
    }


    public function deleteEmployee(Request $request, $id)
    {
        try {
            $this->verifyLoginStatus(); 

            $employee = Auth::guard('employee')->user()->load('role');
    
            if ($employee->role->role_name == "admin") {
                $employee = Employee::findOrFail($id);
                if ($employee->employeeAccount) {
                    $employee->employeeAccount()->delete();
                }
                if ($employee->caregiverProfile) {
                    $employee->caregiverProfile()->delete();
                }
                $employee->delete();
    
                return redirect()->back()->with('delete_employee_success', 'Employee deleted successfully.');
            } else {
                return redirect()->back()->with('delete_employee_error', 'You do not have permission to delete this information.');
            }
    
            return redirect()->back()->with('delete_employee_success', 'Employee deleted successfully.');
    
        } catch (\Exception $e) {
            \Log::error('Error deleting employee: ' . $e->getMessage());
            return redirect()->back()->with('delete_employee_error', 'Failed to delete employee. Please try again later.');
        }
    }
}

