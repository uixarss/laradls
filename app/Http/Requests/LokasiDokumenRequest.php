<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class LokasiDokumenRequest extends FormRequest
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
            'lokasi_id' => 'required',
            'name' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'lokasi_id.required' => 'Lokasi wajib dipilih.',
            'name.required' => 'Nama lokasi wajib diisi.'
        ];
    }
}
