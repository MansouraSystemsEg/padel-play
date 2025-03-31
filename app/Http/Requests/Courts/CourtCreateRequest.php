<?php

namespace App\Http\Requests\Courts;

use App\Models\Court;
use App\Models\Region;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CourtCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique(Court::class),
            ],
            'region_id' => [
                Rule::exists(Region::class, 'id'),
            ],
        ];
    }
}
