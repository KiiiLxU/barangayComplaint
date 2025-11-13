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
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Complaint::with('user');

        $allowedRoles = ['admin', 'kagawad', 'kapitan'];
        if (!in_array($user->role, $allowedRoles)) {
            // User sees only their complaints
            $query->where('user_id', $user->id);
        }

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('category', 'like', "%{$search}%")
                  ->orWhere('details', 'like', "%{$search}%")
                  ->orWhere('sitio', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Pagination
        $complaints = $query->latest()->paginate(10);

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
        // Only allow users to edit their own complaints, not admins
        $allowedRoles = ['admin', 'kagawad', 'kapitan'];
        if (in_array(Auth::user()->role, $allowedRoles) || Auth::id() !== $complaint->user_id) {
            abort(403, 'Unauthorized action.');
        }
        return view('complaints.edit', compact('complaint'));
    }

    /**
     * Update the specified complaint in the database.
     */
    public function update(Request $request, Complaint $complaint)
    {
        $this->authorizeAccess($complaint);

        // Check if this is a status-only update (from admin dashboard)
        if ($request->has('status') && !$request->has('category')) {
            $request->validate([
                'status' => 'required|in:pending,in-progress,resolved',
            ]);
            $data = $request->only(['status']);
        } else {
            $request->validate([
                'category' => 'required|string|max:100',
                'details' => 'required|string',
                'sitio' => 'nullable|string|max:255',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'status' => 'in:pending,in-progress,resolved',
            ]);
            $data = $request->only(['category', 'details', 'sitio', 'status']);
        }

        // Check if status is being updated
        if ($complaint->status !== $request->status) {
            $data['status_updated_at'] = now();
            $allowedRoles = ['admin', 'kagawad', 'kapitan'];
            if (in_array(Auth::user()->role, $allowedRoles)) {
                $data['assigned_admin_id'] = Auth::id(); // Assign current admin
            }
        }

        if ($request->hasFile('photo')) {
            if ($complaint->photo) {
                Storage::disk('public')->delete($complaint->photo);
            }
            $data['photo'] = $request->file('photo')->store('complaint_photos', 'public');
        }

        $complaint->update($data);

        $allowedRoles = ['admin', 'kagawad', 'kapitan'];
        $redirectRoute = in_array(Auth::user()->role, $allowedRoles) ? 'admin.dashboard' : 'complaints.index';
        return redirect()->route($redirectRoute)->with('success', 'Complaint updated successfully!');
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
        $allowedRoles = ['admin', 'kagawad', 'kapitan'];
        if (!in_array(Auth::user()->role, $allowedRoles) && Auth::id() !== $complaint->user_id) {
            abort(403, 'Unauthorized action.');
        }
    }
}
