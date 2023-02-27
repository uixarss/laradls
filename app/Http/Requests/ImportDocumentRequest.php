<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ImportDocumentRequest extends FormRequest
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
            'document_file' => 'required|file|max:2048|mimes:xls,xlsx'
        ];
    }

    public function messages()
    {
        return [
            'document_file.required' => 'File wajib dilampirkan.',
            'document_file.file' => 'Hanya menerima file.',
            'document_file.mimes' => 'Hanya menerima file xls atau xlsx.',
            'document_file.max' => 'Ukuran file maksimal 2MB.'
        ];
    }
}
