<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateConventionEntrepriseRequest extends FormRequest
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
        $conventionId = $this->route('convention_entreprise')?->getKey();

        return [
            'mutuelle_id' => ['sometimes', 'required', 'integer', 'exists:mutuelles,id'],
            'entreprise_id' => ['sometimes', 'required', 'integer', 'exists:entreprises,id'],
            'numero' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                'unique:conventions_entreprises,numero,' . $conventionId,
            ],
            'objet' => ['sometimes', 'nullable', 'string', 'max:255'],
            'date_signature' => ['sometimes', 'nullable', 'date'],
            'date_effet' => ['sometimes', 'required', 'date'],
            'date_fin' => ['sometimes', 'nullable', 'date', 'after_or_equal:date_effet'],
            'statut' => ['sometimes', 'required', 'string', 'in:brouillon,actif,suspendu,clos,resilie'],
            'taux_couverture_defaut' => ['sometimes', 'required', 'numeric', 'between:0,100'],
            'plafond_annuel_benef' => ['sometimes', 'nullable', 'numeric', 'min:0'],
            'mode_facturation' => ['sometimes', 'required', 'string', 'in:acte,forfait,mixte'],
            'periodicite_facturation' => ['sometimes', 'required', 'string', 'in:a-la-prestation,mensuelle,trimestrielle,semestrielle,annuelle'],
            'delai_paiement_jours' => ['sometimes', 'required', 'integer', 'min:0'],
            'nombre_beneficiaires' => ['sometimes', 'nullable', 'integer', 'min:0'],
            'piece_jointe_url' => ['sometimes', 'nullable', 'url', 'max:2048'],
            'signee_par_mutuelle' => ['sometimes', 'nullable', 'string', 'max:255'],
            'signee_par_entreprise' => ['sometimes', 'nullable', 'string', 'max:255'],
            'clauses' => ['sometimes', 'nullable', 'array'],
        ];
    }
}
