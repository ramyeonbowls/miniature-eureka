<?php

namespace App\Http\Requests\Register;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StoreFormRegisterRequest extends FormRequest
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
            'supplier' => 'required_without:distributor|string',
            'distributor' => 'required_without:supplier|string',
            'nama_perusahaan' => 'required|string|max:100',
            'email_perusahaan' => 'required|string|unique:users,email_address|max:100',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
            'negara' => 'required|string|max:50',
            'provinsi' => 'required|string|max:50',
            'kabupaten' => 'required|string|max:50',
            'kecamatan' => 'required|string|max:50',
            'keluarahan' => 'required|string|max:50',
            'kode_pos' => 'required|string|max:20',
            'alamat' => 'required|string|max:150',
            'telepon' => 'required|string|max:20',
            'handphone' => 'required|string|max:20',
            'pimpinan' => 'required|string|max:50',
            'jabatan' => 'required|string|max:50',
            'hpimpinan' => 'required|string|max:20',
            'pic' => 'required|string|max:50',
            'hpic' => 'required|string|max:20',
            'imprint' => 'nullable',
            'kuasa' => 'nullable',
            'kategori' => 'nullable',
            'rekening' => 'nullable',
            'file' => 'nullable|mimes:jpeg,png,jpg|dimensions:max_width=1980,max_height=750|max:1000',
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
            'supplier' => 'Supplier',
            'distributor' => 'Distributor',
            'nama_perusahaan' => 'Nama Perusahaan',
            'email_perusahaan' => 'Email Perusahaan',
            'password' => 'Password',
            'password_confirmation' => 'Confirm Password',
            'negara' => 'Negara',
            'provinsi' => 'Provinsi',
            'kabupaten' => 'Kabupaten',
            'kecamatan' => 'Kecamatan',
            'keluarahan' => 'Keluarahan',
            'kode_pos' => 'Kode Pos',
            'alamat' => 'Alamat',
            'telepon' => 'Telepon',
            'handphone' => 'Handphone',
            'pimpinan' => 'Pimpinan',
            'jabatan' => 'Jabatan',
            'hpimpinan' => 'No. HP Pimpinan',
            'pic' => 'Pic',
            'hpic' => 'No. HP Pic',
            'imprint' => 'Imprint',
            'kuasa' => 'Kuasa',
            'kategori' => 'Kategori',
            'rekening' => 'Rekening',
            'file' => 'file',
            'current_file' => 'current file',
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
