<?php

namespace App\Http\Requests;

use App\Models\Antenne;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAntenneRequest extends FormRequest
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
        $antenne = $this->route('antenne');
        $antenneId = $antenne instanceof Antenne ? $antenne->getKey() : $antenne;

        $mutuelleId = $this->input('mutuelle_id');
        if ($mutuelleId === null && $antenne instanceof Antenne) {
            $mutuelleId = $antenne->mutuelle_id;
        }

        return [
            'mutuelle_id' => ['sometimes', 'required', 'integer', 'exists:mutuelles,id'],
            'department_id' => ['sometimes', 'required', 'integer', 'exists:departments,id'],
            'nom_antenne' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('antennes', 'nom_antenne')
                    ->ignore($antenneId)
                    ->where(fn ($query) => $query->where('mutuelle_id', $mutuelleId)),
            ],
            'adresse' => ['sometimes', 'required', 'string', 'max:255'],
            'telephone' => ['sometimes', 'required', 'string', 'max:50'],
            'desactive' => ['sometimes', 'boolean'],
        ];
    }
}

