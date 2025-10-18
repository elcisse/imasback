<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBonPharmacieRequest extends FormRequest
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
            'numero' => ['required', 'string', 'max:255', 'unique:bons_pharmacie,numero'],
            'mutuelle_id' => ['required', 'integer', 'exists:mutuelles,id'],
            'prestataire_id' => ['required', 'integer', 'exists:prestataires,id'],
            'adherent_id' => ['nullable', 'integer', 'exists:adherents,id'],
            'ayant_droit_id' => ['nullable', 'integer', 'exists:ayants_droit,id'],
            'date_emission' => ['required', 'date'],
            'taux_couverture' => ['sometimes', 'numeric', 'min:0'],
            'statut' => ['required', 'string', 'in:utilise,annule,brouillon'],
        ];
    }
}
