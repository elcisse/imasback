<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLettreGarantieLigneRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'lettre_garantie_id' => ['sometimes', 'required', 'integer', 'exists:lettres_garantie,id'],
            'prestation_offerte_ligne_id' => ['sometimes', 'required', 'integer', 'exists:prestation_offerte_lignes,id'],
        ];
    }
}
