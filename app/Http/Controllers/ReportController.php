<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\BrgyOfficial;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ComplaintsExport;

class ReportController extends Controller
{
    /**
     * Generate PDF report of complaints.
     */
    public function pdf(Request $request)
    {
        $query = Complaint::with(['user', 'assignedOfficial']);

        // Apply filters
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        if ($request->has('category') && !empty($request->category)) {
            $query->where('category', $request->category);
        }

        if ($request->has('date_from') && !empty($request->date_from)) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && !empty($request->date_to)) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $complaints = $query->get();

        $pdf = Pdf::loadView('reports.complaints_pdf', compact('complaints'));
        return $pdf->download('complaints_report.pdf');
    }

    /**
     * Generate Excel report of complaints.
     */
    public function excel(Request $request)
    {
        return Excel::download(new ComplaintsExport($request->all()), 'complaints_report.xlsx');
    }

    /**
     * Show reports dashboard.
     */
    public function index()
    {
        // Statistics for reports
        $totalComplaints = Complaint::count();
        $resolvedComplaints = Complaint::where('status', 'resolved')->count();
        $pendingComplaints = Complaint::where('status', 'pending')->count();

        // Category breakdown
        $categories = Complaint::selectRaw('category, COUNT(*) as count')
            ->groupBy('category')
            ->get();

        // Monthly statistics (last 12 months)
        $monthlyStats = Complaint::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        return view('admin.reports.index', compact(
            'totalComplaints',
            'resolvedComplaints',
            'pendingComplaints',
            'categories',
            'monthlyStats'
        ));
    }
}
