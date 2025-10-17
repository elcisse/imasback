<?php

namespace App\Http\Requests;

use App\Models\Department;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDepartmentRequest extends FormRequest
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
        $department = $this->route('department');
        $departmentId = $department instanceof Department ? $department->getKey() : $department;
        $regionId = $this->input('region_id');

        if ($regionId === null && $department instanceof Department) {
            $regionId = $department->region_id;
        }

        return [
            'region_id' => ['sometimes', 'required', 'integer', 'exists:regions,id'],
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('departments')
                    ->ignore($departmentId)
                    ->where(fn ($query) => $query->where('region_id', $regionId)),
            ],
        ];
    }
}

