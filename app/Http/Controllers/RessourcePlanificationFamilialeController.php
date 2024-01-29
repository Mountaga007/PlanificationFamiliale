<?php

namespace App\Http\Controllers;

use App\Models\Ressource_Planification_familiale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RessourcePlanificationFamilialeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // Récupérer toutes les ressources de la base de données
            $ressources = Ressource_Planification_familiale::all();

            // Retourner la liste des ressources en tant que réponse JSON
            return response()->json([
                'code_valide' => 200,
                'message' => 'Liste des ressources de planification familiale a été bien récupérée, avec succès.',
                'liste_des_ressources' => $ressources,
            ]);
        } catch (\Exception $e) {
            // Gérer les erreurs avec un message approprié
            return response()->json([
                'code_valide' => 500,
                'message' => 'Erreur lors de la récupération de la liste des ressources de planification familiale.',
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

    $ressource = new Ressource_Planification_familiale();
        $ressource->titre = $request->titre;
        $ressource->texte = $request->texte;

        if ($request->file('image')) {
            $imageFile = $request->file('image');
            $filename = date('YmdHi') . $imageFile->getClientOriginalName();
            $imageFile->move(public_path('images'), $filename);
            $ressource->image = $filename;
        }

        $ressource->admin_id = Auth::id(); 

        $ressource->save();

        if ($ressource->id) {
            return response()->json([
                
    
                'code_valide' => 200,
                'message' => 'La ressource de planification familiale a été enregistrée avec succès.',
            ]);
        } else {
            
  
            return response()->json([
                'code_valide' => 500,
                'message' => 'Échec de l\'enregistrement de la ressource de planification familiale.',
            ]);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Ressource_Planification_familiale $ressource_Planification_familiale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ressource_Planification_familiale $ressource_Planification_familiale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ressource_Planification_familiale $ressource_Planification_familiale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ressource_Planification_familiale $ressource_Planification_familiale)
    {
        //
    }
}
