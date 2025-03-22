<?php

namespace App\Http\Controllers;
use App\Models\Certification;

use Illuminate\Http\Request;

class CertificationsController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'certifications' => 'required',
        ]);
    
        $CertificationsArray = explode(',', $request->certifications);
        $user = auth()->user();
    
        foreach ($CertificationsArray as $certifName) {
            $certifName = trim($certifName); // Nettoyage des espaces
    
            // Vérifier si la certification existe déjà pour cet utilisateur
            $certification = Certification::firstOrCreate(
                ['name' => $certifName, 'user_id' => $user->id]
            );
        }
    
        return back()->with('success', 'Certifications mises à jour avec succès.');
    }
    
}
