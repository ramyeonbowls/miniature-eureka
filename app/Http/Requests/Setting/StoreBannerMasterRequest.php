<?php

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;

class StoreBannerMasterRequest extends FormRequest
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
            'id' => 'required|max:100',
            'desc' => 'required|max:100',
            'type' => 'required|max:100',
            'file' => 'required|mimes:jpeg,png,jpg|dimensions:max_width=1980,max_height=750|max:1000',
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
            'id' => 'ID Banner',
            'desc' => 'Desc Banner',
            'type' => 'Type Banner',
            'file' => 'File Banner',
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
            'file.dimensions' => 'The :attribute dimensions cant be larger than 50 x 50 pixels.',
        ];
    }
}
