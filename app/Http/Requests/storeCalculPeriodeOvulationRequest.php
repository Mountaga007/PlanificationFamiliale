<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCalculPeriodeOvulationRequest extends FormRequest
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
            'dateRegles' => ['required', 'date'],
            'dureeCycle' => ['required', 'integer'],
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'dateRegles.required' => 'La date du premier jour de vos dernières règles est requise.',
            'dateRegles.date' => 'Le format de la date du premier jour de vos dernières règles est incorrect. Utilisez le format YYYY-MM-DD, par exemple, 2024-10-23.',
            'dureeCycle.required' => 'La durée de votre cycle menstruel est requise.',
            'dureeCycle.integer' => 'La durée du cycle menstruel doit être un nombre entier.',
        ];
    }
}
