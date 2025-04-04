<?php

namespace App\Http\Requests;

use App\Rules\MaxFourAdvertisements;
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
            'title' => ['required', 'string', 'max:255', new MaxFourAdvertisements],
            'description' => 'nullable|string',
            'image' => 'required|image|max:2048',
            'ads_starttime' => 'required|date',
            'ads_endtime' => 'required|date|after_or_equal:ads_starttime',
            'type' => 'required|in:sale,rental,auction',
            'is_active' => 'required|boolean',
            'hourly_price' => 'required|numeric|min:0|max:999999.99',
        ];
    }
}
