<?php

namespace App\Http\Controllers;

use App\Models\PersonnelSante;
use Illuminate\Http\Request;
use App\Models\User;
 

class PersonnelSanteController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     //liste personnel de santé invalidé
     public function index()
{
    try {
        $tab = [];
        $personnelsDeSante = PersonnelSante::all();
        foreach($personnelsDeSante as $PSInvalide){
            if($PSInvalide->user->statut_compte === 0){
                $tab[] = $PSInvalide;
            }
        }
            
        return response()->json([
            'code_valide' => 200,
            'message' =>  'La liste des personnels de santé avec un statut de compte invalidé a été bien récupérée.',
            'liste_des_personnels_de_sante' => $tab,
        ]);
    } catch (\Exception $e) { 
        return response()->json([
            'code_valide' => 500,
            'message' => 'Une erreur s\'est produite lors de la récupération des personnels de santé.',
            'erreur' => $e->getMessage(),
        ], 500);
    }
}

  
    //liste personnel de santé Validé
    public function listevalide()
{
    try {
        $tab = [];
        $personnelsDeSante = PersonnelSante::all();
        foreach($personnelsDeSante as $PSInvalide){
            if($PSInvalide->user->statut_compte === 1){
                $tab[] = $PSInvalide;
            }
        }
            
        return response()->json([
            'code_valide' => 200,
            'message' =>  'La liste des personnels de santé avec un statut de compte validé a été bien récupérée.',
            'liste_des_personnels_de_sante' => $tab,
        ]);
    } catch (\Exception $e) { 
        return response()->json([
            'code_valide' => 500,
            'message' => 'Une erreur s\'est produite lors de la récupération des personnels de santé.',
            'erreur' => $e->getMessage(),
        ], 500);
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
        
        // Validation des données
        $request->validate([
            'prenom' => ['required', 'string', 'min:3', 'max:80'],
            'nom' => ['required', 'string', 'min:2', 'max:50'],
            'telephone' => ['required', 'string', 'max:20'],
            'adresse' => ['required', 'string', 'min:5', 'max:60'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'max:30'],
            'specialite' => ['required', 'string', 'min:2', 'max:100'],
            'nom_structure' => ['required','string'],
        ]);
        

        // Création de l'utilisateur
        $user = User::create([
            'prenom' => $request->prenom,
            'nom' => $request->nom,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'personnelsante',
        ]);

        // Création du personnel de santé lié à l'utilisateur
        $personnelSante = $user->personnelSante()->create([
            'specialite' => $request->specialite,
            'nom_structure' => $request->nom_structure,
        ]);

        // if ($personnelSante) {
        //     return response()->json([
        //         "message" => "Personnel de santé créé avec succès",
        //     ], 200);
        // } else {
        //     // En cas d'échec, supprimer l'utilisateur précédemment créé
        //     $user->delete();

        //     return response()->json([
        //         "message" => "Personnel de santé non enregistré",
        //     ], 500);
        // }

        if ($personnelSante) {
            return response()->json([
                "code_valide" => 200,
                "message" => "Votre demande d'inscription a été soumise avec succès. Attendez la validation de l'administrateur.",
            ], 200);
        } else {
            // En cas d'échec, supprimer l'utilisateur précédemment créé
            $user->delete();
    
            return response()->json([
                "code_valide" => 500,
                "message" => "Une erreur s'est produite lors de l'inscription.",
            ], 500);
        }
    }

//     //Valider l'inscription du personnel de santé par l'admin
//     public function approveAccount(Request $request, $id)
// {
//     $personnelSante = PersonnelSante::findOrFail($id);
//     $personnelSante->update(['validated' => true]);

//     return response()->json([
//         "message" => "Compte personnel de santé approuvé avec succès",
//     ], 200);
// }

//     //Valider l'inscription du personnel de santé
//     public function validercompte(Request $request, $id)
// {
//     $personnelSante = PersonnelSante::findOrFail($id);
//     $personnelSante->update(['statut_compte' => true]);

//     return response()->json([
//         "message" => "Inscription approuvée avec succès",
//     ], 200);
// }

// public function invalidercompte(Request $request, $id)
// {
//     $personnelSante = PersonnelSante::findOrFail($id);
//     $personnelSante->update(['statut_compte' => false]);

//     return response()->json([
//         "message" => "Inscription invalidée avec succès",
//     ], 200);
// }



    /**
     * Display the specified resource.
     */
    public function show(PersonnelSante $personnelSante)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PersonnelSante $personnelSante)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PersonnelSante $personnelSante)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PersonnelSante $personnelSante)
    {
        //
    }
}
