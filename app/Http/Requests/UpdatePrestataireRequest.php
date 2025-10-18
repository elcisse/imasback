<?php

namespace App\Http\Requests;

use App\Models\Prestataire;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePrestataireRequest extends FormRequest
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
            'department_id' => ['sometimes', 'required', 'integer', 'exists:departments,id'],
            'classification_id' => ['sometimes', 'required', 'integer', 'exists:classifications,id'],
            'type' => ['sometimes', 'required', 'string', Rule::in([Prestataire::TYPE_STRUCTURE_SANITAIRE, Prestataire::TYPE_PHARMACIE])],
            'denomination' => ['sometimes', 'required', 'string', 'max:255'],
            'adresse' => ['sometimes', 'required', 'string', 'max:255'],
            'telephone' => ['sometimes', 'required', 'string', 'max:50'],
            'email' => ['sometimes', 'nullable', 'email', 'max:255'],
            'desactive' => ['sometimes', 'boolean'],
        ];
    }
}

