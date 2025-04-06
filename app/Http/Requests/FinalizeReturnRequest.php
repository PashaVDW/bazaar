<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FinalizeReturnRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'wear_percentage' => 'required|numeric|min:0|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'wear_percentage.required' => 'Enter the wear percentage.',
            'wear_percentage.numeric' => 'Wear percentage must be a number.',
            'wear_percentage.min' => 'Minimum wear is 0%.',
            'wear_percentage.max' => 'Maximum wear is 100%.',
        ];
    }
}
