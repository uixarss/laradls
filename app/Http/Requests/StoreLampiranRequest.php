<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreLampiranRequest extends FormRequest
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
            'name' => 'required',
            'file_lampiran' => 'required|file|mimes:pdf|max:2000',
            'uuid' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama lampiran wajib diisi.',
            'file_lampiran.required' => 'File wajib dilampirkan.', 
            'file_lampiran.mimes' => 'Format file hanya pdf.',
            'file_lampiran.max' => 'Ukuran file maksimal 2MB',
            'uuid.required' => 'Ada kesalahan inisialisasi.'
        ];
    }
}
