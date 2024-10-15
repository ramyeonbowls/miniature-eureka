<?php

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UpdateProfileMasterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'application_name' => 'required|string|max:150',
            'address' => 'required|string|max:200',
            'provinsi_id' => 'required|string|max:25',
            'kabupaten_id' => 'required|string|max:25',
            'kecamatan_id' => 'required|string|max:25',
            'kelurahan_id' => 'required|string|max:25',
            'npwp' => 'string|max:50',
            'pers_responsible' => 'required|string|max:50',
            'mou_sign_name' => 'required|string|max:50',
            'pos_sign_name' => 'required|string|max:50',
            'administrator_name' => 'required|string|max:50',
            'administrator_phone' => 'required|string|max:20',
            'updated_at' => 'nullable',
            'country_id' => 'string|max:25'
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
            'application_name' => 'Nama Aplikasi',
            'address' => 'Alamat',
            'provinsi_id' => 'Provinsi',
            'kabupaten_id' => 'Kabupaten',
            'kecamatan_id' => 'Kecamatan',
            'kelurahan_id' => 'Kelurahan',
            'npwp' => 'NPWP',
            'pers_responsible' => '',
            'mou_sign_name' => '',
            'pos_sign_name' => '',
            'administrator_name' => 'Nama Pengelola (Admin)',
            'administrator_phone' => 'Nomor HP Pengelola (Admin)',
            'country_id' => 'Negara'
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
            'file.dimensions' => 'The :attribute dimensions cant be larger than 1530 x 510 pixels.',
        ];
    }
}
