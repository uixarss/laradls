<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreTemplateSuratRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'kode' => 'required|unique:template_surats|min:3',
            'name' => 'required|unique:template_surats|min:5',
            'file_template' => 'required|mimes:rtf|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'kode.required' => 'Kode template surat wajid diisi.',
            'kode.unique' => 'Kode template surat wajib berbeda dengan yang lain.',
            'kode.min' => 'Kode template surat minimal 3 karakter.',
            'name.required' => 'Nama template surat wajib diisi.',
            'name.unique' => 'Nama template surat wajib berbeda dengan yang lain.',
            'name.min' => 'Nama template surat minimal 5 karakter.',
            'file_template.required' => 'File template surat wajib dilampirkan.',
            'file_template.mimes' => 'Format file template surat hanya rtf',
            'file_template.max' => 'Ukuran maksimal file template 2MB.'
        ];
    }
}
