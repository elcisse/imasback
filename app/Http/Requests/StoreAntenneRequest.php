<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAntenneRequest extends FormRequest
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
            'mutuelle_id' => ['required', 'integer', 'exists:mutuelles,id'],
            'department_id' => ['required', 'integer', 'exists:departments,id'],
            'nom_antenne' => [
                'required',
                'string',
                'max:255',
                Rule::unique('antennes', 'nom_antenne')->where(fn ($query) => $query->where('mutuelle_id', $this->input('mutuelle_id'))),
            ],
            'adresse' => ['required', 'string', 'max:255'],
            'telephone' => ['required', 'string', 'max:50'],
            'desactive' => ['sometimes', 'boolean'],
        ];
    }
}

