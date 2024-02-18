<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storeRechercheRequest extends FormRequest
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
            'telephone' => ['required', 'unique:users,telephone','regex:/^+221(77|78|76|75|70)\d{7}$/'],

        ];
    }

    public function messages()
    {
        return [
            "telephone.required" => 'Le telephone est requis',
            "telephone.regex" => 'Format telephone incorrect, ex: +221771234567',
            "telephone.unique" => 'Le telephone existe déjà',
        ];
    }
}
