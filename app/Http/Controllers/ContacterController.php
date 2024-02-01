<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Contacter;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ContacterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $messages = Contacter::all();
            return response()->json([
                'code_valide' => 200,
                'message' => 'La liste des messages a été bien récupérée.',
                'liste_des_messages' => $messages,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code_valide' => 500,
                'message' => 'Erreur lors de la récupération de la liste des messages.',
                'error' => $e->getMessage(),
            ]);
        }
        
    }

    // Contacter une patiente via WhatSapp
    public function redirigerWhatsApp($id)
    {
        try {
            if (!is_numeric($id)) {
                throw new Exception('L\'ID doit être numérique.');
            }

            $patiente = User::findOrFail($id);

            $numeroOriginal = $patiente->telephone;
            $numeroWhatsApp = preg_replace('/[^0-9]/', '', $numeroOriginal);

            if (empty($numeroWhatsApp)) {
                throw new Exception("Numéro de téléphone non valide. Numéro original : $numeroOriginal, Numéro nettoyé : $numeroWhatsApp");
            }

            $urlWhatsApp = "https://api.whatsapp.com/send?phone=$numeroWhatsApp";

            return redirect()->to($urlWhatsApp);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('whatsapp.patiente');
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
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
        try {
            $request->validate([
                'nom' => ['required', 'string'],
                'email' => ['required', 'email'],
                'message' => ['required', 'string'],
            ]);
            
            // Création d'un nouveau message
            Contacter::create($request->all());
            return response()->json([
                'code_valide' => 200,
                'message' => 'Votre message a été envoyé avec succès.',
            ]);
        } catch (\Exception $e) {
            // Gérer les erreurs avec un message approprié
            return response()->json([
                'code_valide' => 500,
                'message' => 'Erreur lors de l\'envoie du message.',
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Contacter $contacter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contacter $contacter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contacter $contacter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contacter $contacter)
{
    try {

        // Trouver le message par son ID
        $message = Contacter::find($contacter);
        // Vérifier si le message existe
        if (!$message) {
            return response()->json([
                'code_valide' => 404,
                'message' => 'Message non trouvé.',
            ], 404);
        }

        // Supprimer le message
        $message->delete();

        return response()->json([
            'code_valide' => 200,
            'message' => 'Le message a été supprimé avec succès.',
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'code_valide' => 500,
            'message' => 'Erreur lors de la suppression du message.',
            'error' => $e->getMessage(),
        ]);
    }
}

}
