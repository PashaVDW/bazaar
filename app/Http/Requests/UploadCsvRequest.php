<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadCsvRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            'csv_file' => 'required|mimes:csv,txt|max:2048', // CSV file validation
        ];
    }

    public function messages()
    {
        return [
            'csv_file.required' => 'A CSV file is required.',
            'csv_file.mimes' => 'The file must be a CSV or TXT file.',
            'csv_file.max' => 'The file size must be less than 2MB.',
        ];
    }
}
