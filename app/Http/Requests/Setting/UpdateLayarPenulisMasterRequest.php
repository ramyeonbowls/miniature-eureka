<?php

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLayarPenulisMasterRequest extends FormRequest
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
            'id' => 'required',
                'max:50',
                Rule::exists('tfitur')->where(function ($query) {
                    return $query->where('category', $this->category);
                }),
            'title' => 'required|max:255',
            'author' => 'max:50',
            'description' => 'required',
            'flag_aktif' => 'required|max:5',
            'file' => [
                'required',
                'mimes:jpeg,png,jpg',
                'max:1500',
                Rule::dimensions()->maxWidth(700)->maxHeight(350),
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
            'id' => 'ID Layar Penulis',
            'title' => 'Judul Layar Penulis',
            'flag_aktif' => 'Aktif Layar Penulis',
            'description' => 'Konten Layar Penulis',
            'file' => 'File Layar Penulis',
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
        $dimensionMessage = 'The file dimensions can\'t be larger than 700 x 350 pixels.';

        return [
            'file.required' => 'The file is required.',
            'file.mimes' => 'The file must be a valid image type (jpeg, png, jpg).',
            'file.max' => 'The file size cannot be larger than 1500 KB.',
            'file.dimensions' => $dimensionMessage,
        ];
    }
}
