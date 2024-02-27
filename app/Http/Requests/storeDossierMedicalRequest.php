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
            'prenom' => ['required', 'string', 'regex:/^[a-zA-Z\s]*$/', 'min:2', 'max:50'],
            'nom' => ['required', 'string', 'regex:/^[a-zA-Z\s]*$/', 'min:2', 'max:50'],
            'telephone' => ['required', 'unique:users,telephone','regex:/^(70|75|76|77|78)[0-9]{7}$/'],
            'adresse' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'statut' => ['required', 'string', 'regex:/^[a-zA-Z\s]*$/'],
            'numero_Identification' => ['required', 'string'],
            'age' => ['required', 'integer'],
            'poste_avortement' => ['required', 'in:pilule,dui,injection,implant,anneau_vaginale_a_progresterone,condom,cu'],
            'poste_partum' => ['required', 'in:pilule,dui,injection,implant,anneau_vaginale_a_progresterone,condom,cu'],
            'methode_en_cours' => ['required', 'in:pilule,dui,injection,implant,anneau_vaginale_a_progresterone,condom,cu'],
            'methode' => ['required', 'in:pilule,dui,injection,implant,anneau_vaginale_a_progresterone,condom,cu'],
            'methode_choisie' => ['required', 'in:pilule,dui,injection,implant,anneau_vaginale_a_progresterone,condom,cu'],
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
        "prenom.required" => 'Le prenom est requis',
        "prenom.string" => 'Le prenom doit être composé de lettres et d\'espaces (au moins 2 caractères)',
        "prenom.regex" => 'Le prenom doit être composé de lettres et d\'espaces (au moins 2 caractères)',
        "prenom.min" => 'Le prenom doit être composé de lettres et d\'espaces (au moins 2 caractères)',
        "prenom.max" => 'Le prenom doit être composé de lettres et d\'espaces (au plus 50 caractères)',
        "nom.required" => 'Le nom est requis',
        "nom.string" => 'Le nom doit être composé de lettres et d\'espaces (au moins 2 caractères)',
        "nom.regex" => 'Le nom doit être composé de lettres et d\'espaces (au moins 2 caractères)',
        "nom.min" => 'Le nom doit être composé de lettres et d\'espaces (au moins 2 caractères)',
        "nom.max" => 'Le nom doit être composé de lettres et d\'espaces (au plus 50 caractères)',
        "telephone.required" => 'Le telephone est requis',
        "telephone.regex" => 'Format telephone incorrect, ex: 771234567',
        "telephone.unique" => 'Le telephone existe déjà',
        "adresse.required" => 'Le adresse est requis',
        "adresse.string" => 'Le adresse doit être composé de lettres et d\'espaces (au moins 2 caractères)',
        "email.required" => 'L\'email est requise',
        "email.email" => 'Format email incorrect',
        "email.unique" => 'l\'email existe déjà',
        "statut.required" => 'Le statut du dossier médical est requis.',
        "statut.regex" => 'Le statut doit être composé de lettres, de chiffres et d\'espaces.',
        "statut.string" => 'Le statut doit être composé de lettres, de chiffres et d\'espaces.',
        "numero_Identification.required" => 'Le numéro d\'identification est requis.',
        "numero_Identification.string" => 'Le numéro d\'Identification doit être composé de lettres, de chiffres et d\'espaces.',
        "age.required" => 'L\'âge est requis.',
        "age.integer" => 'L\'âge doit être un nombre entier.',
        "poste_avortement.required" => 'Le poste d\'avortement est requis.',
        "poste_avortement.in" => 'Le poste d\'avortement doit être soit pilule, dui, injection, implant, anneau_vaginale_a_progresterone, condom ou cu.',
        "poste_partum.required" => 'Le poste partum est requis.',
        "poste_partum.in" => 'Le poste partum doit être soit pilule, dui, injection, implant, anneau_vaginale_a_progresterone, condom ou cu.',
        "methode_en_cours.required" => 'La méthode en cours est requise.',
        "methode_en_cours.in" => 'La méthode en cours doit être soit pilule, dui, injection, implant, anneau_vaginale_a_progresterone, condom ou cu.',
        "methode.required" => 'La méthode est requise.',
        "methode.in" => 'La méthode doit être soit pilule, dui, injection, implant, anneau_vaginale_a_progresterone, condom ou cu.',
        "methode_choisie.required" => 'La méthode choisie est requise.',
        "methode_choisie.in" => 'La méthode choisie doit être soit pilule, dui, injection, implant, anneau_vaginale_a_progresterone, condom ou cu.',
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
