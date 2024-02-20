<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storeUtilisateurRequest extends FormRequest
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
                'password' => ['required', 'string','unique:users,password','min:8', 'max:30'],
                'telephone' => ['required', 'unique:users,telephone','regex:/^00221(77|78|76|75|70)\d{7}$/'],
                'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg'],
        ];
    }

    public function messages()
    {
        return [
            "nom.required" => 'Le nom est requis',
            "nom.string" => 'Le nom doit être composé de lettres, de chiffres et d\'espaces (au moins 2 caractères)',
            "nom.min" => 'Le nom doit être composé de lettres, de chiffres et d\'espaces (au moins 2 caractères)',
            "nom.max" => 'Le nom doit être composé de lettres, de chiffres et d\'espaces (au plus 50 caractères)',
            "email.required" => 'L\'email est requise',
            "email.email" => 'Format email incorrect',
            "email.unique" => 'l\'email existe déjà',
            "password.required" => 'le password est requis',
            "password.string" => 'Le password doit être composé de lettres, de chiffres et d\'espaces (au moins 8 caractères)',
            "password.min" => 'Le password doit être composé de lettres, de chiffres et d\'espaces (au moins 8 caractères)',
            "password.max" => 'Le password doit être composé de lettres, de chiffres et d\'espaces (au plus 30 caractères)',
            "telephone.required" => 'Le telephone est requis',
            "telephone.regex" => 'Format telephone incorrect, ex: 00221771234567',
            "telephone.unique" => 'Le telephone existe déjà',
            "image.image" => 'Veuillez entrer une image valide, le format de l\' image doit etre de format : jpeg,png,jpg,gif,svg',
            "image.mimes" => 'Format de l\' image incorrect, le format de l\' image doit etre de format : jpeg,png,jpg,gif,svg',
        ];
    }

}
