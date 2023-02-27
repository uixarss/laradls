<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class KlasifikasiRequest extends FormRequest
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
            'kode_klasifikasi' => 'required|unique:klasifikasis',
            'name' => 'required|min:3'
        ];
    }

    public function messages()
    {
        return [
            'kode_klasifikasi.required' => 'Kode klasifikasi wajib diisi.',
            'kode_klasifikasi.unique' => 'Kode klasifikasi sudah ada. Coba dengan kode lain.',
            'name.required' => 'Nama klasifikasi wajib diisi.',
            'name.min' => 'Nama klasifikasi minimal 3 huruf.'
        ];
    }
}
