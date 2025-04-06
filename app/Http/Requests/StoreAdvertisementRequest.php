<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdvertisementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => 'nullable|string',
            'image' => 'required|image|max:2048',
            'ads_starttime' => 'required|date',
            'ads_endtime' => 'required|date|after_or_equal:ads_starttime',
            'is_active' => 'required|boolean',
        ];
    }
}
