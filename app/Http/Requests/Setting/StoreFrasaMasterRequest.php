<?php

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFrasaMasterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'id' => 'required|unique:tfitur,id,category|max:50',
            'title' => 'max:255',
            'author' => 'required|max:200',
            'description' => 'required',
            'flag_aktif' => 'required|max:5',
            'file' => [
                'required',
                'mimes:jpeg,png,jpg',
                'max:1500',
                Rule::dimensions()->maxWidth(300)->maxHeight(300),
            ],
            'current_file' => 'nullable',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'id' => 'ID Frasa',
            'title' => 'Judul Frasa',
            'flag_aktif' => 'Aktif Frasa',
            'description' => 'Konten Frasa',
            'file' => 'File Frasa',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        $dimensionMessage = 'The file dimensions are invalid.';
        $dimensionMessage = 'The file dimensions can\'t be larger than 300 x 300 pixels.';

        return [
            'file.required' => 'The file is required.',
            'file.mimes' => 'The file must be a valid image type (jpeg, png, jpg).',
            'file.max' => 'The file size cannot be larger than 1500 KB.',
            'file.dimensions' => $dimensionMessage,
        ];
    }
}
