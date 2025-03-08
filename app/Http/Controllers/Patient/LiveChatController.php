<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Patient_Account;
use App\Models\EmployeeAccount;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Support\Facades\Log;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Auth;
use App\Events\NewConversationStarted;
use Illuminate\Support\Facades\Response;

class LiveChatController extends Controller
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
            Log::error('Failed to verify login status: ' . $e->getMessage());
            return redirect()->route('patient.login')->with('error', 'Session verification failed. Please log in again.');
        }
    }

    public function showLiveChatPage(Request $request)
    {
        try {
            // Step 1: Verify patient login status
            $patientAccountID = $this->verifyLoginStatus($request);
            
            \Log::info('Patient Account ID: ' . $patientAccountID);

            // Step 2: Find the patient associated with this account
            $patient = Patient_Account::where('id', $patientAccountID)->firstOrFail();
        
            // Step 3: Get all employees
            $employees = EmployeeAccount::all();
        
            // Initialize variables for chat and messages
            $selectedEmployeeId = $request->get('employee_id');
            $chat = null;
            $messages = [];
        
            if ($selectedEmployeeId) {
                $employeeExists = EmployeeAccount::where('id', $selectedEmployeeId)->exists();
                if (!$employeeExists) {
                    
                    return abort(404, 'Employee not found.');
                }
    
                $chat = Chat::where('patient_id', $patient->id)
                            ->where('employee_id', $selectedEmployeeId)
                            ->first();
        
                if (!$chat) {
                    $chat = Chat::create([
                        'patient_id' => $patient->id,
                        'employee_id' => $selectedEmployeeId,
                    ]);
                }
        
                // Step 6: Retrieve messages for this chat
                $messages = $chat->messages()->with('sender')->get();
            }
        
            // Step 7: Return the view with necessary data
            return view('patient.patientLiveChat', compact('employees', 'chat', 'messages', 'selectedEmployeeId'));
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            \Log::error('Error in showLiveChatPage: ' . $e->getMessage());
            return abort(404, 'Page not found.');
        }
    }
    

    
    public function sendMessage(Request $request, $chatId)
    {
        try {
            $patientAccountID = $this->verifyLoginStatus($request);
            
            \Log::info('Attempting to send message to chat ID: ' . $chatId . ' by patient ID: ' . $patientAccountID);

            $chat = Chat::findOrFail($chatId);
    
            $message = new Message();
            $message->chat_id = $chat->id;
            $message->sender_type = 'patient'; 
            $message->sender_id = $patientAccountID;
            $message->message = $request->input('message');
            $message->save();
    
            broadcast(new MessageSent($message))->toOthers();
    
            broadcast(new NewConversationStarted($chat))->toOthers();
    
            return response()->json(['status' => 'Message sent!']);
        } catch (\Exception $e) {
            \Log::error('Error in sendMessage: ' . $e->getMessage());
            return response()->json(['status' => 'Message sending failed!'], 500);
        }
    }
    
    public function getMessages($chat_id)
    {
        $messages = Message::where('chat_id', $chat_id)->orderBy('created_at', 'asc')->get();
        return response()->json(['messages' => $messages]);
    }
    
}
