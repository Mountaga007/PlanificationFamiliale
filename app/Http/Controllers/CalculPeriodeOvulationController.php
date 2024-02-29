<?php

namespace App\Http\Controllers;

use App\Http\Requests\storeCalculPeriodeOvulationRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\CalculPeriodeOvulation;

class CalculPeriodeOvulationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
        
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function calculateOvulation(storeCalculPeriodeOvulationRequest $request)
{
    try {
        // Extraction des paramètres de la requête
        $premierJourRegles = Carbon::parse($request->input('dateRegles'));
        $dureeCycle = $request->input('dureeCycle');

        // Validation de la durée du cycle menstruel
        if ($dureeCycle < 20 || $dureeCycle > 45) {
            return response()->json([
                'code_valide' => 400,
                'message' => 'La durée de votre cycle menstruel doit être comprise entre 20 et 45 jours.',
            ]);
        }

        // Calcul de la période d'ovulation
        $dateOvulationDebut = $premierJourRegles->copy()->addDays($dureeCycle - 14);
        // Calcul de la première date de la période de fertilité
        $dateFertiliteDebut = $dateOvulationDebut->copy()->subDays(5);

        // Renvoi des résultats au format JSON
        return response()->json([
            'code_valide' => 200,
            'message' => 'Calcul de la période d\'ovulation réussi.',
            'date_estimee_de_votre_ovulation' => $dateOvulationDebut->toDateString(),
            'votre_periode_de_fertilite_estimee' => $dateFertiliteDebut->toDateString() . ' au ' . $dateOvulationDebut->toDateString(),
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
