<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitReturnRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'photo' => 'required|image|max:4096',
        ];
    }

    public function messages(): array
    {
        return [
            'photo.required' => 'Upload a return photo.',
            'photo.image' => 'The file must be an image.',
            'photo.max' => 'Max image size is 4MB.',
        ];
    }
}
