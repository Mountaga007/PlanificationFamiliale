<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        'titre' => ['required', 'string', 'min:2', 'max:50'],
        'texte' => ['required', 'string', 'min:2', 'max:50'],
        'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif'],
        ];
    }

    public function messages()
    {
        return [
            "titre.required" => 'Le titre est requis',
            "titre.string" => 'Le titre doit être composé de lettres, de chiffres et d\'espaces (au moins 2 caractères)',
            "titre.min" => 'Le titre doit être composé de lettres, de chiffres et d\'espaces (au moins 2 caractères)',           
            "titre.max" => 'Le titre doit être composé de lettres, de chiffres et d\'espaces (au plus 50 caractères)',
            "texte.required" => 'Le texte est requis',
            "texte.string" => 'Le texte doit être composé de lettres, de chiffres et d\'espaces (au moins 2 caractères)',
            "texte.min" => 'Le texte doit être composé de lettres, de chiffres et d\'espaces (au moins 2 caractères)',           
            "texte.max" => 'Le texte doit être composé de lettres, de chiffres et d\'espaces (au plus 50 caractères)',
            "image.image" => 'Veuillez entrer une image valide',
            "image.mimes" => 'Format image incorrect, le format de l\' image doit etre de format : jpeg,png,jpg,gif',
        ];
    }
}
