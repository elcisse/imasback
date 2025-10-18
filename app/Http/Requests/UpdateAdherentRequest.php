<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdherentRequest extends FormRequest
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
        $adherentId = $this->route('adherent')?->getKey();

        return [
            'mutuelle_id' => ['sometimes', 'required', 'integer', 'exists:mutuelles,id'],
            'entreprise_id' => ['sometimes', 'required', 'integer', 'exists:entreprises,id'],
            'matricule' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                'unique:adherents,matricule,' . $adherentId,
            ],
            'prenom' => ['sometimes', 'required', 'string', 'max:255'],
            'nom' => ['sometimes', 'required', 'string', 'max:255'],
            'sexe' => ['sometimes', 'nullable', 'string', 'max:10'],
            'date_naissance' => ['sometimes', 'nullable', 'date'],
            'lieu_naissance' => ['sometimes', 'nullable', 'string', 'max:255'],
            'numero_cni' => ['sometimes', 'nullable', 'string', 'max:255'],
            'etat_civil' => ['sometimes', 'nullable', 'string', 'max:20'],
            'commune_id' => ['sometimes', 'nullable', 'integer', 'exists:communes,id'],
            'telephone' => ['sometimes', 'nullable', 'string', 'max:30'],
            'email' => ['sometimes', 'nullable', 'email', 'max:255'],
            'date_adhesion' => ['sometimes', 'nullable', 'date'],
            'statut' => ['sometimes', 'required', 'string', 'in:actif,suspendu,radie'],
        ];
    }
}
