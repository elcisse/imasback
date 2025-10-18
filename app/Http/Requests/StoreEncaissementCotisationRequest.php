<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEncaissementCotisationRequest extends FormRequest
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
            'emission_cotisation_id' => ['required', 'integer', 'exists:emission_cotisations,id'],
            'date_encaissement' => ['required', 'date'],
            'montant' => ['required', 'numeric', 'gt:0'],
            'mode_paiement' => ['nullable', 'string', 'max:255'],
            'reference' => ['nullable', 'string', 'max:255'],
            'statut' => ['sometimes', 'string', 'in:en_attente,confirme,annule'],
        ];
    }
}
