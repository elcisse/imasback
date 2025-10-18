<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAyantDroitRequest extends FormRequest
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
            'adherent_id' => ['required', 'integer', 'exists:adherents,id'],
            'lien' => ['required', 'string', 'in:conjoint,enfant,parent'],
            'prenom' => ['required', 'string', 'max:255'],
            'nom' => ['required', 'string', 'max:255'],
            'date_naissance' => ['nullable', 'date'],
            'sexe' => ['nullable', 'string', 'max:10'],
            'statut' => ['required', 'string', 'in:actif,suspendu'],
        ];
    }
}
