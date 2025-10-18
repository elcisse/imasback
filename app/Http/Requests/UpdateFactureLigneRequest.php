<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFactureLigneRequest extends FormRequest
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
        $ligne = $this->route('facture_ligne')
            ?? $this->route('factureLigne')
            ?? $this->route('facture-ligne');

        $ligneId = $ligne?->getKey() ?? $ligne;

        return [
            'facture_id' => ['sometimes', 'required', 'integer', 'exists:factures,id'],
            'source_type' => ['sometimes', 'required', 'string', 'in:lettre,bon'],
            'source_ligne_id' => ['sometimes', 'required', 'integer', 'min:1'],
            'designation' => ['sometimes', 'required', 'string', 'max:255'],
            'quantite' => ['sometimes', 'required', 'numeric', 'gt:0'],
            'prix_unitaire' => ['sometimes', 'required', 'numeric', 'gte:0'],
            'montant' => ['sometimes', 'required', 'numeric', 'gte:0'],
        ];
    }
}
