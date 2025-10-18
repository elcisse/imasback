<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLettreGarantieRequest extends FormRequest
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
            'numero' => ['required', 'string', 'max:255', 'unique:lettres_garantie,numero'],
            'mutuelle_id' => ['required', 'integer', 'exists:mutuelles,id'],
            'prestataire_id' => ['required', 'integer', 'exists:prestataires,id'],
            'adherent_id' => ['nullable', 'integer', 'exists:adherents,id'],
            'ayant_droit_id' => ['nullable', 'integer', 'exists:ayants_droit,id'],
            'date_emission' => ['required', 'date'],
            'date_validite' => ['nullable', 'date', 'after_or_equal:date_emission'],
            'statut' => ['required', 'string', 'in:utilisee,annulee,brouillon'],
            'taux' => ['nullable', 'numeric', 'min:0'],
        ];
    }
}
