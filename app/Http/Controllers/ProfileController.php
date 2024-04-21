<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'apiKeys' => $request->user()->tokens,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function uploadAvatar(Request $request)
    {
        $this->validate($request, [
            'avatar' => ['required', 'file', "mimes:jpg,png", "dimensions:min_width=96,min_height=96"]
        ]);

        if($request->user()->avatar_path) {
            Storage::delete($request->user()->avatar_path);
        }

        $path = $request->file('avatar')->storePubliclyAs('avatars', Str::uuid());
        $request->user()->update(['avatar_path' => $path]);

        return Redirect::route('profile.edit');
    }

    public function destroyAvatar(Request $request)
    {
        Storage::delete($request->user()->avatar_path);
        $request->user()->update(['avatar_path' => null]);

        return Redirect::route('profile.edit');
    }
}
