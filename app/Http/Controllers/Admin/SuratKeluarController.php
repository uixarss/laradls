<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use App\Http\Requests\LokasiSuratKeluarRequest;
use App\Http\Requests\SuratKeluarRequest;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as RequestSuratKeluar;
use App\Models\Klasifikasi;
use App\Models\Divisi;
use App\Models\Komponen;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\JenisSurat;
use Illuminate\Support\Str;
use App\Models\Lokasi;
use App\Models\LokasiSuratKeluar;
use App\Models\RiwayatSuratKeluar;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Helpers\Utils;
use App\Mail\ResponSuratKeluar;
use App\Models\TemplateSurat;
use Illuminate\Support\Facades\Mail;
use Spatie\Activitylog\Models\Activity;

class SuratKeluarController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            if (auth()->user()->hasPermissionTo('read-surat-keluar')) {
                $data_surat = SuratKeluar::orderBy('created_at', 'ASC')->get();
                $user = User::find(Auth::id());
                $subject = 'read';
                $description = $user->name . ' akses halaman surat keluar.';
                $properties = [
                    'ip' => RequestSuratKeluar::ip(),
                    'user_agent' => RequestSuratKeluar::userAgent(),
                    'method' => RequestSuratKeluar::method(),
                    'url' => RequestSuratKeluar::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->withProperties($properties)
                    ->log($description);
                return view('pages.surat.keluar.view', compact('data_surat'));
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak punya akses halaman surat keluar.';
                $properties = [
                    'ip' => RequestSuratKeluar::ip(),
                    'user_agent' => RequestSuratKeluar::userAgent(),
                    'method' => RequestSuratKeluar::method(),
                    'url' => RequestSuratKeluar::url(),
                ];
                activity($subject)
                    ->by($user)
                    ->withProperties($properties)
                    ->log($description);
                return redirect('dashboard')->with([
                    'error' => $description
                ]);
            }
        } catch (\Throwable $th) {
            $user = User::find(Auth::id());
            $subject = 'error';
            $description = $user->name . ' gagal akses halaman surat keluar.';
            $properties = [
                'ip' => RequestSuratKeluar::ip(),
                'user_agent' => RequestSuratKeluar::userAgent(),
                'method' => RequestSuratKeluar::method(),
                'url' => RequestSuratKeluar::url()
            ];

            activity($subject)
                ->by($user)
                ->withProperties($properties)
                ->log($description);
            return redirect('dashboard')->with([
                'error' => $th->getMessage(),
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            if (auth()->user()->hasPermissionTo('create-surat-keluar')) {
                $data_kode = Klasifikasi::orderBy('kode_klasifikasi', 'ASC')->get();
                $data_divisi = Divisi::orderBy('kode', 'ASC')->get();
                $data_komponen = Komponen::orderBy('name', 'ASC')->get();
                $data_jenis_surat = JenisSurat::orderBy('kode', 'ASC')->get();
                $user = User::find(Auth::id());
                $subject = 'create';
                $description = $user->name . ' akses halaman membuat surat keluar.';
                $properties = [
                    'ip' => RequestSuratKeluar::ip(),
                    'user_agent' => RequestSuratKeluar::userAgent(),
                    'method' => RequestSuratKeluar::method(),
                    'url' => RequestSuratKeluar::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->withProperties($properties)
                    ->log($description);
                
                $year = date('Y');
                $month = date('m');
                $nomor_urut = SuratKeluar::whereYear('created_at', '=', $year)
                ->whereMonth('created_at','=', $month)->orderBy('created_at', 'DESC')->value('no_agenda');
                return view('pages.surat.keluar.add', compact('data_kode', 'data_divisi', 'data_komponen', 'nomor_urut', 'data_jenis_surat'));
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak bisa akses halaman membuat surat keluar.';
                $properties = [
                    'ip' => RequestSuratKeluar::ip(),
                    'user_agent' => RequestSuratKeluar::userAgent(),
                    'method' => RequestSuratKeluar::method(),
                    'url' => RequestSuratKeluar::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->withProperties($properties)
                    ->log($description);
                return redirect('dashboard')->with([
                    'error' => $description
                ]);
            }
        } catch (\Throwable $th) {
            $user = User::find(Auth::id());
            $subject = 'error';
            $description = $user->name . ' gagal akses halaman create surat keluar.';
            $properties = [
                'ip' => RequestSuratKeluar::ip(),
                'user_agent' => RequestSuratKeluar::userAgent(),
                'method' => RequestSuratKeluar::method(),
                'url' => RequestSuratKeluar::url()
            ];

            activity($subject)
                ->by($user)
                ->withProperties($properties)
                ->log($description);
            return redirect('dashboard')->with([
                'error' => $th->getMessage(),
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SuratKeluarRequest $request)
    {
        try {
            if (auth()->user()->hasPermissionTo('create-surat-keluar')) {
                $uuid = Str::uuid();
                $year = date('Y');
                $month = date('m');
                $nomor_urut = SuratKeluar::whereYear('created_at', '=', $year)
                ->whereMonth('created_at','=', $month)->orderBy('created_at', 'DESC')->value('no_agenda');
                $suratKeluar = SuratKeluar::create([
                    'uuid' => $uuid,
                    'kd_klasifikasi' => $request->kd_klasifikasi,
                    'no_agenda' => ++$nomor_urut,
                    'jenis_surat' => $request->jenis_surat,
                    'nomor_surat' => $nomor_urut . '/' . $request->kd_klasifikasi . '/' . Utils::convertToRoman(date('m')) . '/' . date('Y'),
                    'isi_ringkas' => $request->isi_ringkas,
                    'nama_penerima' => $request->nama_penerima,
                    'tanggal_surat' => $request->tanggal_surat,
                    'dikirim_oleh' => $request->dikirim_oleh,
                    // 'tanggal_dikirim' => $request->tanggal_dikirim,
                    'keterangan' => $request->keterangan,
                    'status' => 'DRAFT',
                    'created_by' => Auth::id()
                ]);
                if ($request->hasFile('file_lampiran')) {
                    $file = $request->file('file_lampiran');
                    $filename = $file->getClientOriginalName();
                    $file->move('file/suratkeluar/' . $uuid . '/', $filename);
                    $suratKeluar->update([
                        'file_lokasi' => 'file/suratkeluar/' . $uuid . '/' . $filename
                    ]);
                }
                $user = User::find(Auth::id());
                $subject = 'store';
                $description = $user->name . ' akses halaman membuat surat keluar.';
                $properties = [
                    'ip' => RequestSuratKeluar::ip(),
                    'user_agent' => RequestSuratKeluar::userAgent(),
                    'method' => RequestSuratKeluar::method(),
                    'url' => RequestSuratKeluar::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->performedOn($suratKeluar)
                    ->withProperties($properties)
                    ->log($description);
                return redirect()->back()->with([
                    'success' => 'Berhasil menambah surat keluar.',
                ]);
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak bisa akses halaman membuat surat keluar.';
                $properties = [
                    'ip' => RequestSuratKeluar::ip(),
                    'user_agent' => RequestSuratKeluar::userAgent(),
                    'method' => RequestSuratKeluar::method(),
                    'url' => RequestSuratKeluar::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->withProperties($properties)
                    ->log($description);
                return redirect('dashboard')->with([
                    'error' => $description
                ]);
            }
        } catch (\Throwable $th) {
            $user = User::find(Auth::id());
            $subject = 'error';
            $description = $user->name . ' gagal membuat surat keluar.';
            $properties = [
                'ip' => RequestSuratKeluar::ip(),
                'user_agent' => RequestSuratKeluar::userAgent(),
                'method' => RequestSuratKeluar::method(),
                'url' => RequestSuratKeluar::url()
            ];

            activity($subject)
                ->by($user)
                ->withProperties($properties)
                ->log($description);
            return redirect('dashboard')->with([
                'error' => $th->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SuratKeluar  $suratKeluar
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        try {
            if (auth()->user()->hasPermissionTo('detail-surat-keluar')) {
                $suratKeluar = SuratKeluar::where('uuid', $uuid)->first();
                $data_log = Activity::where('subject_type', '=', SuratKeluar::class)
                    ->where('subject_id', '=', $suratKeluar->id)
                    ->orderBy('created_at', 'DESC')->get();
                $data_lokasi = Lokasi::orderBy('kode', 'ASC')->get();
                $data_lokasi_dokumen = LokasiSuratKeluar::where('surat_keluar_id', $suratKeluar->id)->get();
                $data_from = [];
                if (auth()->user()->hasRole(['direktur utama', 'direktur'])) {
                    $data_from = User::role(['direktur utama', 'direktur', 'kepala bagian', 'kepala seksi', 'staff', 'staff umum'])
                        ->select('id')
                        ->get();
                } elseif (auth()->user()->hasRole(['kepala bagian', 'kepala bagian umum'])) {
                    $data_from = User::role(['direktur utama', 'direktur', 'kepala bagian umum', 'kepala bagian', 'kepala seksi', 'staff', 'staff umum'])
                        ->select('id')
                        ->get();
                } elseif (auth()->user()->hasRole(['kepala seksi'])) {
                    $data_from = User::role(['kepala bagian', 'kepala seksi', 'staff', 'staff umum'])
                        ->select('id')
                        ->get();
                } elseif (auth()->user()->hasRole(['staff', 'staff umum'])) {
                    $data_from = User::role(['staff', 'staff umum'])
                        ->select('id')
                        ->get();
                }
                $data_riwayat = RiwayatSuratKeluar::where('kd_surat', $suratKeluar->uuid)
                    ->filter($data_from)
                    ->orWhere(function ($query) {
                        $query->active();
                    })
                    ->orderBy('created_at', 'DESC')->get();
                $user = User::find(Auth::id());
                $data_template = TemplateSurat::orderBy('kode', 'DESC')->get();
                $data_user  = User::role(['direktur utama', 'kepala bagian','kepala bagian umum', 'kepala seksi', 'direktur', 'staff', 'staff umum'])->get();
                $subject = 'show';
                $description = $user->name . ' akses halaman show surat keluar.';
                $properties = [
                    'ip' => RequestSuratKeluar::ip(),
                    'user_agent' => RequestSuratKeluar::userAgent(),
                    'method' => RequestSuratKeluar::method(),
                    'url' => RequestSuratKeluar::url(),
                ];
                activity($subject)
                    ->by($user)
                    ->performedOn($suratKeluar)
                    ->withProperties($properties)
                    ->log($description);
                return view('pages.surat.keluar.show', compact(
                    'suratKeluar',
                    'data_lokasi_dokumen',
                    'data_lokasi',
                    'data_user',
                    'data_riwayat',
                    'data_log',
                    'data_template'
                ));
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak bisa akses halaman detail surat keluar.';
                $properties = [
                    'ip' => RequestSuratKeluar::ip(),
                    'user_agent' => RequestSuratKeluar::userAgent(),
                    'method' => RequestSuratKeluar::method(),
                    'url' => RequestSuratKeluar::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->withProperties($properties)
                    ->log($description);
                return redirect('dashboard')->with([
                    'error' => $description
                ]);
            }
        } catch (\Throwable $th) {
            $user = User::find(Auth::id());
            $subject = 'error';
            $description = $user->name . ' gagal akses halaman show surat masuk.';
            $properties = [
                'ip' => RequestSuratKeluar::ip(),
                'user_agent' => RequestSuratKeluar::userAgent(),
                'method' => RequestSuratKeluar::method(),
                'url' => RequestSuratKeluar::url()
            ];

            activity($subject)
                ->by($user)
                ->withProperties($properties)
                ->log($description);
            return redirect('dashboard')->with([
                'error' => $th->getMessage(),
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SuratKeluar  $suratKeluar
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        try {
            if (auth()->user()->hasPermissionTo('edit-surat-keluar')) {
                $suratKeluar = SuratKeluar::where('uuid', $uuid)->first();
                $data_divisi = Divisi::orderBy('kode', 'ASC')->get();
                $data_komponen = Komponen::orderBy('name', 'ASC')->get();
                $data_kode = Klasifikasi::orderBy('kode_klasifikasi', 'ASC')->get();
                $user = User::find(Auth::id());
                $subject = 'edit';
                $description = $user->name . ' akses halaman edit surat keluar.';
                $properties = [
                    'ip' => RequestSuratKeluar::ip(),
                    'user_agent' => RequestSuratKeluar::userAgent(),
                    'method' => RequestSuratKeluar::method(),
                    'url' => RequestSuratKeluar::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->performedOn($suratKeluar)
                    ->withProperties($properties)
                    ->log($description);

                return view('pages.surat.keluar.edit', compact('suratKeluar', 'data_kode', 'data_divisi', 'data_komponen'));
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak memiliki akses halaman edit surat keluar.';
                $properties = [
                    'ip' => RequestSuratKeluar::ip(),
                    'user_agent' => RequestSuratKeluar::userAgent(),
                    'method' => RequestSuratKeluar::method(),
                    'url' => RequestSuratKeluar::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->withProperties($properties)
                    ->log($description);
                return redirect('dashboard')->with([
                    'error' => $description
                ]);
            }
        } catch (\Throwable $th) {
            $user = User::find(Auth::id());
            $subject = 'error';
            $description = $user->name . ' gagal akses halaman edit surat keluar.';
            $properties = [
                'ip' => RequestSuratKeluar::ip(),
                'user_agent' => RequestSuratKeluar::userAgent(),
                'method' => RequestSuratKeluar::method(),
                'url' => RequestSuratKeluar::url()
            ];

            activity($subject)
                ->by($user)
                ->withProperties($properties)
                ->log($description);
            return redirect('dashboard')->with([
                'error' => $th->getMessage(),
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SuratKeluar  $suratKeluar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            if (auth()->user()->hasPermissionTo('update-surat-keluar')) {
                $suratKeluar = SuratKeluar::find($id);
                $suratKeluar->update([
                    'kd_klasifikasi' => $request->kd_klasifikasi,
                    // 'no_agenda' => $request->no_agenda,
                    // 'indeks_berkas' => $request->indeks_berkas,
                    'nomor_surat' => $request->nomor_surat,
                    'isi_ringkas' => $request->isi_ringkas,
                    'nama_penerima' => $request->nama_penerima,
                    'tanggal_surat' => $request->tanggal_surat,
                    'dikirim_oleh' => $request->dikirim_oleh,
                    'tanggal_dikirim' => $request->tanggal_dikirim,
                    'keterangan' => $request->keterangan,
                    'status' => $request->status
                ]);
                if ($request->hasFile('file_lampiran')) {
                    // Hapus file lama
                    if (Storage::exists($suratKeluar->file_lokasi)) {
                        Storage::delete($suratKeluar->file_lokasi);
                    }
                    // $lampiran = $request->file('file_lampiran')->store('file/suratkeluar/' . $suratKeluar->uuid . '/');
                    // $suratKeluar->update([
                    //     'file_lokasi' => $lampiran
                    // ]);
                    $file = $request->file('file_lampiran');
                    $filename = $file->getClientOriginalName();
                    $file->move('file/suratkeluar/' . $suratKeluar->uuid . '/', $filename);
                    $suratKeluar->update([
                        'file_lokasi' => 'file/suratkeluar/' . $suratKeluar->uuid . '/' . $filename
                    ]);
                }
                $user = User::find(Auth::id());
                $subject = 'updated';
                $description = $user->name . ' akses halaman edit surat keluar.';
                $properties = [
                    'ip' => RequestSuratKeluar::ip(),
                    'user_agent' => RequestSuratKeluar::userAgent(),
                    'method' => RequestSuratKeluar::method(),
                    'url' => RequestSuratKeluar::url()
                ];

                activity($subject)
                    ->by($user)
                    ->performedOn($suratKeluar)
                    ->withProperties($properties)
                    ->log($description);
                return redirect()->back()->with([
                    'success' => 'Berhasil mengubah data surat keluar.'
                ]);
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak memiliki akses update surat keluar.';
                $properties = [
                    'ip' => RequestSuratKeluar::ip(),
                    'user_agent' => RequestSuratKeluar::userAgent(),
                    'method' => RequestSuratKeluar::method(),
                    'url' => RequestSuratKeluar::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->withProperties($properties)
                    ->log($description);
                return redirect('dashboard')->with([
                    'error' => $description
                ]);
            }
        } catch (\Throwable $th) {
            $user = User::find(Auth::id());
            $subject = 'error';
            $description = $user->name . ' gagal akses halaman edit surat keluar.';
            $properties = [
                'ip' => RequestSuratKeluar::ip(),
                'user_agent' => RequestSuratKeluar::userAgent(),
                'method' => RequestSuratKeluar::method(),
                'url' => RequestSuratKeluar::url()
            ];

            activity($subject)
                ->by($user)
                ->withProperties($properties)
                ->log($description);
            return redirect()->back()->with([
                'error' => $th->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SuratKeluar  $suratKeluar
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            if (auth()->user()->hasPermissionTo('delete-surat-keluar')) {
                $suratKeluar = SuratKeluar::find($id);

                if ($suratKeluar->file_lokasi != null) {
                    // Hapus file lama
                    if (Storage::exists($suratKeluar->file_lokasi)) {
                        Storage::delete($suratKeluar->file_lokasi);
                    }
                }
                $suratKeluar->delete();
                $user = User::find(Auth::id());
                $subject = 'delete';
                $description = $user->name . ' berhasil menghapus surat keluar.';
                $properties = [
                    'ip' => RequestSuratKeluar::ip(),
                    'user_agent' => RequestSuratKeluar::userAgent(),
                    'method' => RequestSuratKeluar::method(),
                    'url' => RequestSuratKeluar::url()
                ];

                activity($subject)
                    ->by($user)
                    ->performedOn($suratKeluar)
                    ->withProperties($properties)
                    ->log($description);
                return redirect()->back()->with([
                    'success' => 'Berhasil menghapus data surat keluar.'
                ]);
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak memiliki akses hapus surat keluar.';
                $properties = [
                    'ip' => RequestSuratKeluar::ip(),
                    'user_agent' => RequestSuratKeluar::userAgent(),
                    'method' => RequestSuratKeluar::method(),
                    'url' => RequestSuratKeluar::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->withProperties($properties)
                    ->log($description);
                return redirect('dashboard')->with([
                    'error' => $description
                ]);
            }
        } catch (\Throwable $th) {
            $user = User::find(Auth::id());
            $subject = 'error';
            $description = $user->name . ' gagal menghapus surat keluar.';
            $properties = [
                'ip' => RequestSuratKeluar::ip(),
                'user_agent' => RequestSuratKeluar::userAgent(),
                'method' => RequestSuratKeluar::method(),
                'url' => RequestSuratKeluar::url()
            ];

            activity($subject)
                ->by($user)
                ->withProperties($properties)
                ->log($description);
            return redirect()->back()->with([
                'error' => $th->getMessage()
            ]);
        }
    }

    public function setLokasi(LokasiSuratKeluarRequest $request, $id)
    {
        try {
            $lokasi_document = LokasiSuratKeluar::create([
                'lokasi_id' => $request->lokasi_id,
                'surat_keluar_id' => $id,
                'name' => $request->name,
                'created_by' => Auth::id()
            ]);
            $user = User::find(Auth::id());
            $subject = 'store';
            $description = $user->name . ' menambah lokasi surat keluar.';
            $properties = [
                'ip' => RequestSuratKeluar::ip(),
                'user_agent' => RequestSuratKeluar::userAgent(),
                'method' => RequestSuratKeluar::method(),
                'url' => RequestSuratKeluar::url(),
            ];

            activity($subject)
                ->by($user)
                ->performedOn($lokasi_document)
                ->withProperties($properties)
                ->log($description);
            return redirect()->back()->with([
                'success' => $user->name . ' menambah lokasi surat keluar.',
            ]);
        } catch (\Throwable $th) {
            $user = User::find(Auth::id());
            $subject = 'error';
            $description = $user->name . ' gagal menambah lokasi surat keluar.';
            $properties = [
                'ip' => RequestSuratKeluar::ip(),
                'user_agent' => RequestSuratKeluar::userAgent(),
                'method' => RequestSuratKeluar::method(),
                'url' => RequestSuratKeluar::url()
            ];

            activity($subject)
                ->by($user)
                ->withProperties($properties)
                ->log($description);
            return redirect()->back()->with([
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function updateLokasi(Request $request, $id)
    {
        try {
            $lokasi_document = LokasiSuratKeluar::find($id);
            $lokasi_document->update([
                'lokasi_id' => $request->lokasi_id,
                'name' => $request->name,
                'updated_by' => Auth::id()
            ]);
            $user = User::find(Auth::id());
            $subject = 'updated';
            $description = $user->name . ' update lokasi surat keluar.';
            $properties = [
                'ip' => RequestSuratKeluar::ip(),
                'user_agent' => RequestSuratKeluar::userAgent(),
                'method' => RequestSuratKeluar::method(),
                'url' => RequestSuratKeluar::url(),
            ];

            activity($subject)
                ->by($user)
                ->performedOn($lokasi_document)
                ->withProperties($properties)
                ->log($description);
            return redirect()->back()->with([
                'success' => $user->name . ' update lokasi surat keluar.',
            ]);
        } catch (\Throwable $th) {
            $user = User::find(Auth::id());
            $subject = 'error';
            $description = $user->name . ' gagal update lokasi surat keluar.';
            $properties = [
                'ip' => RequestSuratKeluar::ip(),
                'user_agent' => RequestSuratKeluar::userAgent(),
                'method' => RequestSuratKeluar::method(),
                'url' => RequestSuratKeluar::url()
            ];

            activity($subject)
                ->by($user)
                ->withProperties($properties)
                ->log($description);
            return redirect()->back()->with([
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function deleteLokasi($id)
    {
        try {
            $lokasi_document = LokasiSuratKeluar::find($id);
            $lokasi_document->delete();
            $user = User::find(Auth::id());
            $subject = 'updated';
            $description = $user->name . ' hapus lokasi surat keluar.';
            $properties = [
                'ip' => RequestSuratKeluar::ip(),
                'user_agent' => RequestSuratKeluar::userAgent(),
                'method' => RequestSuratKeluar::method(),
                'url' => RequestSuratKeluar::url(),
            ];

            activity($subject)
                ->by($user)
                ->performedOn($lokasi_document)
                ->withProperties($properties)
                ->log($description);
            return redirect()->back()->with([
                'success' => $user->name . ' hapus lokasi surat keluar.',
            ]);
        } catch (\Throwable $th) {
            $user = User::find(Auth::id());
            $subject = 'error';
            $description = $user->name . ' gagal hapus lokasi surat keluar.';
            $properties = [
                'ip' => RequestSuratKeluar::ip(),
                'user_agent' => RequestSuratKeluar::userAgent(),
                'method' => RequestSuratKeluar::method(),
                'url' => RequestSuratKeluar::url()
            ];

            activity($subject)
                ->by($user)
                ->withProperties($properties)
                ->log($description);
            return redirect()->back()->with([
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function storeRiwayat(Request $request, $id)
    {
        try {
            $suratKeluar = SuratKeluar::find($id);
            foreach ($request->diteruskan_kepada as $kpd) {
                $riwayat = RiwayatSuratKeluar::create(
                    [
                        'kd_surat' => $suratKeluar->uuid,
                        'diteruskan_kepada' => $kpd,
                        'catatan' => $request->catatan,
                        'status' => $request->status,
                        'created_by' => Auth::id()
                    ]
                );
                $from = User::find(Auth::id());
                $to = User::find($kpd);
                Mail::to($to->email)->send(new ResponSuratKeluar($suratKeluar->nomor_surat, $riwayat->status, $from->name, $riwayat->catatan, $suratKeluar->uuid));
            }
            $user = User::find(Auth::id());
            $subject = 'store';
            $description = $user->name . ' menambah riwayat surat keluar.';
            $properties = [
                'ip' => RequestSuratKeluar::ip(),
                'user_agent' => RequestSuratKeluar::userAgent(),
                'method' => RequestSuratKeluar::method(),
                'url' => RequestSuratKeluar::url(),
            ];

            activity($subject)
                ->by($user)
                ->performedOn($suratKeluar)
                ->withProperties($properties)
                ->log($description);
            return redirect()->back()->with([
                'success' => 'Berhasil menambah riwayat surat keluar.',
            ]);
        } catch (\Throwable $th) {
            $user = User::find(Auth::id());
            $subject = 'error';
            $description = $user->name . ' gagal menambah riwayat surat keluar.';
            $properties = [
                'ip' => RequestSuratKeluar::ip(),
                'user_agent' => RequestSuratKeluar::userAgent(),
                'method' => RequestSuratKeluar::method(),
                'url' => RequestSuratKeluar::url()
            ];

            activity($subject)
                ->by($user)
                ->withProperties($properties)
                ->log($description);
            return redirect('dashboard')->with([
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function updateRiwayat(Request $request, $id)
    {
        try {
            $disposisi = RiwayatSuratKeluar::find($id);

            $disposisi->update(
                [
                    'status' => $request->status,
                    'updated_by' => Auth::id(),
                    'tanggal_disahkan' => today()
                ]
            );

            $user = User::find(Auth::id());
            $subject = 'update';
            $description = $user->name . ' update riwayat surat keluar.';
            $properties = [
                'ip' => RequestSuratKeluar::ip(),
                'user_agent' => RequestSuratKeluar::userAgent(),
                'method' => RequestSuratKeluar::method(),
                'url' => RequestSuratKeluar::url(),
            ];

            activity($subject)
                ->by($user)
                ->performedOn($disposisi)
                ->withProperties($properties)
                ->log($description);
            return redirect()->back()->with([
                'success' => 'Berhasil update riwayat surat keluar.',
            ]);
        } catch (\Throwable $th) {
            $user = User::find(Auth::id());
            $subject = 'error';
            $description = $user->name . ' gagal update riwayat surat keluar.';
            $properties = [
                'ip' => RequestSuratKeluar::ip(),
                'user_agent' => RequestSuratKeluar::userAgent(),
                'method' => RequestSuratKeluar::method(),
                'url' => RequestSuratKeluar::url()
            ];

            activity($subject)
                ->by($user)
                ->withProperties($properties)
                ->log($description);
            return redirect('dashboard')->with([
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function uploadDocument(Request $request, $id)
    {
        try {
            if (auth()->user()->hasPermissionTo('upload-dokumen-surat-keluar')) {
                $suratkeluar = SuratKeluar::find($id);

                if ($request->hasFile('file_lampiran')) {
                    // Hapus file lama
                    if (Storage::exists($suratkeluar->file_lokasi)) {
                        Storage::delete($suratkeluar->file_lokasi);
                    }
                    // $lampiran = $request->file('file_lampiran')->store('file/suratkeluar/' . $suratkeluar->uuid . '/');
                    // $suratkeluar->update([
                    //     'file_lokasi' => $lampiran
                    // ]);
                    $file = $request->file('file_lampiran');
                    $filename = $file->getClientOriginalName();
                    $file->move('file/suratkeluar/' . $suratkeluar->uuid . '/', $filename);
                    $suratkeluar->update([
                        'file_lokasi' => 'file/suratkeluar/' . $suratkeluar->uuid . '/' . $filename
                    ]);
                }
                $user = User::find(Auth::id());
                $subject = 'updated';
                $description = $user->name . ' berhasil update document surat keluar.';
                $properties = [
                    'ip' => RequestSuratKeluar::ip(),
                    'user_agent' => RequestSuratKeluar::userAgent(),
                    'method' => RequestSuratKeluar::method(),
                    'url' => RequestSuratKeluar::url()
                ];

                activity($subject)
                    ->by($user)
                    ->performedOn($suratkeluar)
                    ->withProperties($properties)
                    ->log($description);
                return redirect()->back()->with([
                    'success' => 'Berhasil mengubah data surat keluar.'
                ]);
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak memiliki akses fitur ini.';
                $properties = [
                    'ip' => RequestSuratKeluar::ip(),
                    'user_agent' => RequestSuratKeluar::userAgent(),
                    'method' => RequestSuratKeluar::method(),
                    'url' => RequestSuratKeluar::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->withProperties($properties)
                    ->log($description);
                return redirect()->back()->with([
                    'error' => $description
                ]);
            }
        } catch (\Throwable $th) {
            $user = User::find(Auth::id());
            $subject = 'error';
            $description = $user->name . ' gagal akses halaman edit surat keluar.';
            $properties = [
                'ip' => RequestSuratKeluar::ip(),
                'user_agent' => RequestSuratKeluar::userAgent(),
                'method' => RequestSuratKeluar::method(),
                'url' => RequestSuratKeluar::url()
            ];

            activity($subject)
                ->by($user)
                ->withProperties($properties)
                ->log($description);
            return redirect()->back()->with([
                'error' => $th->getMessage()
            ]);
        }
    }

    public function approveSuratKeluar(Request $request, $id)
    {
        try {
            if (auth()->user()->hasPermissionTo('approve-surat-keluar')) {
                $suratKeluar = SuratKeluar::find($id);
                $suratKeluar->update([
                    'status' => $request->status
                ]);
                $user = User::find(Auth::id());
                $subject = 'update';
                $description = $user->name . ' update surat keluar.';
                $properties = [
                    'ip' => RequestSuratKeluar::ip(),
                    'user_agent' => RequestSuratKeluar::userAgent(),
                    'method' => RequestSuratKeluar::method(),
                    'url' => RequestSuratKeluar::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->performedOn($suratKeluar)
                    ->withProperties($properties)
                    ->log($description);
                return redirect()->back()->with([
                    'success' => 'Berhasil menambah riwayat surat keluar.',
                ]);
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak memiliki akses fitur ini.';
                $properties = [
                    'ip' => RequestSuratKeluar::ip(),
                    'user_agent' => RequestSuratKeluar::userAgent(),
                    'method' => RequestSuratKeluar::method(),
                    'url' => RequestSuratKeluar::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->withProperties($properties)
                    ->log($description);
                return redirect()->back()->with([
                    'error' => $description
                ]);
            }
        } catch (\Throwable $th) {
            $user = User::find(Auth::id());
            $subject = 'error';
            $description = $user->name . ' gagal menambah riwayat surat keluar.';
            $properties = [
                'ip' => RequestSuratKeluar::ip(),
                'user_agent' => RequestSuratKeluar::userAgent(),
                'method' => RequestSuratKeluar::method(),
                'url' => RequestSuratKeluar::url()
            ];

            activity($subject)
                ->by($user)
                ->withProperties($properties)
                ->log($description);
            return redirect('dashboard')->with([
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function sendSuratKeluar(Request $request, $id)
    {
        try {
            if (auth()->user()->hasPermissionTo('send-surat-keluar')) {
                $suratKeluar = SuratKeluar::find($id);
                $suratKeluar->update([
                    'tanggal_dikirim' => $request->tanggal_dikirim,
                    'status' => 'SUDAH DIKIRIM'
                ]);
                $user = User::find(Auth::id());
                $subject = 'update';
                $description = $user->name . ' update surat keluar.';
                $properties = [
                    'ip' => RequestSuratKeluar::ip(),
                    'user_agent' => RequestSuratKeluar::userAgent(),
                    'method' => RequestSuratKeluar::method(),
                    'url' => RequestSuratKeluar::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->performedOn($suratKeluar)
                    ->withProperties($properties)
                    ->log($description);
                return redirect()->back()->with([
                    'success' => 'Berhasil menambah riwayat surat keluar.',
                ]);
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak memiliki akses fitur ini.';
                $properties = [
                    'ip' => RequestSuratKeluar::ip(),
                    'user_agent' => RequestSuratKeluar::userAgent(),
                    'method' => RequestSuratKeluar::method(),
                    'url' => RequestSuratKeluar::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->withProperties($properties)
                    ->log($description);
                return redirect()->back()->with([
                    'error' => $description
                ]);
            }
        } catch (\Throwable $th) {
            $user = User::find(Auth::id());
            $subject = 'error';
            $description = $user->name . ' gagal menambah riwayat surat keluar.';
            $properties = [
                'ip' => RequestSuratKeluar::ip(),
                'user_agent' => RequestSuratKeluar::userAgent(),
                'method' => RequestSuratKeluar::method(),
                'url' => RequestSuratKeluar::url()
            ];

            activity($subject)
                ->by($user)
                ->withProperties($properties)
                ->log($description);
            return redirect('dashboard')->with([
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function downloadSuratKeluar($id)
    {
        try {
            if (auth()->user()->hasPermissionTo('download-surat-keluar')) {
                $suratKeluar = SuratKeluar::where('id', $id)->first();
                if (File::exists($suratKeluar->file_lokasi)) {
                    $file = public_path() . '/' . $suratKeluar->file_lokasi;
                    $headers = array('Content-Type: application/pdf',);
                    $user = User::find(Auth::id());
                    $subject = 'download';
                    $description = $user->name . ' download surat keluar ' . $suratKeluar->nomor_surat;
                    $properties = [
                        'ip' => RequestSuratKeluar::ip(),
                        'user_agent' => RequestSuratKeluar::userAgent(),
                        'method' => RequestSuratKeluar::method(),
                        'url' => RequestSuratKeluar::url(),
                    ];

                    activity($subject)
                        ->by($user)
                        ->performedOn($suratKeluar)
                        ->withProperties($properties)
                        ->log($description);
                    // return File::download($document->location_file);
                    return Response::download($file, $suratKeluar->nomor_surat . '.pdf', $headers);
                } else {
                    return redirect()->back()->with([
                        'error' => 'File tidak ditemukan.',
                    ]);
                }
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak memiliki akses download surat keluar.';
                $properties = [
                    'ip' => RequestSuratKeluar::ip(),
                    'user_agent' => RequestSuratKeluar::userAgent(),
                    'method' => RequestSuratKeluar::method(),
                    'url' => RequestSuratKeluar::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->withProperties($properties)
                    ->log($description);
                return redirect('dashboard')->with([
                    'error' => $description
                ]);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with([
                'error' => $th->getMessage(),
            ]);
        }
    }
}
