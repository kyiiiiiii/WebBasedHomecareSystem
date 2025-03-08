<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\Patient;
use App\Models\Patient_Account;
use App\Models\Prescription_Request;
use Illuminate\Support\Facades\Auth;


class PatientPrescriptionController extends Controller
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

    public function showPrescriptionForm(Request $request)
    {
        try {
            $patientAccountID = $this->is_verified($request);
            
            if (!$patientAccountID) {
                return redirect()->route('patient.login'); 
            } else {
                $patientAccount = Patient_Account::findOrFail($patientAccountID);
                $patient = $patientAccount->patient;
                return view('patient.patientPrescription', compact("patient", "patientAccount"));
            }
        } catch (\Exception $e) {
            \Log::error('Failed to load prescription form: ' . $e->getMessage());
            return redirect()->route('patient.login')->with('error', 'Failed to load prescription form. Please try again later.');
        }
    }

    public function addPrescriptionRequest(Request $request)
    {
        $patientAccountID = $this->is_verified($request);
    
        $validator = Validator::make($request->all(), [
            //'p_id' => 'required|integer|exists:prescriptions,id',
            'p_id' => 'required|integer',
            'dosage' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'date' => 'required|date',
            'address1' => 'required|string|max:255',
            'address2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal' => 'required|string|max:10',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    
        try {
            $patient = Patient::where('patient_account_id', $patientAccountID)->firstOrFail();
    
            $prescription_request = new Prescription_Request();
            $prescription_request->patient_id = $patient->id;
            $prescription_request->patient_name = $patient->name;
            $prescription_request->contact = $patient->contact;
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
            $prescription_request->requested_by_patient = $patientAccountID;
    
            $prescription_request->save();
    
            return redirect()->back()->with('add_patient_prescription_success', 'Prescription request submitted successfully!');
        } catch (\Exception $e) {
            \Log::error('Failed to submit prescription request: ' . $e->getMessage());
            return redirect()->back()->with('add_patient_prescription_error', 'Failed to submit prescription request. Please try again.');
        }
    }
    public function showPrescriptionDetails(Request $request, $id)
    {
        try {
            $this->is_verified($request);

            $prescription = Prescription_Request::findOrFail($id);
            return view('patient.patientPrescriptionDetails', compact('prescription'));
        } catch (\Exception $e) {
            \Log::error('Failed to load prescription details: ' . $e->getMessage());
            return redirect()->route('patient.login')->with('error', 'Failed to load appointment details. Please try again later.');
        }
    }
}

