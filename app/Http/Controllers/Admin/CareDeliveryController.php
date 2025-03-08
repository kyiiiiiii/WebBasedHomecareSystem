<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Company;
use App\Models\CareDelivery;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class CareDeliveryController extends Controller
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

    public function showCareDeliveryPage()
    {
        try {
            $this->verifyLoginStatus();
        
            $caredeliveries = CareDelivery::paginate(10); 
        
            return view('admin.careDelivery', compact('caredeliveries'));
        } catch (\Exception $e) {
            \Log::error('Failed to load care delivery page: ' . $e->getMessage());
            return redirect()->route('admin.login')->with('error', 'Failed to load the care delivery page. Please try again later.');
        }
    }
    
    public function showCareDeliveryDetails($id)
    {
        try {
            
            $careDelivery = CareDelivery::with('patient')->findOrFail($id);
            return view("admin.careDeliveryDetails",compact('careDelivery'));
        } catch (\Exception $e) {
            \Log::error($id);
            \Log::error('Failed to load care delivery details: ' . $e->getMessage());
            return redirect()->route('admin.login')->with('error', 'Failed to load care delivery details. Please try again later.');
        }
    }
    public function updateCareDeliveryDetails($id)
    {
        try{
            $careDelivery = CareDelivery::findOrFail($id);

            $careDelivery->status = "approved";
    
            $careDelivery->save();
    
            return redirect()->back()->with('success_approve', 'Care delivery status updated successfully.');

        }catch(\Exception $e){
            \Log::error($id);
            \Log::error('Failed to load care delivery details: ' . $e->getMessage());
            return redirect()->route('admin.login')->with('error', 'Failed to load care delivery details. Please try again later.');
        }
    }
    public function completeCareDeliveryDetails($id)
    {
        try{
            $careDelivery = CareDelivery::findOrFail($id);

            $careDelivery->status = "completed";
    
            $careDelivery->save();
    
            return redirect()->back()->with('success_complete', 'Care delivery status updated successfully.');

        }catch(\Exception $e){
            \Log::error($id);
            \Log::error('Failed to load care delivery details: ' . $e->getMessage());
            return redirect()->route('admin.login')->with('error', 'Failed to load care delivery details. Please try again later.');
        }
    }
    public function getCareDeliveryAddress($id)
    {
        try {
            $careDelivery = CareDelivery::with('patient')->findOrFail($id);
        
            $company = Company::findOrFail(1); 
        
            return response()->json([
                'address' => $careDelivery->patient->address_line_1,
                'company_address' => $company->address,
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to retrieve care delivery address: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to retrieve care delivery address. Please try again later.'], 500);
        }
    }

    public function deleteCareDeliveryRequest(Request $request, $id)
    {
        try {
            $this->verifyLoginStatus($request);

            $employee = Auth::guard('employee')->user()->load('role');

            if ($employee->role->role_name == "admin") {
                $careDelivery = CareDelivery::findOrFail($id);
                $careDelivery->delete();
    
                return redirect()->back()->with('delete_careDelivery_success', 'care delivery request deleted successfully, 1 item deleted.');
            } else {
                return redirect()->back()->with('delete_careDelivery_error', 'You do not have permission to delete this request.');
            }
            
        } catch (\Exception $e) {
            \Log::error('Error deleting careDelivery request: ' . $e->getMessage());
    
            return redirect()->back()->with('delete_careDelivery_error', 'Failed to delete request. Please try again later.');
        }
    }
}

