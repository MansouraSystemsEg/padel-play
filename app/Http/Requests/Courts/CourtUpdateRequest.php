<?php

namespace App\Http\Requests\Courts;

use App\Models\Court;
use App\Models\Region;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CourtUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique(Court::class)->ignore($this->id),
            ],
            'region_id' => [
                Rule::exists(Region::class, 'id'),
            ],
            'manager_id' => [
                'nullable',
                Rule::exists(User::class, 'id'),
            ],
        ];
    }
}
