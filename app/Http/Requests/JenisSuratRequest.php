<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class JenisSuratRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'kode' => 'required|unique:jenis_surats',
            'name' => 'required|min:3',
        ];
    }

    public function messages()
    {
        return [
            'kode.required' => 'Kode wajib diisi.',
            'kode.unique' => 'Kode sudah ada. Coba dengan kode lain.',
            'name.required' => 'Nama kearsipan wajib diisi.',
            'name.min' => 'Nama kearsipan minimal 3 huruf.'
        ];
    }
}
