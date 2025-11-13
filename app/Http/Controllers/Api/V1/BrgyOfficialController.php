<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\BrgyOfficial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class BrgyOfficialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $officials = BrgyOfficial::with('complaints')->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $officials
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Only admins can create officials
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'purok_assigned' => 'nullable|string|max:255',
            'contact_no' => 'nullable|string|max:20',
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
            $photoPath = $request->file('photo')->store('officials', 'public');
        }

        $official = BrgyOfficial::create([
            'name' => $request->name,
            'position' => $request->position,
            'purok_assigned' => $request->purok_assigned,
            'contact_no' => $request->contact_no,
            'photo' => $photoPath,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Official created successfully',
            'data' => $official
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $official = BrgyOfficial::with('complaints')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $official
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Only admins can update officials
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $official = BrgyOfficial::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'position' => 'sometimes|required|string|max:255',
            'purok_assigned' => 'nullable|string|max:255',
            'contact_no' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $updateData = $request->only(['name', 'position', 'purok_assigned', 'contact_no']);

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($official->photo) {
                Storage::disk('public')->delete($official->photo);
            }
            $updateData['photo'] = $request->file('photo')->store('officials', 'public');
        }

        $official->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'Official updated successfully',
            'data' => $official
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        // Only admins can delete officials
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $official = BrgyOfficial::findOrFail($id);

        // Delete photo if exists
        if ($official->photo) {
            Storage::disk('public')->delete($official->photo);
        }

        $official->delete();

        return response()->json([
            'success' => true,
            'message' => 'Official deleted successfully'
        ]);
    }
}
