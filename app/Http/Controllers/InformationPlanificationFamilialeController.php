<?php

namespace App\Http\Controllers;

use App\Models\Information_Planification_Familiale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InformationPlanificationFamilialeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // Récupérer toutes les informations de la base de données
            $information = Information_Planification_Familiale::all();

            // Retourner la liste des ressources en tant que réponse JSON
            return response()->json([
                'code_valide' => 200,
                'message' => 'Liste des informations de planification familiale a été bien récupérée, avec succès.',
                'liste_des_ressources' => $information,
            ]);
        } catch (\Exception $e) {
            // Gérer les erreurs avec un message approprié
            return response()->json([
                'code_valide' => 500,
                'message' => 'Erreur lors de la récupération de la liste des informations de planification familiale.',
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titre' => ['required', 'string'],
            'texte' => ['required', 'string'],
            'image' => ['image', 'mimes:jpeg,png,jpg,gif'],
        ]);

    $information = new Information_Planification_Familiale();
        $information->titre = $request->titre;
        $information->texte = $request->texte;

        if ($request->file('image')) {
            $imageFile = $request->file('image');
            $filename = date('YmdHi') . $imageFile->getClientOriginalName();
            $imageFile->move(public_path('images'), $filename);
            $information->image = $filename;
        }

        $information->admin_id = Auth::id(); 

        $information->save();

        if ($information->id) {
            return response()->json([
                
    
                'code_valide' => 200,
                'message' => 'Les informations sur la planification familiale a été enregistrée avec succès.',
            ]);
        } else {
            
  
            return response()->json([
                'code_valide' => 500,
                'message' => 'Échec de l\'enregistrement de la information$information de planification familiale.',
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Information_Planification_Familiale $information_Planification_Familiale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Information_Planification_Familiale $information_Planification_Familiale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Information_Planification_Familiale $information_Planification_Familiale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Information_Planification_Familiale $information_Planification_Familiale)
    {
        //
    }
}
