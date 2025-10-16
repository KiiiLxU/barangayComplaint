<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the user's complaints (for normal user)
     * or all complaints (for admin).
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            // Admin sees all complaints
            $complaints = Complaint::with('user')->latest()->get();
        } else {
            // User sees only their complaints
            $complaints = Complaint::where('user_id', $user->id)->latest()->get();
        }

        return view('complaints.index', compact('complaints'));
    }

    /**
     * Show the form for creating a new complaint.
     */
    public function create()
    {
        return view('complaints.create');
    }

    /**
     * Store a newly created complaint in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string|max:100',
            'details' => 'required|string',
            'sitio' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $photoPath = null;

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('complaint_photos', 'public');
        }

        Complaint::create([
            'user_id' => Auth::id(),
            'category' => $request->category,
            'details' => $request->details,
            'sitio' => $request->sitio,
            'photo' => $photoPath,
            'status' => 'pending',
        ]);

        return redirect()->route('complaints.index')->with('success', 'Complaint submitted successfully!');
    }

    /**
     * Show the form for editing a specific complaint (user or admin).
     */
    public function edit(Complaint $complaint)
    {
        $this->authorizeAccess($complaint);
        return view('complaints.edit', compact('complaint'));
    }

    /**
     * Update the specified complaint in the database.
     */
    public function update(Request $request, Complaint $complaint)
    {
        $this->authorizeAccess($complaint);

        $request->validate([
            'category' => 'required|string|max:100',
            'details' => 'required|string',
            'sitio' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'in:pending,in review,resolved',
        ]);

        $data = $request->only(['category', 'details', 'sitio', 'status']);

        if ($request->hasFile('photo')) {
            if ($complaint->photo) {
                Storage::disk('public')->delete($complaint->photo);
            }
            $data['photo'] = $request->file('photo')->store('complaint_photos', 'public');
        }

        $complaint->update($data);

        return redirect()->route('complaints.index')->with('success', 'Complaint updated successfully!');
    }

    /**
     * Remove the specified complaint.
     */
    public function destroy(Complaint $complaint)
    {
        $this->authorizeAccess($complaint);

        if ($complaint->photo) {
            Storage::disk('public')->delete($complaint->photo);
        }

        $complaint->delete();

        return redirect()->route('complaints.index')->with('success', 'Complaint deleted successfully!');
    }

    /**
     * Helper: Ensure only the owner or admin can modify a complaint.
     */
    private function authorizeAccess(Complaint $complaint)
    {
        if (Auth::user()->role !== 'admin' && Auth::id() !== $complaint->user_id) {
            abort(403, 'Unauthorized action.');
        }
    }
}
