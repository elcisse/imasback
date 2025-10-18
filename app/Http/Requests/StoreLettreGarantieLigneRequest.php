<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLettreGarantieLigneRequest extends FormRequest
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
            'lettre_garantie_id' => ['required', 'integer', 'exists:lettres_garantie,id'],
            'prestation_offerte_ligne_id' => ['required', 'integer', 'exists:prestation_offerte_lignes,id'],
        ];
    }
}
