<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEncaissementCotisationRequest extends FormRequest
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
        $encaissement = $this->route('encaissement_cotisation')
            ?? $this->route('encaissementCotisation')
            ?? $this->route('encaissement-cotisation');

        $encaissementId = $encaissement?->getKey() ?? $encaissement;

        return [
            'emission_cotisation_id' => ['sometimes', 'required', 'integer', 'exists:emission_cotisations,id'],
            'date_encaissement' => ['sometimes', 'required', 'date'],
            'montant' => ['sometimes', 'required', 'numeric', 'gt:0'],
            'mode_paiement' => ['sometimes', 'nullable', 'string', 'max:255'],
            'reference' => ['sometimes', 'nullable', 'string', 'max:255'],
            'statut' => ['sometimes', 'required', 'string', 'in:en_attente,confirme,annule'],
        ];
    }
}
