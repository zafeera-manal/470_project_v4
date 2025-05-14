<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Events\MessageSent; // Import the MessageSent event
use App\Models\User; // Import the User model

class MessageController extends Controller
{
    /**
     * store a new message and broadcast it to the receiver
     *
     * @param \Illuminate\Http\Request $request
     * @param int $receiver_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendMessage(Request $request, $receiver_id)
    {
        
        $validated = $request->validate([
            'message' => 'required|string|max:255', 
        ]);

        
        $message = Message::create([
            'sender_id' => auth()->id(), 
            'receiver_id' => $receiver_id, 
            'message' => $request->message, 
        ]);

        
        broadcast(new MessageSent($message)); 
       
        return redirect()->route('messages.fetch', $receiver_id)->with('success', 'Message sent!');
    }

    /**
     * Fetch all messages between the user and receiver.
     *
     * @param int $receiver_id
     * @return \Illuminate\View\View
     */
    public function fetchMessages($receiver_id)
    {
        
        $messages = Message::where(function($query) use ($receiver_id) {
            $query->where('sender_id', auth()->id())
                  ->where('receiver_id', $receiver_id);
        })
        ->orWhere(function($query) use ($receiver_id) {
            $query->where('sender_id', $receiver_id)
                  ->where('receiver_id', auth()->id());
        })
        ->orderBy('created_at', 'asc')  
        ->get();
    
        
        $receiver = User::findOrFail($receiver_id); 
    
        
        return view('messages.chat', compact('messages', 'receiver'));
    }
    
}
