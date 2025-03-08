<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prescription_Request;
use App\Models\Patient;
use App\Models\Employee;
use App\Models\Company;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminPrescriptionController extends Controller
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
            return redirect()->route("admin.login")->with('error', 'Session verification failed. Please log in again.');
        }
    }
    

    public function showPrescriptionPage(Request $request)
    {
        try {
            $employeeAccountID = $this->is_verified($request);

            $prescriptions = Prescription_Request::orderBy('prescription_date','desc')
                            ->paginate(40);
            $totalPendingPrescription = Prescription_Request::where("status","pending")->count();

            return view('admin.prescriptionDelivery', compact('prescriptions','totalPendingPrescription'));
        } catch (\Exception $e) {
            \Log::error('Failed to load prescription page: ' . $e->getMessage());
            return redirect()->route('admin.login')->with('error', 'Failed to load the prescription page. Please try again later.');
        }
    }

    public function showPrescriptionRequestForm(Request $request)
    {
        try {
            $employeeAccountID = $this->is_verified($request);
            return view("admin.prescriptionForm");
        } catch (\Exception $e) {
            \Log::error('Failed to load prescription request form: ' . $e->getMessage());
            return redirect()->route('admin.login')->with('error', 'Failed to load the prescription request form. Please try again later.');
        }
    }

    public function addAdminPrescriptionRequest(Request $request)
    {
        try {
            $employeeAccountID = $this->is_verified($request);
        
            $validator = Validator::make($request->all(), [
                'p_id' => 'required|integer',
                'dosage' => 'required|string|max:255',
                'quantity' => 'required|integer|min:1',
                'date' => 'required|date',
                'address1' => 'required|string|max:255',
                'address2' => 'nullable|string|max:255',
                'city' => 'required|string|max:255',
                'state' => 'required|string|max:255',
                'postal' => 'required|string',
            ]);
        
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('add_admin_prescription_failed', 'Validation failed. Please check the inputs.');
            }
        
            //$employee = Employee::where('id', $employeeAccountID)->firstOrFail();
        
            $prescription_request = new Prescription_Request;
            $prescription_request->patient_id = $request->id;
            $prescription_request->patient_name = $request->name;
            $prescription_request->contact = $request->contact;
            $prescription_request->prescription_id = $request->input('p_id');
            $prescription_request->dosage = $request->input('dosage');
            $prescription_request->quantity_requested = $request->input('quantity');
            $prescription_request->prescription_date = $request->input('date');
            $prescription_request->address_line1 = $request->input('address1');
            $prescription_request->address_line2 = $request->input('address2');
            $prescription_request->city = $request->input('city');
            $prescription_request->state = $request->input('state');
            $prescription_request->postal_code = $request->input('postal');
            $prescription_request->status = 'pending';
            $prescription_request->requested_by_employee = $employeeAccountID;
        
            $prescription_request->save();
        
            return redirect()->back()->with('add_admin_prescription_success', 'Prescription request submitted successfully!');
    
        } catch (\Exception $e) {
            \Log::error('Failed to submit prescription request: ' . $e->getMessage());
            return redirect()->back()->with('add_admin_prescription_failed', 'Failed to submit prescription request. Please try again later.');
        }
    }
    
    public function showPrescriptionDetails($id)
    {
        try {
            $prescription = Prescription_Request::with('patient')->findOrFail($id);
            return view("admin.prescriptionDetails", compact('prescription'));
        } catch (\Exception $e) {
            \Log::error('Failed to load prescription details: ' . $e->getMessage());
            return redirect()->route('admin.login')->with('error', 'Failed to load the prescription details. Please try again later.');
        }
    }

    public function getPrescriptionAddress($id)
    {
        try {
            $prescription = Prescription_Request::with('patient')->findOrFail($id);
            $company = Company::findOrFail(1);
    
            return response()->json([
                'address' => $prescription->address_line1,
                'company_address' => $company->address,
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to retrieve prescription address: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to retrieve prescription address. Please try again later.'
            ], 500);
        }
    }
    
    public function approvePrescription($id)
    {
        try {
            $prescription = Prescription_Request::with('patient')->findOrFail($id);
            $prescription->status = 'approved';
            $prescription->save();
            return redirect()->back()->with('approved', 'Approved Successfully.');
        } catch (\Exception $e) {
            \Log::error('Failed to approve prescription: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to approve the prescription. Please try again later.');
        }
    }
    public function completePrescription($id)
    {
        try {
            $prescription = Prescription_Request::with('patient')->findOrFail($id);
            $prescription->status = 'completed';
            $prescription->save();
            return redirect()->back()->with('completed', 'Updated.');
        } catch (\Exception $e) {
            \Log::error('Failed to complete prescription: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to complete the prescription. Please try again later.');
        }
    }

    public function deletePrescriptionRequest(Request $request, $id)
    {
        try {
            $this->is_verified($request);

            $employee = Auth::guard('employee')->user()->load('role');

            if ($employee->role->role_name == "admin") {
                $appointment = Prescription_Request::findOrFail($id);
                $appointment->delete();
                
                return redirect()->back()->with('delete_prescription_success', 'Prescription request deleted successfully.');
            } else {
                return redirect()->back()->with('delete_prescription_error', 'You do not have permission to delete this request.');
            }
            
        } catch (\Exception $e) {
            \Log::error('Error deleting prescription: ' . $e->getMessage());
    
            return redirect()->back()->with('delete_prescription_error', 'Failed to delete prescription. Please try again later.');
        }
    }
}
