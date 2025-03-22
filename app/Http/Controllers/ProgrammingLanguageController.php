<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;

class ProgrammingLanguageController extends Controller
{
    public function store(Request $request)
    {
        // Validation
        $validated = $request->validate([
            'langages' => 'required|string', // Vérifie que c'est bien une chaîne
        ]);
    
        // Transformer la chaîne en tableau (suppression des espaces inutiles)
        $langagesArray = array_map('trim', explode(',', $request->langages));
    
        $langagesIds = [];
        foreach ($langagesArray as $langage) {
            $langage = Language::firstOrCreate(['name' => $langage]);
            $langagesIds[] = $langage->id;
        }
    
        // Associer les langages à l'utilisateur connecté
        $user = auth()->user();
        $user->languages()->sync($langagesIds);
    
        return redirect()->back()->with('success', 'Langages mis à jour avec succès.');
    }
    

}
