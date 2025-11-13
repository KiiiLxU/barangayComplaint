<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrgyOfficialController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (Auth::user()->role === 'kapitan') {
        return redirect(route('admin.dashboard'));
    } elseif (Auth::user()->role === 'kagawad') {
        return redirect(route('admin.kagawad-dashboard'));
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth'])->group(function () {
    Route::resource('complaints', ComplaintController::class);
    Route::post('/complaints/{complaint}/assign', [ComplaintController::class, 'assign'])->name('complaints.assign');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->middleware('admin')->name('admin.dashboard');
    Route::get('/admin/history', [AdminController::class, 'history'])->middleware('admin')->name('admin.history');
    Route::get('/admin/complaints/{id}/details', [AdminController::class, 'getComplaintDetails'])->middleware('admin')->name('admin.complaint.details');
    Route::resource('admin/officials', BrgyOfficialController::class, ['as' => 'admin'])->middleware('admin');
});

// Separate middleware for kagawad dashboard - only kagawads can access
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/kagawad-dashboard', [AdminController::class, 'kagawadDashboard'])->name('admin.kagawad-dashboard');
});



require __DIR__.'/auth.php';



