<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBonPharmacieLigneRequest extends FormRequest
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
        $ligne = $this->route('bon_pharmacie_ligne')
            ?? $this->route('bonPharmacieLigne')
            ?? $this->route('bon_pharmacie_lignes');

        $ligneId = $ligne?->getKey() ?? $ligne;
        $bonPharmacieId = $this->input('bon_pharmacie_id') ?? $ligne?->bon_pharmacie_id;

        return [
            'bon_pharmacie_id' => ['sometimes', 'required', 'integer', 'exists:bons_pharmacie,id'],
            'numero_ordre' => [
                'sometimes',
                'required',
                'integer',
                'min:1',
                'unique:bon_pharmacie_lignes,numero_ordre,' . $ligneId . ',id,bon_pharmacie_id,' . $bonPharmacieId,
            ],
            'medicament_id' => ['sometimes', 'required', 'integer', 'exists:medicaments,id'],
            'quantite' => ['sometimes', 'required', 'numeric', 'gt:0'],
            'prix_unitaire' => ['sometimes', 'required', 'numeric', 'gte:0'],
            'montant' => ['sometimes', 'required', 'numeric', 'gte:0'],
        ];
    }
}
