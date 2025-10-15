<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('settings.index', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'currency' => ['required', 'string', 'max:10'],
            'language' => ['required', 'string', 'max:10'],
            'timezone' => ['required', 'string', 'max:100'],
            'date_format' => ['required', 'string', 'max:20'],
        ]);

        $user->update($validated);

        return redirect()->route('settings.index')
            ->with('success', 'Profile settings updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'string', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();
        $user->password = Hash::make($validated['password']);
        $user->save();

        return redirect()->route('settings.index')
            ->with('success', 'Password updated successfully.');
    }

    public function updatePreferences(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'theme' => ['required', 'string', Rule::in(['light', 'dark', 'system'])],
            'notifications' => ['required', 'boolean'],
            'email_notifications' => ['required', 'boolean'],
            'default_view' => ['required', 'string', Rule::in(['dashboard', 'transactions', 'reports'])],
            'transaction_reminders' => ['required', 'boolean'],
            'monthly_report' => ['required', 'boolean'],
        ]);

        $user->preferences()->updateOrCreate(
            ['user_id' => $user->id],
            $validated
        );

        return redirect()->route('settings.index')
            ->with('success', 'Preferences updated successfully.');
    }

    public function updateSecurity(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'two_factor_enabled' => ['required', 'boolean'],
            'login_notifications' => ['required', 'boolean'],
            'session_timeout' => ['required', 'integer', 'min:5', 'max:120'],
        ]);

        $user->security_settings()->updateOrCreate(
            ['user_id' => $user->id],
            $validated
        );

        return redirect()->route('settings.index')
            ->with('success', 'Security settings updated successfully.');
    }

    public function updateProfilePicture(Request $request)
    {
        $request->validate([
            'new_profile_picture' => ['required', 'image', 'max:2048'], // Max 2MB
        ]);

        $user = Auth::user();

        // Delete old profile picture if exists
        if ($user->profile_picture) {
            Storage::disk('public')->delete($user->profile_picture);
        }

        // Store new profile picture
        $path = $request->file('new_profile_picture')->store('profile-pictures', 'public');

        $user->profile_picture = $path;
        $user->save();

        return redirect()->route('settings.index')
            ->with('success', 'Profile picture updated successfully.');
    }

    public function deleteProfilePicture()
    {
        $user = Auth::user();

        if ($user->profile_picture) {
            Storage::disk('public')->delete($user->profile_picture);
            $user->profile_picture = null;
            $user->save();
        }

        return redirect()->route('settings.index')
            ->with('success', 'Profile picture deleted successfully.');
    }
} 