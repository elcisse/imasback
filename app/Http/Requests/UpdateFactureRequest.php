<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFactureRequest extends FormRequest
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
        $facture = $this->route('facture') ?? $this->route('factures');
        $factureId = $facture?->getKey() ?? $facture;

        return [
            'numero' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                'unique:factures,numero,' . $factureId,
            ],
            'mutuelle_id' => ['sometimes', 'required', 'integer', 'exists:mutuelles,id'],
            'prestataire_id' => ['sometimes', 'required', 'integer', 'exists:prestataires,id'],
            'date_facture' => ['sometimes', 'required', 'date'],
            'date_echeance' => ['sometimes', 'nullable', 'date', 'after_or_equal:date_facture'],
            'montant_ht' => ['sometimes', 'required', 'numeric', 'gte:0'],
            'montant_couvert' => ['sometimes', 'required', 'numeric', 'gte:0'],
            'montant_restant' => ['sometimes', 'required', 'numeric', 'gte:0'],
            'statut' => ['sometimes', 'required', 'string', 'in:recue,en_litige,validee,reglee,annulee'],
        ];
    }
}
