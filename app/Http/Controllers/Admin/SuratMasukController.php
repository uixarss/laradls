<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use App\Http\Requests\LokasiSuratMasukRequest;
use App\Http\Requests\StoreLampiranRequest;
use App\Http\Requests\SuratMasukRequest;
use App\Mail\SuratMasukBaru;
use App\Models\Divisi;
use App\Models\Klasifikasi;
use App\Models\Komponen;
use App\Models\Lampiran;
use App\Models\SuratMasuk;
use App\Models\User;
use App\Models\Lokasi;
use App\Models\Disposisi;
use App\Models\LokasiSuratMasuk;
use App\Services\SuratMasukService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request as RequestSuratMasuk;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Carbon;
use Spatie\Activitylog\Models\Activity;

class SuratMasukController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            if (auth()->user()->hasPermissionTo('create-surat-masuk')) {
                $data_sm = SuratMasuk::orderBy('created_at', 'DESC')->get();

                $user = User::find(Auth::id());
                $subject = 'read';
                $description = $user->name . ' melihat halaman surat masuk.';
                $properties = [
                    'ip' => RequestSuratMasuk::ip(),
                    'user_agent' => RequestSuratMasuk::userAgent(),
                    'method' => RequestSuratMasuk::method(),
                    'url' => RequestSuratMasuk::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->withProperties($properties)
                    ->log($description);
                return view('pages.surat.masuk.view', compact('data_sm'));
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak punya akses halaman surat masuk.';
                $properties = [
                    'ip' => RequestSuratMasuk::ip(),
                    'user_agent' => RequestSuratMasuk::userAgent(),
                    'method' => RequestSuratMasuk::method(),
                    'url' => RequestSuratMasuk::url(),
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
            $description = $user->name . ' gagal akses halaman surat masuk.';
            $properties = [
                'ip' => RequestSuratMasuk::ip(),
                'user_agent' => RequestSuratMasuk::userAgent(),
                'method' => RequestSuratMasuk::method(),
                'url' => RequestSuratMasuk::url()
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
            if (auth()->user()->hasPermissionTo('create-surat-masuk')) {
                $data_kode = Klasifikasi::orderBy('kode_klasifikasi', 'ASC')->get();
                $data_divisi = Divisi::orderBy('kode', 'ASC')->get();
                $data_komponen = Komponen::orderBy('name', 'ASC')->get();
                $user = User::find(Auth::id());
                $subject = 'create';
                $description = $user->name . ' akses halaman membuat surat masuk.';
                $properties = [
                    'ip' => RequestSuratMasuk::ip(),
                    'user_agent' => RequestSuratMasuk::userAgent(),
                    'method' => RequestSuratMasuk::method(),
                    'url' => RequestSuratMasuk::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->withProperties($properties)
                    ->log($description);
                $year = date('Y');
                $month = date('m');
                $nomor_urut = SuratMasuk::whereYear('created_at', '=', $year)
                ->whereMonth('created_at','=', $month)->orderBy('created_at', 'DESC')->value('no_agenda');
                return view('pages.surat.masuk.add', compact('data_kode', 'data_divisi', 'data_komponen', 'nomor_urut'));
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak punya akses halaman surat masuk.';
                $properties = [
                    'ip' => RequestSuratMasuk::ip(),
                    'user_agent' => RequestSuratMasuk::userAgent(),
                    'method' => RequestSuratMasuk::method(),
                    'url' => RequestSuratMasuk::url(),
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
            $description = $user->name . ' gagal akses halaman create surat masuk.';
            $properties = [
                'ip' => RequestSuratMasuk::ip(),
                'user_agent' => RequestSuratMasuk::userAgent(),
                'method' => RequestSuratMasuk::method(),
                'url' => RequestSuratMasuk::url()
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
    public function store(SuratMasukRequest $request, SuratMasukService $suratMasukService)
    {
        try {
            if (auth()->user()->hasPermissionTo('create-surat-masuk')) {
                $suratMasuk = $suratMasukService->createSuratMasuk($request);
                $user = User::find(Auth::id());
                $subject = 'store';
                $description = $user->name . ' akses halaman membuat surat masuk.';
                $properties = [
                    'ip' => RequestSuratMasuk::ip(),
                    'user_agent' => RequestSuratMasuk::userAgent(),
                    'method' => RequestSuratMasuk::method(),
                    'url' => RequestSuratMasuk::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->performedOn($suratMasuk)
                    ->withProperties($properties)
                    ->log($description);
                return redirect()->back()->with([
                    'success' => 'Berhasil menambah surat masuk.',
                ]);
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak punya akses membuat surat masuk.';
                $properties = [
                    'ip' => RequestSuratMasuk::ip(),
                    'user_agent' => RequestSuratMasuk::userAgent(),
                    'method' => RequestSuratMasuk::method(),
                    'url' => RequestSuratMasuk::url(),
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
            $description = $user->name . ' gagal membuat surat masuk baru.';
            $properties = [
                'ip' => RequestSuratMasuk::ip(),
                'user_agent' => RequestSuratMasuk::userAgent(),
                'method' => RequestSuratMasuk::method(),
                'url' => RequestSuratMasuk::url()
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        try {
            if (auth()->user()->hasPermissionTo('detail-surat-masuk')) {
                $suratMasuk = SuratMasuk::where('uuid', $uuid)->first();
                $data_log = Activity::where('subject_type', '=', SuratMasuk::class)
                    ->where('subject_id', '=', $suratMasuk->id)
                    ->orderBy('created_at', 'DESC')->get();
                $data_lokasi = Lokasi::orderBy('kode', 'ASC')->get();
                $data_lokasi_dokumen = LokasiSuratMasuk::where('surat_masuk_id', $suratMasuk->id)->get();
                $data_from = [];
                if (auth()->user()->hasRole(['direktur utama', 'direktur'])) {
                    $data_from = User::role(['direktur utama', 'direktur', 'kepala bagian', 'kepala seksi', 'staff', 'staff umum'])
                        ->select('id')
                        ->get();
                } elseif (auth()->user()->hasRole(['kepala bagian', 'kepala bagian umum'])) {
                    $data_from = User::role(['direktur utama', 'direktur', 'kepala bagian umum','kepala bagian', 'kepala seksi', 'staff', 'staff umum'])
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
                $data_disposisi = Disposisi::where('kd_surat', $suratMasuk->uuid)
                    ->filter($data_from)
                    ->orWhere(function ($query) {
                        $query->active();
                    })
                    ->orderBy('created_at', 'DESC')->get();
                $user = User::find(Auth::id());
                // $data_user = User::where('kode_divisi', '=', $user->kode_divisi)->get();
                $data_user  = User::role(['direktur utama', 'kepala bagian','kepala bagian umum', 'kepala seksi', 'direktur', 'staff', 'staff umum'])->get();
                $subject = 'show';
                $description = $user->name . ' akses halaman show surat masuk.';
                $properties = [
                    'ip' => RequestSuratMasuk::ip(),
                    'user_agent' => RequestSuratMasuk::userAgent(),
                    'method' => RequestSuratMasuk::method(),
                    'url' => RequestSuratMasuk::url(),
                ];
                // dd($suratMasuk);
                activity($subject)
                    ->by($user)
                    ->performedOn($suratMasuk)
                    ->withProperties($properties)
                    ->log($description);
                return view('pages.surat.masuk.show', compact(
                    'suratMasuk',
                    'data_lokasi_dokumen',
                    'data_lokasi',
                    'data_user',
                    'data_disposisi',
                    'data_log'
                ));
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak punya akses detail surat masuk.';
                $properties = [
                    'ip' => RequestSuratMasuk::ip(),
                    'user_agent' => RequestSuratMasuk::userAgent(),
                    'method' => RequestSuratMasuk::method(),
                    'url' => RequestSuratMasuk::url(),
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
                'ip' => RequestSuratMasuk::ip(),
                'user_agent' => RequestSuratMasuk::userAgent(),
                'method' => RequestSuratMasuk::method(),
                'url' => RequestSuratMasuk::url()
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        try {
            if (auth()->user()->hasPermissionTo('edit-surat-masuk')) {
                $suratMasuk = SuratMasuk::where('uuid', $uuid)->first();
                $data_divisi = Divisi::orderBy('kode', 'ASC')->get();
                $data_komponen = Komponen::orderBy('name', 'ASC')->get();
                $data_kode = Klasifikasi::orderBy('kode_klasifikasi', 'ASC')->get();
                $user = User::find(Auth::id());
                $subject = 'edit';
                $description = $user->name . ' akses halaman edit surat masuk.';
                $properties = [
                    'ip' => RequestSuratMasuk::ip(),
                    'user_agent' => RequestSuratMasuk::userAgent(),
                    'method' => RequestSuratMasuk::method(),
                    'url' => RequestSuratMasuk::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->performedOn($suratMasuk)
                    ->withProperties($properties)
                    ->log($description);

                return view('pages.surat.masuk.edit', compact('suratMasuk', 'data_kode', 'data_divisi', 'data_komponen'));
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak punya akses edit surat masuk.';
                $properties = [
                    'ip' => RequestSuratMasuk::ip(),
                    'user_agent' => RequestSuratMasuk::userAgent(),
                    'method' => RequestSuratMasuk::method(),
                    'url' => RequestSuratMasuk::url(),
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
            $description = $user->name . ' gagal akses halaman edit surat masuk.';
            $properties = [
                'ip' => RequestSuratMasuk::ip(),
                'user_agent' => RequestSuratMasuk::userAgent(),
                'method' => RequestSuratMasuk::method(),
                'url' => RequestSuratMasuk::url()
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            if (auth()->user()->hasPermissionTo('update-surat-masuk')) {
                $suratMasuk = SuratMasuk::find($id);
                $suratMasuk->update([
                    'kd_klasifikasi' => $request->kd_klasifikasi,
                    'no_agenda' => $request->no_agenda,
                    'indeks_berkas' => $request->indeks_berkas,
                    'nomor_surat' => $request->nomor_surat,
                    'isi_ringkas' => $request->isi_ringkas,
                    'nama_pengirim' => $request->nama_pengirim,
                    'tanggal_surat' => $request->tanggal_surat,
                    'diterima_oleh' => $request->diterima_oleh,
                    'tanggal_diterima' => $request->tanggal_diterima,
                    'keterangan' => $request->keterangan,
                    'status' => $request->status
                ]);
                if ($request->hasFile('file_lampiran')) {
                    // Hapus file lama
                    if (Storage::exists($suratMasuk->file_lokasi)) {
                        Storage::delete($suratMasuk->file_lokasi);
                    }
                    $lampiran = $request->file('file_lampiran')->store('file/suratmasuk/' . $suratMasuk->uuid . '/');
                    $suratMasuk->update([
                        'file_lokasi' => $lampiran
                    ]);
                }
                $user = User::find(Auth::id());
                $subject = 'updated';
                $description = $user->name . ' akses halaman edit surat masuk.';
                $properties = [
                    'ip' => RequestSuratMasuk::ip(),
                    'user_agent' => RequestSuratMasuk::userAgent(),
                    'method' => RequestSuratMasuk::method(),
                    'url' => RequestSuratMasuk::url()
                ];

                activity($subject)
                    ->by($user)
                    ->performedOn($suratMasuk)
                    ->withProperties($properties)
                    ->log($description);
                return redirect()->back()->with([
                    'success' => 'Berhasil mengubah data surat masuk.'
                ]);
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak punya akses update surat masuk.';
                $properties = [
                    'ip' => RequestSuratMasuk::ip(),
                    'user_agent' => RequestSuratMasuk::userAgent(),
                    'method' => RequestSuratMasuk::method(),
                    'url' => RequestSuratMasuk::url(),
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
            $description = $user->name . ' gagal akses halaman edit surat masuk.';
            $properties = [
                'ip' => RequestSuratMasuk::ip(),
                'user_agent' => RequestSuratMasuk::userAgent(),
                'method' => RequestSuratMasuk::method(),
                'url' => RequestSuratMasuk::url()
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            if (auth()->user()->hasPermissionTo('delete-surat-masuk')) {
                $suratMasuk = SuratMasuk::find($id);
                if ($suratMasuk->file_lokasi != null) {
                    // Hapus file lama
                    if (Storage::exists($suratMasuk->file_lokasi)) {
                        Storage::delete($suratMasuk->file_lokasi);
                    }
                }
                $suratMasuk->delete();
                $user = User::find(Auth::id());
                $subject = 'delete';
                $description = $user->name . ' menghapus surat masuk.';
                $properties = [
                    'ip' => RequestSuratMasuk::ip(),
                    'user_agent' => RequestSuratMasuk::userAgent(),
                    'method' => RequestSuratMasuk::method(),
                    'url' => RequestSuratMasuk::url()
                ];

                activity($subject)
                    ->by($user)
                    ->performedOn($suratMasuk)
                    ->withProperties($properties)
                    ->log($description);
                return redirect()->back()->with([
                    'success' => 'Berhasil menghapus data surat masuk.'
                ]);
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak punya akses menghapus surat masuk.';
                $properties = [
                    'ip' => RequestSuratMasuk::ip(),
                    'user_agent' => RequestSuratMasuk::userAgent(),
                    'method' => RequestSuratMasuk::method(),
                    'url' => RequestSuratMasuk::url(),
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
            $description = $user->name . ' gagal akses halaman edit surat masuk.';
            $properties = [
                'ip' => RequestSuratMasuk::ip(),
                'user_agent' => RequestSuratMasuk::userAgent(),
                'method' => RequestSuratMasuk::method(),
                'url' => RequestSuratMasuk::url()
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

    public function downloadSuratMasuk($id)
    {
        try {
            $suratMasuk = SuratMasuk::find($id);
            if (Storage::exists($suratMasuk->file_lokasi)) {
                return Storage::download($suratMasuk->file_lokasi);
            } else {
                return redirect()->back()->with([
                    'error' => 'File tidak ditemukan.',
                ]);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with([
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function uploadLampiran(StoreLampiranRequest $request, $uuid)
    {
        try {
            $suratMasuk = SuratMasuk::where('uuid', $request->uuid)->first();
            if ($request->hasFile('file_lampiran')) {
                $lampiran = $request->file('file_lampiran')->store('file/suratmasuk/' . $uuid . '/' . 'lampiran/');
                $temp = Lampiran::create([
                    'name' => $request->name,
                    'file_lokasi' => $lampiran,
                    'lampiranable_type' => SuratMasuk::class,
                    'lampiranable_id' => $suratMasuk->id,
                    'created_by' => Auth::id(),
                ]);
                $user = User::find(Auth::id());
                $subject = 'store';
                $description = $user->name . ' akses halaman show surat masuk.';
                $properties = [
                    'ip' => RequestSuratMasuk::ip(),
                    'user_agent' => RequestSuratMasuk::userAgent(),
                    'method' => RequestSuratMasuk::method(),
                    'url' => RequestSuratMasuk::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->performedOn($temp)
                    ->withProperties($properties)
                    ->log($description);
                return redirect()->back()->with([
                    'success' => 'Berhasil menambah lampiran.',
                ]);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with([
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function downloadLampiran($id)
    {
        try {
            $lampiran = Lampiran::find($id);
            if (Storage::exists($lampiran->file_lokasi)) {
                return Storage::download($lampiran->file_lokasi);
            } else {
                return redirect()->back()->with([
                    'error' => 'File tidak ditemukan.',
                ]);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with([
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function deleteLampiran($id)
    {
        try {
            $lampiran = Lampiran::find($id);
            if (Storage::exists($lampiran->file_lokasi)) {
                Storage::delete($lampiran->file_lokasi);
                $lampiran->delete();
                return redirect()->back()->with([
                    'success' => 'Lampiran berhasil dihapus.',
                ]);
            } else {
                return redirect()->back()->with([
                    'error' => 'File tidak ditemukan.',
                ]);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with([
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function setLokasi(LokasiSuratMasukRequest $request, $id)
    {
        try {
            $lokasi_document = LokasiSuratMasuk::create([
                'lokasi_id' => $request->lokasi_id,
                'surat_masuk_id' => $id,
                'name' => $request->name,
                'created_by' => Auth::id()
            ]);
            $user = User::find(Auth::id());
            $subject = 'store';
            $description = $user->name . ' menambah lokasi surat masuk.';
            $properties = [
                'ip' => RequestSuratMasuk::ip(),
                'user_agent' => RequestSuratMasuk::userAgent(),
                'method' => RequestSuratMasuk::method(),
                'url' => RequestSuratMasuk::url(),
            ];

            activity($subject)
                ->by($user)
                ->performedOn($lokasi_document)
                ->withProperties($properties)
                ->log($description);
            return redirect()->back()->with([
                'success' => $user->name . ' menambah lokasi surat masuk.',
            ]);
        } catch (\Throwable $th) {
            $user = User::find(Auth::id());
            $subject = 'error';
            $description = $user->name . ' gagal menambah lokasi surat masuk.';
            $properties = [
                'ip' => RequestSuratMasuk::ip(),
                'user_agent' => RequestSuratMasuk::userAgent(),
                'method' => RequestSuratMasuk::method(),
                'url' => RequestSuratMasuk::url()
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
            $lokasi_document = LokasiSuratMasuk::find($id);
            $lokasi_document->update([
                'lokasi_id' => $request->lokasi_id,
                'name' => $request->name,
                'updated_by' => Auth::id()
            ]);
            $user = User::find(Auth::id());
            $subject = 'updated';
            $description = $user->name . ' update lokasi surat masuk.';
            $properties = [
                'ip' => RequestSuratMasuk::ip(),
                'user_agent' => RequestSuratMasuk::userAgent(),
                'method' => RequestSuratMasuk::method(),
                'url' => RequestSuratMasuk::url(),
            ];

            activity($subject)
                ->by($user)
                ->performedOn($lokasi_document)
                ->withProperties($properties)
                ->log($description);
            return redirect()->back()->with([
                'success' => $user->name . ' update lokasi surat masuk.',
            ]);
        } catch (\Throwable $th) {
            $user = User::find(Auth::id());
            $subject = 'error';
            $description = $user->name . ' gagal update lokasi surat masuk.';
            $properties = [
                'ip' => RequestSuratMasuk::ip(),
                'user_agent' => RequestSuratMasuk::userAgent(),
                'method' => RequestSuratMasuk::method(),
                'url' => RequestSuratMasuk::url()
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
            $lokasi_document = LokasiSuratMasuk::find($id);
            $lokasi_document->delete();
            $user = User::find(Auth::id());
            $subject = 'updated';
            $description = $user->name . ' hapus lokasi surat masuk.';
            $properties = [
                'ip' => RequestSuratMasuk::ip(),
                'user_agent' => RequestSuratMasuk::userAgent(),
                'method' => RequestSuratMasuk::method(),
                'url' => RequestSuratMasuk::url(),
            ];

            activity($subject)
                ->by($user)
                ->performedOn($lokasi_document)
                ->withProperties($properties)
                ->log($description);
            return redirect()->back()->with([
                'success' => $user->name . ' hapus lokasi surat masuk.',
            ]);
        } catch (\Throwable $th) {
            $user = User::find(Auth::id());
            $subject = 'error';
            $description = $user->name . ' gagal hapus lokasi surat masuk.';
            $properties = [
                'ip' => RequestSuratMasuk::ip(),
                'user_agent' => RequestSuratMasuk::userAgent(),
                'method' => RequestSuratMasuk::method(),
                'url' => RequestSuratMasuk::url()
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

    public function storeDisposisi(Request $request, $id)
    {
        try {
            $suratMasuk = SuratMasuk::find($id);
            foreach ($request->diteruskan_kepada as $kpd) {
                $disposisi = Disposisi::create(
                    [
                        'kd_surat' => $suratMasuk->uuid,
                        'diteruskan_kepada' => $kpd,
                        'isi_disposisi' => $request->isi_disposisi,
                        'status' => 'TERKIRIM',
                        'created_by' => Auth::id()
                    ]
                );
                $user = User::find($kpd);
                Mail::to($user->email)->send(new SuratMasukBaru($suratMasuk->isi_ringkas, $suratMasuk->tanggal_surat, $suratMasuk->nama_pengirim, $suratMasuk->uuid));
            }
            $user = User::find(Auth::id());
            $subject = 'store';
            $description = $user->name . ' menambah disposisi.';
            $properties = [
                'ip' => RequestSuratMasuk::ip(),
                'user_agent' => RequestSuratMasuk::userAgent(),
                'method' => RequestSuratMasuk::method(),
                'url' => RequestSuratMasuk::url(),
            ];

            activity($subject)
                ->by($user)
                ->performedOn($suratMasuk)
                ->withProperties($properties)
                ->log($description);
            return redirect()->back()->with([
                'success' => 'Berhasil menambah disposisi.',
            ]);
        } catch (\Throwable $th) {
            $user = User::find(Auth::id());
            $subject = 'error';
            $description = $user->name . ' gagal menambah disposisi.';
            $properties = [
                'ip' => RequestSuratMasuk::ip(),
                'user_agent' => RequestSuratMasuk::userAgent(),
                'method' => RequestSuratMasuk::method(),
                'url' => RequestSuratMasuk::url()
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

    public function updateDisposisi(Request $request, $id)
    {
        try {
            $disposisi = Disposisi::find($id);

            $disposisi->update(
                [
                    'status' => $request->status,
                    'updated_by' => Auth::id(),
                    'tanggal_disahkan' => today()
                ]
            );

            $user = User::find(Auth::id());
            $subject = 'update';
            $description = $user->name . ' update disposisi.';
            $properties = [
                'ip' => RequestSuratMasuk::ip(),
                'user_agent' => RequestSuratMasuk::userAgent(),
                'method' => RequestSuratMasuk::method(),
                'url' => RequestSuratMasuk::url(),
            ];

            activity($subject)
                ->by($user)
                ->performedOn($disposisi)
                ->withProperties($properties)
                ->log($description);
            return redirect()->back()->with([
                'success' => 'Berhasil update disposisi.',
            ]);
        } catch (\Throwable $th) {
            $user = User::find(Auth::id());
            $subject = 'error';
            $description = $user->name . ' gagal update disposisi.';
            $properties = [
                'ip' => RequestSuratMasuk::ip(),
                'user_agent' => RequestSuratMasuk::userAgent(),
                'method' => RequestSuratMasuk::method(),
                'url' => RequestSuratMasuk::url()
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
            $suratMasuk = SuratMasuk::find($id);

            if ($request->hasFile('file_lampiran')) {
                // Hapus file lama
                if (Storage::exists($suratMasuk->file_lokasi)) {
                    Storage::delete($suratMasuk->file_lokasi);
                }
                $file = $request->file('file_lampiran');
                $filename = $file->getClientOriginalName();
                $file->move('file/suratmasuk/' . $suratMasuk->uuid . '/', $filename);
                $suratMasuk->update([
                    'file_lokasi' => 'file/suratmasuk/' . $suratMasuk->uuid . '/' . $filename
                ]);
            }
            $user = User::find(Auth::id());
            $subject = 'updated';
            $description = $user->name . ' berhasil update document surat masuk.';
            $properties = [
                'ip' => RequestSuratMasuk::ip(),
                'user_agent' => RequestSuratMasuk::userAgent(),
                'method' => RequestSuratMasuk::method(),
                'url' => RequestSuratMasuk::url()
            ];

            activity($subject)
                ->by($user)
                ->performedOn($suratMasuk)
                ->withProperties($properties)
                ->log($description);
            return redirect()->back()->with([
                'success' => 'Berhasil mengubah data surat masuk.'
            ]);
        } catch (\Throwable $th) {
            $user = User::find(Auth::id());
            $subject = 'error';
            $description = $user->name . ' gagal akses halaman edit surat masuk.';
            $properties = [
                'ip' => RequestSuratMasuk::ip(),
                'user_agent' => RequestSuratMasuk::userAgent(),
                'method' => RequestSuratMasuk::method(),
                'url' => RequestSuratMasuk::url()
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
}
