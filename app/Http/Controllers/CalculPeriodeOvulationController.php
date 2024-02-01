<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\CalculPeriodeOvulation;

class CalculPeriodeOvulationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function calculateOvulation(Request $request)
    {
        try {
            // Validation des paramètres de la requête
            $request->validate([
                'dateRegles' => ['required', 'date'],
                'dureeCycle' => ['required', 'integer' , 'min:1'],
            ]);

            // Extraction des paramètres de la requête
            $premierJourRegles = Carbon::parse($request->input('dateRegles'));
            $dureeCycle = $request->input('dureeCycle');

            // Calcul de la période d'ovulation
            $dateOvulationDebut = $premierJourRegles->copy()->addDays($dureeCycle - 14);
            $dateOvulationFin = $dateOvulationDebut->copy()->addDays(6);

            // Renvoi des résultats au format JSON
            return response()->json([
                'code_valide' => 500,
                'message' => 'Calcul de la periode d\'ovulation reussi.',
                'Le_début_de_votre_jour_ovulation' => $dateOvulationDebut->toDateString(),
                'Le_fin_de_votre_jour_ovulation' => $dateOvulationFin->toDateString(),
            ]);
        } catch (\Exception $e) {
            // Gestion des erreurs avec un message approprié
            return response()->json([
                'code_valide' => 500,
                'message' => 'Erreur lors du calcul de la période d\'ovulation.',
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CalculPeriodeOvulation $calculPeriodeOvulation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CalculPeriodeOvulation $calculPeriodeOvulation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CalculPeriodeOvulation $calculPeriodeOvulation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CalculPeriodeOvulation $calculPeriodeOvulation)
    {
        //
    }
}
