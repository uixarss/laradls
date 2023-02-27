<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ImportKomponenRequest extends FormRequest
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
            'file_komponen' => 'required|file|max:2048|mimes:xls,xlsx'
        ];
    }

    public function messages()
    {
        return [
            'file_komponen.required' => 'File wajib dilampirkan.',
            'file_komponen.file' => 'Hanya menerima file.',
            'file_komponen.mimes' => 'Hanya menerima file xls atau xlsx.',
            'file_komponen.max' => 'Ukuran file maksimal 2MB.'
        ];
    }
}
