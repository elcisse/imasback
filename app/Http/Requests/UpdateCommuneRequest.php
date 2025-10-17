<?php

namespace App\Http\Requests;

use App\Models\Commune;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCommuneRequest extends FormRequest
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
        $commune = $this->route('commune');
        $communeId = $commune instanceof Commune ? $commune->getKey() : $commune;
        $departmentId = $this->input('department_id');

        if ($departmentId === null && $commune instanceof Commune) {
            $departmentId = $commune->department_id;
        }

        return [
            'department_id' => ['sometimes', 'required', 'integer', 'exists:departments,id'],
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('communes')
                    ->ignore($communeId)
                    ->where(fn ($query) => $query->where('department_id', $departmentId)),
            ],
        ];
    }
}

