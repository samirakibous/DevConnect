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
        // Chercher l'utilisateur par son nom d'utilisateur
        $user = User::where('name', $username)->firstOrFail();

        // Vérifier si l'utilisateur connecté est celui dont on cherche le profil
        if (Auth::user()->name !== $user->name) {
            abort(403, "Accès interdit");
        }

        // Afficher la vue du profil
        return view('user.profile', compact('user'));
    }

    public function modifier()
    {
        // Tu peux envoyer ici des données supplémentaires, comme les informations actuelles du profil
        return view('profile.modifier');
    }

    // Met à jour les informations du profil
    public function updateModifier(Request $request)
    {
        $user = auth()->user();  // Récupère l'utilisateur authentifié

        // Valide les données du formulaire, y compris les nouveaux champs
        $request->validate([
            'profile_picture' => 'nullable|image|max:2048',  // Validation de l'image
            'name' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:1000',  // Validation de la bio
            'github_link' => 'nullable|url|max:255',  // Validation du lien GitHub
            'description' => 'nullable|string|max:1000',  // Validation de la description
            'competences' => 'nullable|string|max:255',
        ]);

        // Si l'image de profil est fournie, on la sauvegarde
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
        if ($request->filled('competences')) {
            $user->competences = $request->competences;
        }

        // Sauvegarde l'utilisateur modifié
        $user->save();

        // Redirige vers la page du profil avec un message de succès
        return redirect()->route('profile.show', ['username' => $user->name])
            ->with('success', 'Profil mis à jour avec succès.');
    }
}
