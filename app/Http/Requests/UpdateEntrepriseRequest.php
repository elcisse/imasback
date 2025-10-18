<?php

namespace App\Http\Requests;

use App\Models\Entreprise;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEntrepriseRequest extends FormRequest
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
        $entreprise = $this->route('entreprise');
        $entrepriseId = $entreprise instanceof Entreprise ? $entreprise->getKey() : $entreprise;

        return [
            'department_id' => ['sometimes', 'required', 'integer', 'exists:departments,id'],
            'raison_sociale' => ['sometimes', 'required', 'string', 'max:255'],
            'adresse' => ['sometimes', 'required', 'string', 'max:255'],
            'telephone' => ['sometimes', 'required', 'string', 'max:50'],
            'email' => ['sometimes', 'nullable', 'email', 'max:255'],
            'ninea' => [
                'sometimes',
                'required',
                'string',
                'max:50',
                Rule::unique('entreprises', 'ninea')->ignore($entrepriseId),
            ],
            'desactive' => ['sometimes', 'boolean'],
        ];
    }
}

