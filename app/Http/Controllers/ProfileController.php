<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Storage;


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
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

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

    public function show($username)
    {
        $user = User::where('name', $username)->firstOrFail();
        $connections = $user->connections;

        if (Auth::user()->name !== $user->name) {
            abort(403, "Accès interdit");
        }

        return view('user.profile', compact('user','connections'));
    }

    public function modifier()
    {
        return view('profile.modifier');
    }

    
    public function updateModifier(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'profile_picture' => 'nullable|image|max:2048',
            'name' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:1000',  
            'github_link' => 'nullable|url|max:255', 
            'description' => 'nullable|string|max:1000',
            'certification' => 'nullable|string|max:1000',
        ]);

        if ($request->hasFile('profile_picture')) {
            // Supprimer l'ancienne image si elle existe
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            $imagePath = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $imagePath;
        }

        // Mets à jour les champs du profil si nécessaire
        if ($request->filled('name')) {
            $user->name = $request->name;
        }
        if ($request->filled('bio')) {
            $user->bio = $request->bio;
        }
        if ($request->filled('github_link')) {
            $user->github_link = $request->github_link;
        }
        if ($request->filled('description')) {
            $user->description = $request->description;
        }
        if ($request->filled('certification')) {
            $user->certification = $request->certification;
        }
      

        $user->save();

        // Redirige vers la page du profil avec un message de succès
        return redirect()->route('profile.show', ['username' => $user->name])
            ->with('success', 'Profil mis à jour avec succès.');
    }
}
