<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PersonnelSante;
use App\Http\Requests\storePersonnelSanteRequest;
 

class PersonnelSanteController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     //liste personnel de santé invalidé
     public function index()
{
    try {

        $personnelsDeSante = PersonnelSante::with('user:id,nom,email,telephone,role')->get();

        return response()->json([
            'code_valide' => 200,
            'message' => 'La liste des personnels de santé a été bien récupérée.',
            'liste_des_personnels_de_sante' => $personnelsDeSante,
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
    public function store(storePersonnelSanteRequest $request)
{

    try {
        // Création de l'utilisateur avec le rôle "personnelsante"
        $user = User::create([
            'nom' => $request->nom,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'telephone' => $request->telephone,
            'role' => 'personnelsante',
        ]);

        // Création du personnel de santé lié à l'utilisateur
        $personnelSante = $user->personnelSante()->create([
            'matricule' => $request->matricule,
            'structure' => $request->structure,
            'service' => $request->service,
        ]);

        if ($personnelSante) {
            return response()->json([
                "code_valide" => 200,
                "message" => "Votre demande d'inscription a été soumise avec succès. Attendez la validation de l'administrateur et vous recevrez un mail avant de vous connecter a la plateforme. Merci de bien vouloir consulter votre boite mail pour vous connecter.",
            ], 200);
        } else {
            // En cas d'échec, supprimer l'utilisateur précédemment créé
            $user->delete();

            return response()->json([
                "code_valide" => 500,
                "message" => "Une erreur s'est produite lors de l'inscription.",
            ], 500);
        }
    } catch (\Exception $e) {
        return response()->json([
            "code_valide" => 500,
            "message" => "Une erreur s'est produite lors de l'inscription.",
            "error" => $e->getMessage(),
        ], 500);
    }
}


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
