<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreConventionStructureSanitaireRequest extends FormRequest
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
            'mutuelle_id' => ['required', 'integer', 'exists:mutuelles,id'],
            'prestataire_id' => ['required', 'integer', 'exists:prestataires,id'],
            'numero' => ['required', 'string', 'max:255', 'unique:conventions_structure_sanitaires,numero'],
            'objet' => ['nullable', 'string', 'max:255'],
            'date_signature' => ['nullable', 'date'],
            'date_effet' => ['required', 'date'],
            'date_fin' => ['nullable', 'date', 'after_or_equal:date_effet'],
            'statut' => ['required', 'string', 'in:brouillon,actif,suspendu,clos,resilie'],
            'taux_couverture_defaut' => ['required', 'numeric', 'between:0,100'],
            'plafond_annuel_benef' => ['nullable', 'numeric', 'min:0'],
            'mode_facturation' => ['required', 'string', 'in:acte,forfait,mixte'],
            'periodicite_facturation' => ['required', 'string', 'in:a-la-prestation,mensuelle,trimestrielle,semestrielle,annuelle'],
            'delai_paiement_jours' => ['required', 'integer', 'min:0'],
            'piece_jointe_url' => ['nullable', 'url', 'max:2048'],
            'signee_par_mutuelle' => ['nullable', 'string', 'max:255'],
            'signee_par_prestataire' => ['nullable', 'string', 'max:255'],
            'clauses' => ['nullable', 'array'],
        ];
    }
}
