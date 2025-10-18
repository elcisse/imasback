<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLettreGarantieRequest extends FormRequest
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
        $lettre = $this->route('lettres_garantie') ?? $this->route('lettre_garantie');
        $lettreId = $lettre?->getKey() ?? $lettre;

        return [
            'numero' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                'unique:lettres_garantie,numero,' . $lettreId,
            ],
            'mutuelle_id' => ['sometimes', 'required', 'integer', 'exists:mutuelles,id'],
            'prestataire_id' => ['sometimes', 'required', 'integer', 'exists:prestataires,id'],
            'adherent_id' => ['sometimes', 'nullable', 'integer', 'exists:adherents,id'],
            'ayant_droit_id' => ['sometimes', 'nullable', 'integer', 'exists:ayants_droit,id'],
            'date_emission' => ['sometimes', 'required', 'date'],
            'date_validite' => ['sometimes', 'nullable', 'date', 'after_or_equal:date_emission'],
            'statut' => ['sometimes', 'required', 'string', 'in:utilisee,annulee,brouillon'],
            'taux' => ['sometimes', 'nullable', 'numeric', 'min:0'],
        ];
    }
}
