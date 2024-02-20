<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonnelSante;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function validerInscription($id)
{
    try {
        $user = User::findOrFail($id);

        if ($user->role === 'personnelsante' && $user->statut_compte === 1) {
            return response()->json([
                'code_valide' => 200,
                'message' => "Ce compte est déjà validé, actif.",
            ], 200);
        }

        if ($user->role === 'personnelsante') {
            // Valider l'inscription en mettant à jour le statut
            $user->update(['statut_compte' => true]);

            // Envoi de l'email de confirmation
            Mail::send('emailValidation',[
                'nom' => $user->nom,
            ],
             function ($message) use ($user) {
                $message->to($user->email);
                $message->subject('Notification de validation d\'inscription');
            });

            return response()->json([
                'code_valide' => 200,
                'message' => "L'inscription du personnel de santé a été validée avec succès.",
            ], 200);

        } else {
            return response()->json([
                'code_valide' => 403,
                'message' => "Vous n'avez pas l'autorisation de valider l'inscription pour cet utilisateur.",
            ], 403);
        }
    } catch (\Exception $e) {
        return response()->json([
            'code_valide' => 500,
            'message' => "Une erreur s'est produite lors de la validation de l'inscription.",
            'erreur' => $e->getMessage(),
        ], 500);
    }
}

public function invaliderInscription($id)
{
    try {
        $user = User::findOrFail($id);

        if ($user->role === 'personnelsante' && $user->statut_compte === 0) {
            return response()->json([
                'code_valide' => 200,
                'message' => "Ce compte est déjà invalidé, inactif.",
            ], 200);
        }

        if ($user->role === 'personnelsante') {
            // Invalider l'inscription en mettant à jour le statut
            $user->update(['statut_compte' => false]);

            return response()->json([
                'code_valide' => 200,
                'message' => "Inscription invalidée avec succès.",
            ], 200);
        } else {
            return response()->json([
                'code_valide' => 403,
                'message' => "Vous n'avez pas l'autorisation d'invalider l'inscription pour cet utilisateur.",
            ], 403);
        }
    } catch (\Exception $e) {
        return response()->json([
            'code_valide' => 500,
            'message' => "Une erreur s'est produite lors de l'invalidation de l'inscription.",
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
        //
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
