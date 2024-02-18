<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storeDossierMedicalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => ['required', 'exists:users,id'],
            'statut' => ['required', 'string'],
            'numero_Identification' => ['required', 'string'],
            'age' => ['required', 'integer'],
            'poste_avortement' => ['required', 'string'],
            'poste_partum' => ['required', 'string'],
            'methode_en_cours' => ['required', 'string'],
            'methode' => ['required', 'string'],
            'methode_choisie' => ['required', 'string'],
            'preciser_autres_methodes' => ['nullable', 'string'],
            'raison_de_la_visite' => ['required', 'string'],
            'indication' => ['required', 'string'],
            'effets_indesirables_complications' => ['nullable', 'string'],
            'date_visite' => ['required', 'date'],
            'date_prochain_rv' => ['required', 'date'],
        ];
    }

    public function messages()
{
    return [
        "id.required" => 'L\'identifiant de l\'utilisateur est requis.',
        "id.exists" => 'L\'utilisateur spécifié n\'existe pas.',
        "statut.required" => 'Le statut du dossier médical est requis.',
        "statut.string" => 'Le statut doit être composé de lettres, de chiffres et d\'espaces.',
        "numero_Identification.required" => 'Le numéro d\'identification est requis.',
        "numero_Identification.string" => 'Le numéro d\'Identification doit être composé de lettres, de chiffres et d\'espaces.',
        "age.required" => 'L\'âge est requis.',
        "age.integer" => 'L\'âge doit être un nombre entier.',
        "poste_avortement.required" => 'Le poste d\'avortement est requis.',
        "poste_avortement.string" => 'Le poste d\'avortement doit être composé de lettres, de chiffres et d\'espaces.',
        "poste_partum.required" => 'Le poste partum est requis.',
        "poste_partum.string" => 'Le poste partum doit être composé de lettres, de chiffres et d\'espaces.',
        "methode_en_cours.required" => 'La méthode en cours est requise.',
        "methode_en_cours.string" => 'La méthode en cours doit être composé de lettres, de chiffres et d\'espaces.',
        "methode.required" => 'La méthode est requise.',
        "methode.string" => 'La méthode doit être composé de lettres, de chiffres et d\'espaces.',
        "methode_choisie.required" => 'La méthode choisie est requise.',
        "methode_choisie.string" => 'La methode choisie doit être composé de lettres, de chiffres et d\'espaces.',
        "preciser_autres_methodes.string" => 'Veuillez entrer une valeur valide pour les autres méthodes, ils doivent être composé de lettres, de chiffres et d\'espaces.',
        "raison_de_la_visite.required" => 'La raison de la visite est requise.',
        "raison_de_la_visite.string" => 'Veuillez entrer une valeur valide pour la raison de la visite, ils doivent être composé de lettres, de chiffres et d\'espaces.',
        "indication.required" => 'L\'indication est requise.',
        "indication.string" => 'Veuillez entrer une valeur valide pour l\'indication, ils doitvent être composé de lettres, de chiffres et d\'espaces.',
        "effets_indesirables_complications.string" => 'Veuillez entrer une valeur valide pour les effets indésirables ou complications, ils doitvent être composé de lettres, de chiffres et d\'espaces.',
        "date_visite.required" => 'La date de visite est requise.',
        "date_visite.date" => 'Le format de la date de visite est incorrect. Utilisez le format YYYY-MM-DD.',
        "date_prochain_rv.required" => 'La date du prochain rendez-vous est requise.',
        "date_prochain_rv.date" => 'Le format de la date du prochain rendez-vous est incorrect. Utilisez le format YYYY-MM-DD.',
    ];
}

}
