<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateConventionPharmacieRequest extends FormRequest
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
        $conventionId = $this->route('convention_pharmacie')?->getKey();

        return [
            'mutuelle_id' => ['sometimes', 'required', 'integer', 'exists:mutuelles,id'],
            'prestataire_id' => ['sometimes', 'required', 'integer', 'exists:prestataires,id'],
            'numero' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                'unique:conventions_pharmacies,numero,' . $conventionId,
            ],
            'objet' => ['sometimes', 'nullable', 'string', 'max:255'],
            'date_signature' => ['sometimes', 'nullable', 'date'],
            'date_effet' => ['sometimes', 'required', 'date'],
            'date_fin' => ['sometimes', 'nullable', 'date', 'after_or_equal:date_effet'],
            'statut' => ['sometimes', 'required', 'string', 'in:brouillon,actif,suspendu,clos,resilie'],
            'taux_remise_medicament' => ['sometimes', 'nullable', 'numeric', 'between:0,100'],
            'taux_couverture_defaut' => ['sometimes', 'required', 'numeric', 'between:0,100'],
            'plafond_annuel_benef' => ['sometimes', 'nullable', 'numeric', 'min:0'],
            'mode_facturation' => ['sometimes', 'required', 'string', 'in:acte,forfait,mixte'],
            'periodicite_facturation' => ['sometimes', 'required', 'string', 'in:a-la-prestation,mensuelle,trimestrielle,semestrielle,annuelle'],
            'delai_paiement_jours' => ['sometimes', 'required', 'integer', 'min:0'],
            'piece_jointe_url' => ['sometimes', 'nullable', 'url', 'max:2048'],
            'signee_par_mutuelle' => ['sometimes', 'nullable', 'string', 'max:255'],
            'signee_par_prestataire' => ['sometimes', 'nullable', 'string', 'max:255'],
            'clauses' => ['sometimes', 'nullable', 'array'],
        ];
    }
}
