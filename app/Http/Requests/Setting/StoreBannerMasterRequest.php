<?php

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        $type = request()->type;
        $dimensionRule = Rule::dimensions();
        if ($type === 'web') {
            $dimensionRule = $dimensionRule->maxWidth(1300)->maxHeight(500);
        } elseif ($type === 'mobile') {
            $dimensionRule = $dimensionRule->maxWidth(390)->maxHeight(400);
        }

        return [
            'id' => 'required|unique:tbanner,id|max:100',
            'desc' => 'required|max:100',
            'type' => 'required|max:100',
            'file' => [
                'required',
                'mimes:jpeg,png,jpg',
                'max:1500',
                $dimensionRule
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
        $type = request()->type;
        $dimensionMessage = 'The file dimensions are invalid.';
        if ($type === 'web') {
            $dimensionMessage = 'The file dimensions can\'t be larger than 1300 x 500 pixels for web.';
        } elseif ($type === 'mobile') {
            $dimensionMessage = 'The file dimensions can\'t be larger than 400 x 250 pixels for mobile.';
        }

        return [
            'file.required' => 'The file is required.',
            'file.mimes' => 'The file must be a valid image type (jpeg, png, jpg).',
            'file.max' => 'The file size cannot be larger than 1500 KB.',
            'file.dimensions' => $dimensionMessage,
        ];
    }
}
