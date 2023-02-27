<?php

namespace App\Services;

use App\Http\Requests\SuratMasukRequest;
use App\Models\Lampiran;
use App\Models\SuratMasuk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request as RequestSuratMasuk;
use App\Http\Requests\StoreLampiranRequest;
use App\Mail\SuratMasukBaru;
use Spatie\Permission\Models\Role;
use App\Models\Disposisi;
use Illuminate\Support\Facades\Mail;

class SuratMasukService
{

    public function createSuratMasuk(SuratMasukRequest $request): SuratMasuk
    {
        $uuid = Str::uuid();
        $year = date('Y');
        $month = date('m');
        $nomor_urut = SuratMasuk::whereYear('created_at', '=', $year)
        ->whereMonth('created_at','=', $month)->orderBy('created_at', 'DESC')->value('no_agenda');
        $suratMasuk = SuratMasuk::create([
            'uuid' => $uuid,
            'kd_klasifikasi' => $request->kd_klasifikasi,
            'no_agenda' => ++$nomor_urut,
            'indeks_berkas' => $request->indeks_berkas,
            'nomor_surat' => $request->nomor_surat,
            'isi_ringkas' => $request->isi_ringkas,
            'nama_pengirim' => $request->nama_pengirim,
            'tanggal_surat' => $request->tanggal_surat,
            'diterima_oleh' => $request->diterima_oleh,
            'tanggal_diterima' => $request->tanggal_diterima,
            'keterangan' => $request->keterangan,
            'status' => $request->status,
            'created_by' => Auth::id()
        ]);

        if ($request->hasFile('file_lampiran')) {
            $file = $request->file('file_lampiran');
            $filename = $file->getClientOriginalName();
            $file->move('file/suratmasuk/' . $uuid . '/', $filename);
            $suratMasuk->update([
                'file_lokasi' => 'file/suratmasuk/' . $uuid . '/' . $filename
            ]);
        }
        // Langsung disposisi ke direktur utama
        $users = User::role('direktur utama')->get();
        foreach ($users as $user) {
            $disposisi = Disposisi::create(
                [
                    'kd_surat' => $suratMasuk->uuid,
                    'diteruskan_kepada' => $user->id,
                    'isi_disposisi' => 'Mohon izin untuk disposisi.',
                    'status' => 'TERKIRIM',
                    'created_by' => Auth::id()
                ]
            );
            Mail::to($user->email)->send(new SuratMasukBaru($suratMasuk->isi_ringkas, $suratMasuk->tanggal_surat, $suratMasuk->nama_pengirim, $suratMasuk->uuid));
        }


        return $suratMasuk;
    }
}
