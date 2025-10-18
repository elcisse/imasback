<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAyantDroitRequest extends FormRequest
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
            'adherent_id' => ['sometimes', 'required', 'integer', 'exists:adherents,id'],
            'lien' => ['sometimes', 'required', 'string', 'in:conjoint,enfant,parent'],
            'prenom' => ['sometimes', 'required', 'string', 'max:255'],
            'nom' => ['sometimes', 'required', 'string', 'max:255'],
            'date_naissance' => ['sometimes', 'nullable', 'date'],
            'sexe' => ['sometimes', 'nullable', 'string', 'max:10'],
            'statut' => ['sometimes', 'required', 'string', 'in:actif,suspendu'],
        ];
    }
}
