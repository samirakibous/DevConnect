<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Competence;
use Illuminate\Support\Facades\Auth;


class CompetenceController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();
    
        // Valider la requête
        $request->validate([
            'competences' => 'required|array',
            'competences.*' => 'string|max:255'
        ]);
    
        // Vérifier les erreurs de validation
        if ($request->fails()) {
            dd($request->errors());
        }
        
        // Synchroniser les compétences de l'utilisateur (ajout/suppsion autoassur
        $competences = [];
        foreach ($request->competences as $comp) {
            $competences[] = Competence::firstOrCreate(['nom' => $comp])->id;
        }
    
        dd($competences); // Vérifie que les compétences sont créées
        
        $user->competences()->sync($competences); 
        
        return response()->json(['message' => 'Compétences mises à jour avec succès !']);
    }
    


}
