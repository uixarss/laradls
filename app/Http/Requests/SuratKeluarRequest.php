<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SuratKeluarRequest extends FormRequest
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
            'nama_penerima' => 'required',
            'tanggal_surat' => 'required',
            // 'nomor_surat' => 'required',
            'isi_ringkas' => 'required', 
            'jenis_surat' => 'required',
            'kd_klasifikasi' => 'required',
            'no_agenda' => 'required',
            'dikirim_oleh' => 'required',
            // 'tanggal_diterima' => 'required',
            'file_lampiran' => 'required|max:2048|mimes:pdf,docx,doc,xlsx,xls,pptx,ppt'
        ];
    }

    public function messages()
    {
        return [
            'nama_penerima.required' => 'Nama penerima wajib diisi.',
            'tanggal_surat.required' => 'Tanggal surat wajib diisi.',
            // 'nomor_surat.required' => 'Nomor surat wajib diisi.',
            'isi_ringkas.required' => 'Isi singkat wajib diisi.',
            'jenis_surat.required' => 'Sifat surat wajib dipilih.',
            'kd_klasifikasi.required' => 'Kode klasifikasi wajib diisi.',
            'no_agenda.required' => 'Nomor urut wajib diisi.', 
            'dikirim_oleh.required' => 'Divisi wajib dipilih.',
            'tanggal_diterima.required' => 'Tanggal diterima wajib diisi.',
            'file_lampiran.required' => 'File wajib dilampirkan.', 
            'file_lampiran.mimes' => 'Format file tidak diterima.',
            'file_lampiran.max' => 'Ukuran file maksimal 2MB',
        ];
    }
}
