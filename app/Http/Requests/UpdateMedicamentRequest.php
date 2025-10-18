<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMedicamentRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $medicamentId = $this->route('medicament')?->getKey();

        return [
            'marque' => ['sometimes', 'nullable', 'string', 'max:255'],
            'code' => [
                'sometimes',
                'nullable',
                'string',
                'max:255',
                'unique:medicaments,code,' . $medicamentId,
            ],
            'dci_temp' => ['sometimes', 'nullable', 'string', 'max:255'],
            'forme' => ['sometimes', 'nullable', 'string', 'max:255'],
            'voie' => ['sometimes', 'nullable', 'string', 'max:60'],
            'dosage_val' => ['sometimes', 'nullable', 'numeric'],
            'dosage_temp' => ['sometimes', 'nullable', 'string', 'max:255'],
            'presentation' => ['sometimes', 'nullable', 'string', 'max:255'],
            'barcode' => ['sometimes', 'nullable', 'string', 'max:32'],
            'atc_code' => ['sometimes', 'nullable', 'string', 'max:50'],
            'exclusion' => ['sometimes', 'boolean'],
            'prix_vente_ht' => ['sometimes', 'nullable', 'numeric'],
            'actif' => ['sometimes', 'boolean'],
            'prix_reference_temp' => ['sometimes', 'nullable', 'numeric'],
            'statut_temp' => ['sometimes', 'required', 'string', 'in:actif,inactif'],
        ];
    }
}
