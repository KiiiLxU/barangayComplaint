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
        // Only the complainant, assigned official, or authorized officials can view messages
        $allowedRoles = ['admin', 'kagawad', 'kapitan'];
        $isComplainant = Auth::id() === $complaint->user_id;
        $isAssignedOfficial = $complaint->assigned_official_id && Auth::id() === $complaint->assignedOfficial->user_id;
        $hasRole = in_array(Auth::user()->role, $allowedRoles);

        if (!$isComplainant && !$isAssignedOfficial && !$hasRole) {
            abort(403, 'Unauthorized action.');
        }

        $messages = $complaint->messages()
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }

    /**
     * Update a message sent by the current user.
     */
    public function updateMessage(Request $request, ComplaintMessage $message)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        // Only the sender can edit their message
        if ($message->sender_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $message->update([
            'message' => $request->message,
        ]);

        return response()->json(['success' => true, 'message' => 'Message updated successfully.']);
    }
}
