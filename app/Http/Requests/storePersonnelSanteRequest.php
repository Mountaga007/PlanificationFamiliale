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
                'nom' => ['required', 'string', 'min:2', 'max:50'],
                'email' => ['required', 'email', 'unique:users,email'],
                'password' => ['required', 'string', 'min:8', 'max:30'],
                'telephone' => ['required', 'string', 'max:20'],
                'matricule' => ['required', 'string', 'min:2', 'max:100'],
                'structure' => ['required', 'string'],
                'service' => ['required', 'string', 'min:2', 'max:100'],
            ];
    }

    public function messages()
    {
        return [
            "nom.required" => 'Le nom est requis',
            "nom.string" => 'Le nom doit être composé de lettres, de chiffres et d\'espaces (au moins 2 caractères)',
            "nom.min" => 'Le nom doit être composé de lettres, de chiffres et d\'espaces (au moins 2 caractères)',           
            "nom.max" => 'Le nom doit être composé de lettres, de chiffres et d\'espaces (au moins 50 caractères)',
            "email.required" => 'L\'email est requise',
            "email.min" => 'Format email incorrect',
            "email.unique" => 'l\'email existe déjà',
            "password.required" => 'le password est requis',
            "password.min" => 'Le password doit être composé de lettres, de chiffres et d\'espaces (au moins 8 caractères)',           
            "password.max" => 'Le password doit être composé de lettres, de chiffres et d\'espaces (au moins 30 caractères)',
            "telephone.required" => 'Le telephone est requis',
            "telephone.string" => 'Le telephone doit être composé uniquement de chiffres.',
            "telephone.max" => 'Le telephone doit être composé uniquement de chiffres (au moins 20 caractères)',
            "matricule.required" => 'Le matricule est requis',
            "matricule.string" => 'Le matricule doit être composé de lettres, de chiffres et d\'espaces.',
            "matricule.min" => 'Le matricule doit être composé de lettres, de chiffres et d\'espaces (au moins 2 caractères)',           
            "matricule.max" => 'Le matricule doit être composé de lettres, de chiffres et d\'espaces (au moins 100 caractères)',
            "structure.required" => 'Le structure est requis',
            "structure.string" => 'Le structure doit être composé de lettres, de chiffres et d\'espaces (au moins 2 caractères)',
            "service.required" => 'Le service est requis',
            "service.string" => 'Le service doit être composé de lettres, de chiffres et d\'espaces (au moins 2 caractères)',
            "service.min" => 'Le service doit être composé de lettres, de chiffres et d\'espaces (au moins 2 caractères)',           
            "service.max" => 'Le service doit être composé de lettres, de chiffres et d\'espaces (au moins 50 caractères)',
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