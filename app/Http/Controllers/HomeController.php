<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Disposisi;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\BaseController;
use App\Models\Document;
use App\Models\RiwayatSuratKeluar;
use Illuminate\Support\Facades\Auth;
use App\Models\SuratKeluar;

class HomeController extends Controller
{

    public function index()
    {
        return redirect('/dashboard');
    }
    public function dashboard()
    {
        $disposisi = Disposisi::where('diteruskan_kepada', Auth::id())
        ->where('status', '!=' , 'DITERIMA')
        ->select('kd_surat')->get();
        $riwayat = RiwayatSuratKeluar::where('diteruskan_kepada', Auth::id())
        ->where('status', '!=' , 'DITERIMA')
        ->select('kd_surat')->get();
        $data_surat_masuk = SuratMasuk::whereIn('uuid', $disposisi)->orderBy('created_at', 'ASC')->get();
        $data_surat_keluar = SuratKeluar::whereIn('uuid', $riwayat)->orderBy('created_at', 'ASC')->get();
        $total_surat_masuk = SuratMasuk::all();
        $total_surat_keluar = SuratKeluar::all();
        $total_dokumen = Document::all();

        $data_user = User::orderBy('created_at', 'DESC')->get();
        return view('dashboard', compact([
            'data_user',
            'data_surat_masuk',
            'data_surat_keluar',
            'total_surat_masuk',
            'total_surat_keluar',
            'total_dokumen'
        ]));
    }
}
