<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\CareDelivery;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PatientCareDeliveryController extends Controller
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

    public function showCareDeliveryForm(Request $request)
    {
        try {
            $patientAccountID = $this->verifyLoginStatus($request);
            $patient = Patient::where('patient_account_id', $patientAccountID)->firstOrFail();
            return view('patient.requestCareDelivery', compact('patient'));
        } catch (\Exception $e) {
            \Log::error('Failed to load care delivery form: ' . $e->getMessage());
            return redirect()->route('welcome')->with('error', 'Failed to load care delivery form. Please try again later.');
        }
    }

    public function getPatientLocation($id)
    {
        try {
            $patient = Patient::findOrFail($id);
            return response()->json([
                'address_line_1' => $patient->address_line_1,
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to retrieve patient location: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to retrieve patient location. Please try again later.'], 500);
        }
    }

    public function addnewCareDeliveryRequest(Request $request, $id)
    {
        $patientAccountID = $this->verifyLoginStatus($request);
    
        $validator = Validator::make($request->all(), [
            'care_delivery_type' => 'required|string|max:50',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'notes' => 'nullable|string|max:1000',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    
        try {
            $patient = Patient::findOrFail($id);
    
            $caredelivery = new CareDelivery();
            $caredelivery->patient_id = $patient->id;
            $caredelivery->care_delivery_type = $request->care_delivery_type;
            $caredelivery->date = $request->date;
            $caredelivery->time = $request->time;
            $caredelivery->notes = $request->notes ?? null;
            $caredelivery->requested_by_patient_account = $patientAccountID;
            $caredelivery->status = 'pending';
            $caredelivery->save();
    
            return redirect()->back()->with('add_patient_careDelivery_success', 'Care delivery request successfully added.');
        } catch (\Exception $e) {
            \Log::error('Failed to add care delivery request: ' . $e->getMessage());
            return redirect()->back()->with('add_patient_careDelivery_error', 'Failed to add care delivery request. Please try again.');
        }
    }
    
    public function showCareDeliveryDetails(Request $request, $id)
    {
        try {
            $this->verifyLoginStatus($request);
            $careDelivery = CareDelivery::find($id);
            return view('patient.patientCareDeliveryDetails', compact('careDelivery'));
        } catch (\Exception $e) {
            \Log::error('Failed to load care delivery details: ' . $e->getMessage());
            return redirect()->route('welcome')->with('error', 'Failed to load care delivery details. Please try again later.');
        }
    }
}

