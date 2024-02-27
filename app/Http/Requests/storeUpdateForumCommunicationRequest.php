<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class storeUpdateForumCommunicationRequest extends FormRequest
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
        'titre' => ['required', 'regex:/^[a-zA-Z\s\-\'àâäçéèêëîïôöùûüÿæœÀÂÄÇÉÈÊËÎÏÔÖÙÛÜŸÆŒ]+$/u', 'min:2', 'max:50'],
        'texte' => ['required', 'string', 'min:2', 'max:50'],
        'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif'],
        ];
    }
    
    public function messages()
    {
        return [
            "titre .required" => 'Le titre est requis',
            "titre.regex" => 'Le titre doit être composé de lettres, d\'espaces et des caractères speciaux (au moins 2 caractères)',
            "titre.min" => 'Le titre doit être composé de lettres et d\'espaces (au moins 2 caractères)',           
            "titre.max" => 'Le titre doit être composé de lettres et d\'espaces (au plus 50 caractères)',
            "texte.required" => 'Le texte est requis',
            "texte.string" => 'Le texte doit être composé de lettres, de chiffre et d\'espaces (au moins 2 caractères)',
            "texte.min" => 'Le texte doit être composé de lettres, de chiffre et d\'espaces (au moins 2 caractères)',           
            "texte.max" => 'Le texte doit être composé de lettres, de chiffre et d\'espaces (au plus 50 caractères)',
            "image.image" => 'Veuillez entrer une image valide',
            "image.mimes" => 'Format image incorrect, le format de l\'image doit etre de format : jpeg,png,jpg,gif',
        ];
    }

public function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
            'succes' => false,
            'status_code' => 422,
            'error' => true,
            'message' => 'Erreur de validation',
            'errorsList' => $validator->errors()
        ]));
    }
}
