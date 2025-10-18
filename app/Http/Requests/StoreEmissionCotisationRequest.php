<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmissionCotisationRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'numero' => ['required', 'string', 'max:255', 'unique:emission_cotisations,numero'],
            'mutuelle_id' => ['required', 'integer', 'exists:mutuelles,id'],
            'adherent_id' => ['nullable', 'integer', 'exists:adherents,id'],
            'date_emission' => ['required', 'date'],
            'periode_debut' => ['nullable', 'date'],
            'periode_fin' => ['nullable', 'date', 'after_or_equal:periode_debut'],
            'montant' => ['required', 'numeric', 'gte:0'],
            'statut' => ['sometimes', 'string', 'in:brouillon,validee,annulee'],
        ];
    }
}
