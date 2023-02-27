<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreDivisiRequest extends FormRequest
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
            'kode' => 'required|unique:divisis', 
            'name' => 'required|unique:divisis'
        ];
    }

    public function messages()
    {
        return [
            'kode.required' => 'Kode wajib diisi',
            'name.required' => 'Nama wajib diisi.',
            'kode.unique' => 'Kode sudah ada. Pilih kode lain.',
            'name.unique' => 'Nama sudah ada. Tulis nama lain.'
        ];
    }
}
