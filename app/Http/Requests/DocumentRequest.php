<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class DocumentRequest extends FormRequest
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
            'title' => 'required',
            'kode_klasifikasi' => 'required',
            'nomor_berkas' => 'required',
            'published_at' => 'required|date',
            'jumlah' => 'required',
            'author' => 'required',
            'document_file' => 'required|mimes:pdf|max:2048'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Uraian wajib diisi.',
            'kode_klasifikasi.required' => 'Kode klasifikasi wajib diisi.',
            'nomor_berkas.required' => 'Nomor berkas wajib diisi.',
            'published_at.required' => 'Tanggal wajib dipilih.',
            'jumlah.required' => 'Jumlah wajib diisi.',
            'author.required' => 'Pengolah wajib diisi.',
            'document_file.required' => 'File dokumen wajib dilampirkan.',
            'document_file.mimes' => 'Format file tidak diizinkan.',
            'document_file.max' => 'Ukuran file maksimal 2MB.'
        ];
    }
}
