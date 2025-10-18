<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmissionCotisationRequest extends FormRequest
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
        $emission = $this->route('emission_cotisation')
            ?? $this->route('emissionCotisation')
            ?? $this->route('emission-cotisation');

        $emissionId = $emission?->getKey() ?? $emission;

        return [
            'numero' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                'unique:emission_cotisations,numero,' . $emissionId,
            ],
            'mutuelle_id' => ['sometimes', 'required', 'integer', 'exists:mutuelles,id'],
            'adherent_id' => ['sometimes', 'nullable', 'integer', 'exists:adherents,id'],
            'date_emission' => ['sometimes', 'required', 'date'],
            'periode_debut' => ['sometimes', 'nullable', 'date'],
            'periode_fin' => ['sometimes', 'nullable', 'date', 'after_or_equal:periode_debut'],
            'montant' => ['sometimes', 'required', 'numeric', 'gte:0'],
            'statut' => ['sometimes', 'required', 'string', 'in:brouillon,validee,annulee'],
        ];
    }
}
