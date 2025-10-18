<?php

namespace App\Http\Requests;

use App\Models\Classification;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClassificationRequest extends FormRequest
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
        $classification = $this->route('classification');
        $classificationId = $classification instanceof Classification ? $classification->getKey() : $classification;

        return [
            'classif' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('classifications', 'classif')->ignore($classificationId),
            ],
        ];
    }
}

