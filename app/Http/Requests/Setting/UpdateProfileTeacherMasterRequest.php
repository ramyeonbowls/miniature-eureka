<?php

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UpdateProfileTeacherMasterRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'nik' => 'nullable|string|max:20',
            'phone' => 'required|string|max:15',
            'birthday' => 'required|date',
            'gender' => 'required|string|in:L,P',
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
            'name' => 'Nama Guru',
            'email' => 'Email Guru',
            'nik' => 'Nomor Identitas',
            'phone' => 'Nomor Telepon',
            'birthday' => 'Tanggal Lahir',
            'gender' => 'Jenis Kelamin'
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
