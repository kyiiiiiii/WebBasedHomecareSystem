<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Chat;
use App\Events\MessageSent;
use App\Events\employeeToPatient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminChatController extends Controller
{
    public function verifyLoginStatus(Request $request)
    {
        try {
            $employeeAccountID = Auth::guard('employee')->id();
    
            if (!$employeeAccountID) {
                // Throw an exception if the user is not logged in
                throw new \Exception('User is not logged in.');
            }
    
            return $employeeAccountID;
        } catch (\Exception $e) {
            \Log::error('Failed to verify login status: ' . $e->getMessage());
            throw $e;  // Rethrow the exception to handle it in the calling method
        }
    }
    

    public function showChatPage(Request $request)
    {
        $employeeAccountID = $this->verifyLoginStatus($request);
    
        // Retrieve chats where the current employee has communicated with patients
        $chats = Chat::where('employee_id', $employeeAccountID)
            ->with(['messages' => function($query) {
                $query->orderBy('created_at', 'desc');
            }, 'patient'])
            ->get();
    
        // Get the first chat or set it to null if none exists
        $chat = $chats->first() ?? null;
    
        return view('admin.liveChat', [
            'chats' => $chats,
            'chat' => $chat, // Pass the $chat variable to the view
            'employeeAccountID' => $employeeAccountID,
        ]);
    }
    
    

    public function sendMessage(Request $request, $chat_id)
    {
        try {
            // Verify the login status of the employee
            $employeeAccountID = $this->verifyLoginStatus($request);
    
            // Find the chat by ID or fail
            $chat = Chat::findOrFail($chat_id);
    
            // Create the message
            $message = new Message();
            $message->chat_id = $chat->id;
            $message->sender_type = 'employee';
            $message->sender_id = $employeeAccountID;
            $message->message = $request->input('message');
            $message->save();
    
            // Broadcast the message
            broadcast(new MessageSent($message))->toOthers();
            broadcast(new employeeToPatient($chat))->toOthers();
    
            // Return success response
            return response()->json(['status' => 'Message Sent!']);
        } catch (\Exception $e) {
            \Log::error('Error sending message: ' . $e->getMessage());
            return response()->json(['status' => 'Failed to send message', 'error' => $e->getMessage()], 500);
        }
    }
    
    public function getMessages($chat_id)
    {
        try {
            // Retrieve all messages for the given chat ID
            $messages = Message::where('chat_id', $chat_id)->orderBy('created_at', 'asc')->get();
    
            // Return the messages as JSON
            return response()->json(['messages' => $messages]);
        } catch (\Exception $e) {
            \Log::error('Error retrieving messages: ' . $e->getMessage());
            return response()->json(['status' => 'Failed to retrieve messages', 'error' => $e->getMessage()], 500);
        }
    }
    

}

