<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrgyOfficialController;
use App\Http\Controllers\ComplaintMessageController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (Auth::user()->role === 'kapitan') {
        return redirect(route('kapitan.dashboard'));
    } elseif (Auth::user()->role === 'kagawad') {
        return redirect(route('kagawad.dashboard'));
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
    Route::post('/complaints/{complaint}/send-message', [ComplaintMessageController::class, 'sendOfficialMessage'])->name('complaints.send-message');
    Route::get('/complaints/{complaint}/messages', [ComplaintMessageController::class, 'getMessages'])->name('complaints.messages');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/kapitan/dashboard', [AdminController::class, 'index'])->middleware('admin')->name('kapitan.dashboard');
    Route::get('/kapitan/history', [AdminController::class, 'history'])->middleware('admin')->name('kapitan.history');
    Route::get('/kapitan/complaints/{id}/details', [AdminController::class, 'getComplaintDetails'])->middleware('admin')->name('kapitan.complaint.details');
    Route::get('kapitan/officials', [BrgyOfficialController::class, 'index'])->name('kapitan.officials.index');
    Route::resource('kapitan/officials', BrgyOfficialController::class, ['as' => 'kapitan'])->except(['index'])->middleware('admin');
});

// Separate middleware for kagawad dashboard - only kagawads can access
Route::middleware(['auth'])->group(function () {
    Route::get('/kagawad/dashboard', [AdminController::class, 'kagawadDashboard'])->name('kagawad.dashboard');
});



require __DIR__.'/auth.php';



