<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\EcgData;
use App\Models\Patient;
use App\Events\PatientBpmUpdated;
use Illuminate\Support\Facades\Auth;

class PatientEcgController extends Controller
{
    
    public function store(Request $request)
    {
        try {
            $bpmValue = $request->input('ecg_value');
            $patientId = 1;  
    
            \Log::info('Received BPM data', ['patient_id' => $patientId, 'bpm_value' => $bpmValue]);


            event(new PatientBpmUpdated($bpmValue, $patientId));

            \Log::info('Dispatching event with BPM data', ['bpm_value' => $bpmValue, 'patient_id' => $patientId]);

    
            return response()->json([
                'status' => 'success',
                'message' => 'BPM value received successfully',
                'bpm_value' => $bpmValue,
            ]);
    
        } catch (\Exception $e) {
            \Log::error('Error processing request', ['exception' => $e->getMessage()]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while processing the request',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
}
