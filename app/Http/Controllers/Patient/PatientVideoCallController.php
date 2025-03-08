<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Support\Facades\Log;
use App\Events\VideoCallFromPatientStarted;
use App\Events\VoiceCallNotificationToAdmin;
use App\Events\VoiceCallEndedFromPatient;
use Illuminate\Support\Facades\Auth;

class PatientVideoCallController extends Controller
{
    public function verifyLoginStatus(Request $request)
    {
        try {
            $patientAccountID = Auth::guard('patient')->id();
    
            if (!$patientAccountID) {
                throw new \Exception('User is not logged in.');
            }
    
            return $patientAccountID;
        } catch (\Exception $e) {
            \Log::error('Failed to verify login status: ' . $e->getMessage());
            throw $e; // Rethrow the exception to handle it in the calling method
        }
    }
    
    public function startVideoCall(Request $request, $employee_id)
    {
        try {
            \Log::info('Starting video call process for employee ID: ' . $employee_id);
    
            $patientAccountID = $this->verifyLoginStatus($request);
    
            \Log::info('Patient Account IDd: ' . $patientAccountID);
    
            // If the patient is not logged in, return an error response
            if (!$patientAccountID) {
                \Log::warning('Patient not logged in.');
                return redirect()->route('patient.login')->with('error', 'You must be logged in to initiate a video call.');
            }
    
            // Create or retrieve chat
            $chat = Chat::firstOrCreate(
                ['patient_id' => $patientAccountID, 'employee_id' => $employee_id]
            );
    
            // Log chat creation or retrieval
            \Log::info('Chat created or retrieved. Chat ID: ' . $chat->id);
    
            // Create the message
            $message = new Message([
                'chat_id' => $chat->id,
                'sender_type' => 'patient',
                'sender_id' => $patientAccountID,
                'message' => 'A Video Call has been initiated'
            ]);
    
            $message->save();
            \Log::info('Message saved for chat ID: ' . $chat->id);
    
            // Create a Daily.co room
            $roomUrl = $this->createDailyRoom();
    
            // Log room creation
            \Log::info('Daily.co room created. Room URL: ' . $roomUrl);
    
            // Save the room URL to the chat
            $chat->video_call_url = $roomUrl;
            $chat->save();
            \Log::info('Video call URL saved to chat ID: ' . $chat->id);
    
            // Trigger video call events
            event(new VideoCallFromPatientStarted($chat->id, $roomUrl));
            \Log::info('VideoCallFromPatientStarted event dispatched for chat ID: ' . $chat->id);
    
            event(new VoiceCallNotificationToAdmin($chat->id, $employee_id));
            \Log::info('VoiceCallNotificationToAdmin event dispatched for employee ID: ' . $employee_id);
            \Log::info('Daily API Key: ' . env('DAILY_API_KEY'));

            return view('patient.video_call', compact('roomUrl', 'employee_id', 'chat'));
    
        } catch (\Exception $e) {
            \Log::error('Error creating video call room: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to start the video call. Please try again later.');
        }
    }

    private function createDailyRoom()
    {
        
        $client = new Client();
        $response = $client->post('https://api.daily.co/v1/rooms', [
            'headers' => [
                'Authorization' => 'Bearer ' . env('DAILY_API_KEY'),
                'Content-Type' => 'application/json'
            ],
            'json' => [
                'properties' => [
                    'enable_chat' => true,
                    'enable_screenshare' => true,
                    'start_video_off' => true,
                    'start_audio_off' => false
                ]
                ],
            'verify' => false,
        ]);

        $data = json_decode($response->getBody(), true);
        return $data['url']; 
    }

    public function deleteRoom(Request $request)
    {
        $roomUrl = $request->input('roomUrl');
        $employee_id = $request->input('employee_id');

        if (!$roomUrl) {
            return response()->json(['error' => 'Room URL is required'], 400);
        }

        try {

            event(new VoiceCallEndedFromPatient($roomUrl, $employee_id));
            $roomName = basename(parse_url($roomUrl, PHP_URL_PATH));

            $client = new Client();
            $response = $client->delete('https://api.daily.co/v1/rooms/' . $roomName, [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('DAILY_API_KEY'),
                    'Content-Type' => 'application/json',
                ],
                'verify' => false,
            ]);

            return response()->json(['success' => 'Room deleted successfully']);
        } catch (\Exception $e) {
            \Log::error('Error deleting Daily.co room: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to delete room'], 500);
        }
    }
}
