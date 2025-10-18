<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFactureRequest extends FormRequest
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
            'numero' => ['required', 'string', 'max:255', 'unique:factures,numero'],
            'mutuelle_id' => ['required', 'integer', 'exists:mutuelles,id'],
            'prestataire_id' => ['required', 'integer', 'exists:prestataires,id'],
            'date_facture' => ['required', 'date'],
            'date_echeance' => ['nullable', 'date', 'after_or_equal:date_facture'],
            'montant_ht' => ['required', 'numeric', 'gte:0'],
            'montant_couvert' => ['required', 'numeric', 'gte:0'],
            'montant_restant' => ['required', 'numeric', 'gte:0'],
            'statut' => ['sometimes', 'string', 'in:recue,en_litige,validee,reglee,annulee'],
        ];
    }
}
