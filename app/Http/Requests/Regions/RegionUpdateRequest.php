<?php

namespace App\Http\Requests\Regions;

use App\Models\Region;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegionUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique(Region::class)->ignore($this->id),
            ],
            'parent_id' => [
                'nullable',
                Rule::exists(Region::class, 'id'),
            ],
            'manager_id' => [
                'nullable',
                Rule::exists(User::class, 'id'),
            ],
        ];
    }
}
