<?php

namespace App\Http\Controllers;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;

class ProjectController extends Controller
{
    

    // public function store(Request $request)
    // {
    //     // Validation des données
    //     $request->validate([
    //         'title' => 'required|string|max:255',
    //         'description' => 'required|string',
    //     ]);

    //     // Enregistrer le projet
    //     $project = new Project();
    //     $project->title = $request->title;
    //     $project->description = $request->description;
    //     $project->user_id = auth()->id(); // Associer le projet à l'utilisateur connecté
    //     $project->save();

    //     return redirect()->route('projects.index')->with('success', 'Project added successfully!');
    // }

    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // Création du projet
        $project = Project::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::id(), // Récupère l'ID de l'utilisateur connecté
        ]);

        return redirect()->back()->with('success', 'Projet ajouté avec succès !');
    }
}
