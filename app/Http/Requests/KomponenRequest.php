<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class KomponenRequest extends FormRequest
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
            'kode_komponen' => 'required|unique:komponens',
            'name' => 'required|min:2'
        ];
    }
    public function messages()
    {
        return [
            'kode_komponen.required' => 'Kode komponen wajib diisi.',
            'kode_komponen.unique' => 'Kode komponen sudah ada. Coba dengan kode lain.',
            'name.required' => 'Nama komponen wajib diisi.',
            'name.min' => 'Nama komponen minimal 2 huruf.'
        ];
    }
}
