<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validated();

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            // Store new photo
            $data['photo'] = $request->file('photo')->store('profile_photos', 'public');

            // If user is a kagawad or kapitan, update their corresponding barangay official record
            if (in_array($user->role, ['kagawad', 'kapitan'])) {
                $official = \App\Models\BrgyOfficial::where('name', $user->getOriginal('name'))->first();
                if ($official) {
                    $updateData = [];

                    // Sync name if it was changed
                    if ($user->wasChanged('name')) {
                        $updateData['name'] = $user->name;
                    }

                    // Sync photo if it was uploaded
                    if (isset($data['photo'])) {
                        // Delete old official photo if exists
                        if ($official->photo) {
                            Storage::disk('public')->delete($official->photo);
                        }
                        $updateData['photo'] = $data['photo'];
                    }

                    if (!empty($updateData)) {
                        $official->update($updateData);
                    }
                }
            }
        }

        $user->fill($data);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // If user is a kagawad or kapitan, update their corresponding barangay official record
        if (in_array($user->role, ['kagawad', 'kapitan'])) {
            $official = \App\Models\BrgyOfficial::where('name', $user->getOriginal('name'))->first();
            if ($official) {
                $updateData = [];

                // Sync name if it was changed
                if ($user->wasChanged('name')) {
                    $updateData['name'] = $user->name;
                }

                // Sync photo if it was uploaded
                if (isset($data['photo'])) {
                    // Delete old official photo if exists
                    if ($official->photo) {
                        Storage::disk('public')->delete($official->photo);
                    }
                    $updateData['photo'] = $data['photo'];
                }

                if (!empty($updateData)) {
                    $official->update($updateData);
                }
            }
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
