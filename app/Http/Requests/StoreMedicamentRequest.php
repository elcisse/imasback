<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMedicamentRequest extends FormRequest
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
        return [
            'marque' => ['nullable', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:255', 'unique:medicaments,code'],
            'dci_temp' => ['nullable', 'string', 'max:255'],
            'forme' => ['nullable', 'string', 'max:255'],
            'voie' => ['nullable', 'string', 'max:60'],
            'dosage_val' => ['nullable', 'numeric'],
            'dosage_temp' => ['nullable', 'string', 'max:255'],
            'presentation' => ['nullable', 'string', 'max:255'],
            'barcode' => ['nullable', 'string', 'max:32'],
            'atc_code' => ['nullable', 'string', 'max:50'],
            'exclusion' => ['boolean'],
            'prix_vente_ht' => ['nullable', 'numeric'],
            'actif' => ['boolean'],
            'prix_reference_temp' => ['nullable', 'numeric'],
            'statut_temp' => ['required', 'string', 'in:actif,inactif'],
        ];
    }
}
