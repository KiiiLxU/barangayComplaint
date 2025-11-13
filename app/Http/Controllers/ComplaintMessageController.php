<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\ComplaintMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplaintMessageController extends Controller
{
    /**
     * Send an official message to the complainant.
     */
    public function sendOfficialMessage(Request $request, Complaint $complaint)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        // Check if the current user is authorized (kagawad, kapitan, or admin)
        $allowedRoles = ['admin', 'kagawad', 'kapitan'];
        if (!in_array(Auth::user()->role, $allowedRoles)) {
            abort(403, 'Unauthorized action.');
        }

        // Create the message
        ComplaintMessage::create([
            'complaint_id' => $complaint->id,
            'sender_id' => Auth::id(),
            'message' => $request->message,
            'message_type' => 'official',
        ]);

        return redirect()->back()->with('success', 'Message sent successfully.');
    }

    /**
     * Get messages for a complaint (for residents to view official messages).
     */
    public function getMessages(Complaint $complaint)
    {
        // Only the complainant or authorized officials can view messages
        $allowedRoles = ['admin', 'kagawad', 'kapitan'];
        if (Auth::id() !== $complaint->user_id && !in_array(Auth::user()->role, $allowedRoles)) {
            abort(403, 'Unauthorized action.');
        }

        $messages = $complaint->messages()
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }
}
