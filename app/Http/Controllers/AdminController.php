<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Complaint;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        // Complaint statistics
        $totalComplaints = Complaint::count();
        $pendingComplaints = Complaint::where('status', 'pending')->count();
        $inProgressComplaints = Complaint::where('status', 'in-progress')->count();
        $resolvedComplaints = Complaint::where('status', 'resolved')->count();

        // Complaints management with search, filter, and pagination
        $query = Complaint::with('user');

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

        return view('admin.dashboard', compact(
            'totalComplaints',
            'pendingComplaints',
            'inProgressComplaints',
            'resolvedComplaints',
            'complaints'
        ));
    }

    public function history()
    {
        // Get all resolved complaints with pagination
        $resolvedComplaints = Complaint::with(['user', 'assignedAdmin'])
            ->where('status', 'resolved')
            ->latest('status_updated_at')
            ->paginate(15);

        return view('admin.history', compact('resolvedComplaints'));
    }

    public function getComplaintDetails($id)
    {
        $complaint = Complaint::with('user', 'assignedOfficial')->findOrFail($id);

        return response()->json([
            'category' => $complaint->category,
            'reported_by' => $complaint->user->name,
            'respondent' => $complaint->respondent,
            'purok' => $complaint->sitio,
            'status' => ucfirst(str_replace('-', ' ', $complaint->status)),
            'date' => $complaint->created_at->format('Y-m-d H:i:s'),
            'details' => $complaint->details,
            'photo' => $complaint->photo ? asset('storage/' . $complaint->photo) : null,
        ]);
    }

    public function kagawadDashboard()
    {
        $user = Auth::user();

        // Ensure only kagawads can access this dashboard
        if ($user->role !== 'kagawad') {
            abort(403, 'Unauthorized access. This dashboard is only for kagawads.');
        }

        // Find the BrgyOfficial record that corresponds to this kagawad user
        // Match by name exactly since user names are "Kagawad 1", "Kagawad 2", etc.
        $official = \App\Models\BrgyOfficial::where('name', $user->name)->first();

        if ($official) {
            // Get complaints assigned to this kagawad's official record
            $assignedComplaints = Complaint::with(['user', 'assignedOfficial'])
                ->where('assigned_official_id', $official->id)
                ->latest()
                ->paginate(10);

            $inProgressCount = Complaint::where('assigned_official_id', $official->id)
                ->where('status', 'in-progress')
                ->count();

            $resolvedCount = Complaint::where('assigned_official_id', $official->id)
                ->where('status', 'resolved')
                ->count();
        } else {
            // Fallback if no matching official found
            $assignedComplaints = collect([]);
            $inProgressCount = 0;
            $resolvedCount = 0;
        }

        return view('admin.kagawad-dashboard', compact(
            'assignedComplaints',
            'inProgressCount',
            'resolvedCount'
        ));
    }
}
