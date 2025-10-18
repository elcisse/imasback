<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBonPharmacieRequest extends FormRequest
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
        $bon = $this->route('bons_pharmacie')
            ?? $this->route('bon_pharmacie')
            ?? $this->route('bonPharmacie');
        $bonId = $bon?->getKey() ?? $bon;

        return [
            'numero' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                'unique:bons_pharmacie,numero,' . $bonId,
            ],
            'mutuelle_id' => ['sometimes', 'required', 'integer', 'exists:mutuelles,id'],
            'prestataire_id' => ['sometimes', 'required', 'integer', 'exists:prestataires,id'],
            'adherent_id' => ['sometimes', 'nullable', 'integer', 'exists:adherents,id'],
            'ayant_droit_id' => ['sometimes', 'nullable', 'integer', 'exists:ayants_droit,id'],
            'date_emission' => ['sometimes', 'required', 'date'],
            'taux_couverture' => ['sometimes', 'numeric', 'min:0'],
            'statut' => ['sometimes', 'required', 'string', 'in:utilise,annule,brouillon'],
        ];
    }
}
