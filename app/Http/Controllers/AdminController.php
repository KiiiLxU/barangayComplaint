<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
}
