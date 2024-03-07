<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class storePersonnelSanteRequest extends FormRequest
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
                'nom' => ['required', 'regex:/^[a-zA-Z\s\'àâäçéèêëîïôöùûüÿæœÀÂÄÇÉÈÊËÎÏÔÖÙÛÜŸÆŒ]+$/u', 'min:2', 'max:50'],
                'email' => ['required', 'email', 'unique:users,email'],
                'password' => ['required', 'string','unique:users,password','min:8', 'max:30'],
                'telephone' => ['required', 'unique:users,telephone','regex:/^(70|75|76|77|78)[0-9]{7}$/'],
                'matricule' => ['required', 'string', 'unique:personnel_santes,matricule','min:2', 'max:100'],
                'structure' => ['required', 'string'],
                'service' => ['required', 'string', 'min:2', 'max:100'],
            ];
    }

    public function messages()
    {
        return [
            "nom.required" => 'Le nom est requis',
            "nom.regex" => 'Le nom doit être composé de lettres, d\'espaces et des caractères speciaux (au moins 2 caractères)',
            "nom.min" => 'Le nom doit être composé de lettres et d\'espaces (au moins 2 caractères)',           
            "nom.max" => 'Le nom doit être composé de lettres et d\'espaces (au plus 50 caractères)',
            "email.required" => 'L\'email est requise',
            "email.email" => 'Format email incorrect',
            "email.unique" => 'l\'email existe déjà',
            "password.required" => 'le password est requis',
            "password.unique" => 'le password existe déjà',
            "password.min" => 'Le password doit être composé de lettres, de chiffres et d\'espaces (au moins 8 caractères)',           
            "password.max" => 'Le password doit être composé de lettres, de chiffres et d\'espaces (au plus 30 caractères)',
            "telephone.required" => 'Le telephone est requis',
            "telephone.regex" => 'Format telephone incorrect, ex: 771234567',
            "telephone.unique" => 'Le telephone existe déjà',
            "matricule.required" => 'Le matricule est requis',
            "matricule.string" => 'Le matricule doit être composé de lettres et de chiffres.',
            "matricule.min" => 'Le matricule doit être composé de lettres et de chiffres (au moins 2 caractères)',           
            "matricule.max" => 'Le matricule doit être composé de lettres et de chiffres (au plus 100 caractères)',
            "structure.required" => 'Le structure est requis',
            "structure.string" => 'Le structure doit être composé de lettres et d\'espaces (au moins 2 caractères)',
            "service.required" => 'Le service est requis',
            "service.string" => 'Le service doit être composé de lettres et d\'espaces (au moins 2 caractères)',
            "service.min" => 'Le service doit être composé de lettres et d\'espaces (au moins 2 caractères)',           
            "service.max" => 'Le service doit être composé de lettres et d\'espaces (au plus 50 caractères)',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        throw new HttpResponseException(response()->json([
            'errors' => $errors,
        ], 422));
    }
}
