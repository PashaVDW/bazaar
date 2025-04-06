<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdvertisementRequest extends FormRequest
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
            'image' => 'nullable|image|max:2048',
            'ads_starttime' => 'required|date',
            'ads_endtime' => 'required|date|after_or_equal:ads_starttime',
            'is_active' => 'required|boolean',
            'main_product_id' => 'required|exists:products,id',
            'sub_product_ids' => 'nullable|array',
            'sub_product_ids.*' => 'exists:products,id|distinct|different:main_product_id',
        ];
    }
    

    
}
