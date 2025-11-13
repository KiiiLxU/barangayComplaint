<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Testing kagawad assignment logic:\n";

$user = App\Models\User::where('role', 'kagawad')->first();
echo "Kagawad user: " . $user->name . " (" . $user->email . ")\n";

$official = App\Models\BrgyOfficial::where('name', 'like', '%' . $user->name . '%')->first();
echo "Matching official: " . ($official ? $official->name : 'None') . "\n";

if ($official) {
    $complaints = App\Models\Complaint::where('assigned_official_id', $official->id)->count();
    echo "Assigned complaints: " . $complaints . "\n";
}

// Create a test complaint if none exist
$complaint = App\Models\Complaint::first();
if (!$complaint) {
    $resident = App\Models\User::where('role', 'resident')->first();
    if ($resident) {
        $complaint = App\Models\Complaint::create([
            'user_id' => $resident->id,
            'category' => 'Test',
            'details' => 'Test complaint for assignment',
            'sitio' => 'Test sitio',
            'status' => 'pending',
        ]);
        echo "Created test complaint ID: {$complaint->id}\n";
    }
}

// Test assignment
if ($complaint && $official) {
    $complaint->update([
        'assigned_official_id' => $official->id,
        'status' => 'in-progress',
        'status_updated_at' => now(),
    ]);
    echo "Assigned complaint ID {$complaint->id} to {$official->name}\n";
    echo "Complaint assigned_official_id after update: " . $complaint->assigned_official_id . "\n";

    // Check if kagawad can see it
    $assignedComplaints = App\Models\Complaint::where('assigned_official_id', $official->id)->count();
    echo "Kagawad now sees: " . $assignedComplaints . " complaints\n";

    // Test the dashboard method
    $user = App\Models\User::where('role', 'kagawad')->first();
    $official = App\Models\BrgyOfficial::where('name', 'like', '%' . $user->name . '%')->first();
    if ($official) {
        $dashboardComplaints = App\Models\Complaint::with(['user', 'assignedOfficial'])
            ->where('assigned_official_id', $official->id)
            ->latest()
            ->get();
        echo "Dashboard would show: " . $dashboardComplaints->count() . " complaints\n";
        echo "Complaint details:\n";
        foreach ($dashboardComplaints as $c) {
            echo "- ID: {$c->id}, Status: {$c->status}, Assigned Official ID: {$c->assigned_official_id}\n";
        }
    }
} else {
    echo "No complaint or official found to test assignment\n";
}
