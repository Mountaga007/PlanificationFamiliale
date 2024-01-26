<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UtilisateurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $utilisateur = User:: all() -> where('role', 'utilisateur');
            return response()->json([
                'code_valide' => 200,
                'message' => 'La liste des utilisateurs a été bien récupérée.',
                'liste_des_utilisateurs' => $utilisateur
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code_valide' => 500,
                'message' => 'Une erreur s\'est produite lors de la récupération des utilisateurs.',
                'erreur' => $e->getMessage()
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
        $request->validate([
            'prenom' => ['required', 'string', 'min:3', 'max:80'],
            'nom' => ['required', 'string', 'min:2', 'max:50'],
            'telephone' => ['required', 'string', 'max:20'],
            'adresse' => ['required', 'string', 'min:5', 'max:60'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'max:30'],
        ]);

        $utilisateur = new User();
        $utilisateur -> prenom = $request -> prenom;
        $utilisateur -> nom = $request -> nom;
        $utilisateur -> telephone = $request -> telephone;
        $utilisateur -> adresse = $request -> adresse;
        $utilisateur -> email = $request -> email;
        $utilisateur -> password = $request -> password;
       if($utilisateur -> save()){
        
        return response()->json([
            "message" => "Utilisateur créer avec succéss"
        ], 200);
       } else{
        return response()->json([
            "message" => "Utilisateur non enregistrer"
        ], 500);
       }
    }

public function redirigerWhatsApp($id)
{
    try {
        // Validation de l'ID comme étant numérique
        if (!is_numeric($id)) {
            throw new Exception('L\'ID doit être numérique.');
        }

        // Recherche de l'utilisateur
        $user = User::findOrFail($id);

        // Vérification si l'utilisateur a un rôle de "personnelsante"
        if ($user->role === 'personnelsante') {
            $numeroWhatsApp = $user->telephone;
            $urlWhatsApp = "https://api.whatsapp.com/send?phone=$numeroWhatsApp";

            return redirect()->to($urlWhatsApp);
        } else {
            throw new Exception('Cet utilisateur n\'est pas un personnel de santé.');
        }
    } catch (ModelNotFoundException $e) {
        return redirect()->route('whatsapp'); 
    } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
