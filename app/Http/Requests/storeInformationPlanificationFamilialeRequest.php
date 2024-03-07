<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class storeInformationPlanificationFamilialeRequest extends FormRequest
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
        'titre' => ['required', 'regex:/^[a-zA-Z\s\'àâäçéèêëîïôöùûüÿæœÀÂÄÇÉÈÊËÎÏÔÖÙÛÜŸÆŒ]+$/u', 'min:2', 'max:50'],
        'texte' => ['required', 'string', 'min:2', 'max:50'],
        'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif'],
        'document' => ['nullable', 'file', 'mimes:pdf'],
        ];
    }

    public function messages()
    {
        return [
            "titre.required" => 'Le titre est requis',
            "titre.regex" => 'Le titre doit être composé de lettres, d\'espaces et des caractères speciaux (au moins 2 caractères)',
            "titre.min" => 'Le titre doit être composé de lettres et d\'espaces (au moins 2 caractères)',           
            "titre.max" => 'Le titre doit être composé de lettres et d\'espaces (au plus 50 caractères)',
            "texte.required" => 'Le texte est requis',
            "texte.string" => 'Le texte doit être composé de lettres, de chiffre et d\'espaces (au moins 2 caractères)',
            "texte.min" => 'Le texte doit être composé de lettres, de chiffre et d\'espaces (au moins 2 caractères)',           
            "texte.max" => 'Le texte doit être composé de lettres, de chiffre et d\'espaces (au plus 50 caractères)',
            "image.image" => 'Veuillez entrer une image valide',
            "image.mimes" => 'Format de l\' image incorrect, le format de l\' image doit etre de format : jpeg,png,jpg,gif',
            "document.file" => 'Veuillez entrer un document valide format : pdf',
            "document.mimes" => 'Format du document incorrect, le format du document doit etre de format : pdf',
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
