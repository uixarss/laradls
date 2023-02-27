<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class LokasiSuratKeluarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
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
