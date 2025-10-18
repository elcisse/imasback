<?php

namespace App\Http\Requests;

use App\Models\Prestataire;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePrestataireRequest extends FormRequest
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
            'department_id' => ['required', 'integer', 'exists:departments,id'],
            'classification_id' => ['required', 'integer', 'exists:classifications,id'],
            'type' => ['required', 'string', Rule::in([Prestataire::TYPE_STRUCTURE_SANITAIRE, Prestataire::TYPE_PHARMACIE])],
            'denomination' => ['required', 'string', 'max:255'],
            'adresse' => ['required', 'string', 'max:255'],
            'telephone' => ['required', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'desactive' => ['sometimes', 'boolean'],
        ];
    }
}

