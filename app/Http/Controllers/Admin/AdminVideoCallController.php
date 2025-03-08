<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Support\Facades\Log;
use App\Events\VideoCallFromAdminStarted;
use App\Events\VoiceCallNotificationToPatient;
use App\Events\VoiceCallEndedFromAdmin;
use Illuminate\Support\Facades\Auth;

class AdminVideoCallController extends Controller
{
    public function verifyLoginStatus(Request $request)
    {
        try {
            $employeeAccountID = Auth::guard('employee')->id();

            if (!$employeeAccountID) {
                return redirect()->route('admin.login')->with('error', 'You must be logged in to access this page.');
            }
        
            return $employeeAccountID;
        } catch (\Exception $e) {
            \Log::error('Failed to verify login status: ' . $e->getMessage());
            return redirect()->route('patient.login')->with('error', 'Session verification failed. Please log in again.');
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
                    'start_audio_off' => false,
                    
                ]
                ],
            'verify' => false,
        ]);

        $data = json_decode($response->getBody(), true);
        return $data['url']; 
    }

    public function startVideoCall(Request $request, $patient_id)
    {
        try {

            $employeeAccountID = $this->verifyLoginStatus($request);
            \Log::info('Verified Admin Account ID: ' . $employeeAccountID);
    
            $chat = Chat::firstOrCreate(
                ['patient_id' => $patient_id, 'employee_id' => $employeeAccountID]
            );
            \Log::info('Chat found or created. Chat ID: ' . $chat->id);
    
            $message = new Message([
                'chat_id' => $chat->id,
                'sender_type' => 'employee',
                'sender_id' => $employeeAccountID,
                'message' => 'An Video Call has been initiated'
            ]);
            $message->save();
            \Log::info('Video call initiation message saved.');
    
            $roomUrl = $this->createDailyRoom();
            \Log::info('Video call room created. Room URL: ' . $roomUrl);
    
            $chat->video_call_url = $roomUrl;
            $chat->save();
            \Log::info('Video call URL saved to chat.');
    

            event(new VideoCallFromAdminStarted($chat->id, $roomUrl));
            event(new VoiceCallNotificationToPatient($roomUrl, $patient_id));

            \Log::info('VideoCallFromAdminStarted event dispatched.');
    
            return view('admin.adminVideoCall', compact('roomUrl','patient_id','chat'));
    
        } catch (\Exception $e) {
            \Log::error('Error starting video call: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to start the video call. Please try again later.');
        }
    }
    
    
    
    public function deleteRoom(Request $request)
    {
        $roomUrl = $request->input('roomUrl');
        $patient_id = $request->input('patient_id');
        event(new VoiceCallEndedFromAdmin($roomUrl,$patient_id));
        if (!$roomUrl) {
            return response()->json(['error' => 'Room URL is required'], 400);
        }

        try {
            // Extract the room name from the URL
            $roomName = basename(parse_url($roomUrl, PHP_URL_PATH));

            $client = new Client();
            $response = $client->delete('https://api.daily.co/v1/rooms/' . $roomName, [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('DAILY_API_KEY'),
                    'Content-Type' => 'application/json',
                ],
                'verify' => false,
            ]);

           
            \Log::info('Room Url was Deleted Meeting was ended');

            return response()->json(['success' => 'Room deleted successfully']);
        } catch (\Exception $e) {
            \Log::error('Error deleting Daily.co room: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to delete room'], 500);
        }
    }

    
}
