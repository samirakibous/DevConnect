<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Competence;
use App\Models\User;


class CompetenceController extends Controller
{
    public function store(Request $request)
    {


        // Vérifier que le champ est bien un tableau
        $validated = $request->validate([
            'competences' => 'required',
        ]);
        $competencesArray = explode(',', $request->competences);

        $competencesIds = [];
        foreach ($competencesArray as $competence) {
            $competence = Competence::firstOrCreate(['name' => $competence]);
            $competencesIds[] = $competence->id;
        }
        $user = auth()->user();
        $user->competences()->sync($competencesIds);

        // Synchroniser les compétences avec l'utilisateur
        $user->competences;

        return back()->with('success', 'Compétences mises à jour avec succès.');
    }
}
