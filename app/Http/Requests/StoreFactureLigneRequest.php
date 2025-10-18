<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFactureLigneRequest extends FormRequest
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
            'facture_id' => ['required', 'integer', 'exists:factures,id'],
            'source_type' => ['required', 'string', 'in:lettre,bon'],
            'source_ligne_id' => ['required', 'integer', 'min:1'],
            'designation' => ['required', 'string', 'max:255'],
            'quantite' => ['required', 'numeric', 'gt:0'],
            'prix_unitaire' => ['required', 'numeric', 'gte:0'],
            'montant' => ['required', 'numeric', 'gte:0'],
        ];
    }
}
