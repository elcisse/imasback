<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdherentRequest extends FormRequest
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
            'entreprise_id' => ['required', 'integer', 'exists:entreprises,id'],
            'matricule' => ['required', 'string', 'max:255', 'unique:adherents,matricule'],
            'prenom' => ['required', 'string', 'max:255'],
            'nom' => ['required', 'string', 'max:255'],
            'sexe' => ['nullable', 'string', 'max:10'],
            'date_naissance' => ['nullable', 'date'],
            'lieu_naissance' => ['nullable', 'string', 'max:255'],
            'numero_cni' => ['nullable', 'string', 'max:255'],
            'etat_civil' => ['nullable', 'string', 'max:20'],
            'commune_id' => ['nullable', 'integer', 'exists:communes,id'],
            'telephone' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
            'date_adhesion' => ['nullable', 'date'],
            'statut' => ['required', 'string', 'in:actif,suspendu,radie'],
        ];
    }
}
