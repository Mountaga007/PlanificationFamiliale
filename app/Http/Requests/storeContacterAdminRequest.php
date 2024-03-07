<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class storeContacterAdminRequest extends FormRequest
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
            'email' => ['required', 'email', 'unique:contacters,email'],
            'message' => ['required', 'string', 'min:2', 'max:500'],
        ];
    }

    public function messages()
    {
        return [
            "nom.required" => 'Le nom est requis',
            "nom.regex" => 'Le nom doit être composé de lettres, d\'espaces et des caractères spéciaux (au moins 2 caractères)',
            "nom.min" => 'Le nom doit être composé de lettres et d\'espaces (au moins 2 caractères)',           
            "nom.max" => 'Le nom doit être composé de lettres et d\'espaces (au plus 50 caractères)',
            "email.required" => 'L\'email est requise',
            "email.email" => 'Format email incorrect',
            "email.unique" => 'l\'email existe déjà',
            "message.required" => 'Le message est requis',
            "message.string" => 'Le message doit être composé de lettres, de chiffres et d\'espaces (au moins 2 caractères)',
            "message.min" => 'Le message doit être composé de lettres, de chiffres et d\'espaces (au moins 2 caractères)',           
            "message.max" => 'Le message doit être composé de lettres, de chiffres et d\'espaces (au plus 500 caractères)',
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
