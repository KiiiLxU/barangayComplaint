<?php

namespace App\Http\Controllers;

use App\Models\BrgyOfficial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrgyOfficialController extends Controller
{
    /**
     * Display a listing of barangay officials.
     */
    public function index()
    {
        $officials = BrgyOfficial::paginate(10);
        return view('admin.officials.index', compact('officials'));
    }

    /**
     * Show the form for creating a new official.
     */
    public function create()
    {
        return view('admin.officials.create');
    }

    /**
     * Store a newly created official in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'contact_no' => 'nullable|string|max:20',
            'purok_assigned' => 'nullable|integer|min:1',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('official_photos', 'public');
        }

        BrgyOfficial::create([
            'name' => $request->name,
            'position' => $request->position,
            'contact_no' => $request->contact_no,
            'purok_assigned' => $request->purok_assigned,
            'photo' => $photoPath,
        ]);

        return redirect()->route('admin.officials.index')->with('success', 'Official added successfully!');
    }

    /**
     * Show the form for editing the specified official.
     */
    public function edit(BrgyOfficial $official)
    {
        return view('admin.officials.edit', compact('official'));
    }

    /**
     * Update the specified official in the database.
     */
    public function update(Request $request, BrgyOfficial $official)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'contact_no' => 'nullable|string|max:20',
            'purok_assigned' => 'nullable|integer|min:1',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['name', 'position', 'contact_no', 'purok_assigned']);

        if ($request->hasFile('photo')) {
            if ($official->photo) {
                Storage::disk('public')->delete($official->photo);
            }
            $data['photo'] = $request->file('photo')->store('official_photos', 'public');
        }

        $official->update($data);

        return redirect()->route('admin.officials.index')->with('success', 'Official updated successfully!');
    }

    /**
     * Remove the specified official from the database.
     */
    public function destroy(BrgyOfficial $official)
    {
        if ($official->photo) {
            Storage::disk('public')->delete($official->photo);
        }

        $official->delete();

        return redirect()->route('admin.officials.index')->with('success', 'Official deleted successfully!');
    }
}
