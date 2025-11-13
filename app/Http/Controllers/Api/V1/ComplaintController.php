<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\ComplaintLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->role === 'admin') {
            $complaints = Complaint::with(['user', 'assignedOfficial'])->paginate(15);
        } else {
            $complaints = Complaint::where('user_id', $user->id)
                ->with(['user', 'assignedOfficial'])
                ->paginate(15);
        }

        return response()->json([
            'success' => true,
            'data' => $complaints
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'purok' => 'nullable|string|max:255',
            'street' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('complaints', 'public');
        }

        $complaint = Complaint::create([
            'user_id' => $request->user()->id,
            'category' => $request->category,
            'description' => $request->description,
            'purok' => $request->purok,
            'street' => $request->street,
            'photo' => $photoPath,
            'status' => 'pending',
        ]);

        // Log the complaint creation
        ComplaintLog::create([
            'complaint_id' => $complaint->id,
            'action' => 'created',
            'notes' => 'Complaint submitted',
            'performed_by' => $request->user()->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Complaint created successfully',
            'data' => $complaint->load(['user', 'assignedOfficial'])
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $complaint = Complaint::with(['user', 'assignedOfficial', 'logs'])->findOrFail($id);

        // Check if user can view this complaint
        if ($request->user()->role !== 'admin' && $complaint->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => $complaint
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $complaint = Complaint::findOrFail($id);

        // Check permissions
        if ($request->user()->role !== 'admin' && $complaint->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'category' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'purok' => 'nullable|string|max:255',
            'street' => 'nullable|string|max:255',
            'status' => 'sometimes|required|in:pending,investigating,resolved,closed',
            'assigned_official_id' => 'nullable|exists:brgy_officials,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $oldStatus = $complaint->status;
        $updateData = $request->only(['category', 'description', 'purok', 'street', 'status', 'assigned_official_id']);

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($complaint->photo) {
                Storage::disk('public')->delete($complaint->photo);
            }
            $updateData['photo'] = $request->file('photo')->store('complaints', 'public');
        }

        $complaint->update($updateData);

        // Log status changes
        if (isset($updateData['status']) && $oldStatus !== $updateData['status']) {
            ComplaintLog::create([
                'complaint_id' => $complaint->id,
                'action' => 'status_changed',
                'notes' => "Status changed from {$oldStatus} to {$updateData['status']}",
                'performed_by' => $request->user()->id,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Complaint updated successfully',
            'data' => $complaint->load(['user', 'assignedOfficial'])
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $complaint = Complaint::findOrFail($id);

        // Only admins can delete complaints
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        // Delete photo if exists
        if ($complaint->photo) {
            Storage::disk('public')->delete($complaint->photo);
        }

        $complaint->delete();

        return response()->json([
            'success' => true,
            'message' => 'Complaint deleted successfully'
        ]);
    }
}
