<?php

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateVideoMasterRequest extends FormRequest
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
            'title' => 'required|max:100',
            'description' => 'required|max:500',
            'flag_aktif' => 'required|max:5',
            'file' => 'required'
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
            'id' => 'ID Video',
            'title' => 'Judul Video',
            'flag_aktif' => 'Aktif Video',
            'description' => 'Konten Video',
            'file' => 'File Video',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'file.required' => 'The file is required.',
            'file.mimes' => 'The file must be a valid image type (jpeg, png, jpg).',
            'file.max' => 'The file size cannot be larger than 1500 KB.'
        ];
    }
}
