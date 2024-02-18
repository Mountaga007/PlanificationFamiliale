<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storeCommentaireRequest extends FormRequest
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
            'texte' => ['required', 'string'],
        ];
    }

    public function messages()
    {
        return [
            "texte.required" => 'Le texte est requis',
            "texte.string" => 'Le texte doit être composé de lettres, de chiffres et d\'espaces.',
        ];
    }
        }
