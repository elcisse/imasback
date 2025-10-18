<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBonPharmacieLigneRequest extends FormRequest
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
            'bon_pharmacie_id' => ['required', 'integer', 'exists:bons_pharmacie,id'],
            'numero_ordre' => [
                'required',
                'integer',
                'min:1',
                'unique:bon_pharmacie_lignes,numero_ordre,NULL,id,bon_pharmacie_id,' . $this->input('bon_pharmacie_id'),
            ],
            'medicament_id' => ['required', 'integer', 'exists:medicaments,id'],
            'quantite' => ['required', 'numeric', 'gt:0'],
            'prix_unitaire' => ['required', 'numeric', 'gte:0'],
            'montant' => ['required', 'numeric', 'gte:0'],
        ];
    }
}
