<?php

namespace App\Http\Controllers;

use App\DataTables\KlasifikasiDataTable;
use App\Exports\KlasifikasiExport;
use App\Exports\SampleKlasifikasiExport;
use App\Http\Requests\ImportKlasifikasiRequest;
use App\Http\Requests\KlasifikasiRequest;
use App\Imports\ImportKlasifikasi;
use App\Models\Klasifikasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as RequestKlasifikasi;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Admin\BaseController;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Carbon;

class KlasifikasiController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            if (auth()->user()->hasPermissionTo('read-klasifikasi')) {
                $data_klasifikasi = Klasifikasi::orderBy('kode_klasifikasi', 'ASC')
                    ->select(['id', 'kode_klasifikasi', 'name'])
                    ->get();
                $user = User::find(Auth::id());
                $subject = 'read';
                $description = $user->name . ' melihat halaman klasifikasi.';
                $properties = [
                    'ip' => RequestKlasifikasi::ip(),
                    'user_agent' => RequestKlasifikasi::userAgent(),
                    'method' => RequestKlasifikasi::method(),
                    'url' => RequestKlasifikasi::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->withProperties($properties)
                    ->log($description);

                return view('pages.data-master.klasifikasi', compact('data_klasifikasi'));
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak memiliki akses halaman klasifikasi.';
                $properties = [
                    'ip' => RequestKlasifikasi::ip(),
                    'user_agent' => RequestKlasifikasi::userAgent(),
                    'method' => RequestKlasifikasi::method(),
                    'url' => RequestKlasifikasi::url(),
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
            $description = $user->name . ' gagal akses halaman klasifikasi.';
            $properties = [
                'ip' => RequestKlasifikasi::ip(),
                'user_agent' => RequestKlasifikasi::userAgent(),
                'method' => RequestKlasifikasi::method(),
                'url' => RequestKlasifikasi::url()
            ];

            activity($subject)
                ->by($user)
                ->withProperties($properties)
                ->log($description);
            return redirect('/dashboard')->with([
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
    public function store(KlasifikasiRequest $request)
    {
        try {
            if (auth()->user()->hasPermissionTo('create-klasifikasi')) {
                $klasifikasi = Klasifikasi::create([
                    'kode_klasifikasi' => $request->kode_klasifikasi,
                    'name' => $request->name,
                ]);
                $user = User::find(Auth::id());
                $subject = 'store';
                $description = $user->name . ' menambah klasifikasi.';
                $properties = [
                    'ip' => RequestKlasifikasi::ip(),
                    'user_agent' => RequestKlasifikasi::userAgent(),
                    'method' => RequestKlasifikasi::method(),
                    'url' => RequestKlasifikasi::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->performedOn($klasifikasi)
                    ->withProperties($properties)
                    ->log($description);
                return redirect()->back()->with([
                    'success' => $klasifikasi->name . ' berhasil ditambahkan.',
                ]);
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak memiliki akses menambah klasifikasi baru.';
                $properties = [
                    'ip' => RequestKlasifikasi::ip(),
                    'user_agent' => RequestKlasifikasi::userAgent(),
                    'method' => RequestKlasifikasi::method(),
                    'url' => RequestKlasifikasi::url(),
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
            $description = $user->name . ' gagal membuat klasifikasi baru.';
            $properties = [
                'ip' => RequestKlasifikasi::ip(),
                'user_agent' => RequestKlasifikasi::userAgent(),
                'method' => RequestKlasifikasi::method(),
                'url' => RequestKlasifikasi::url()
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Klasifikasi $klasifikasi)
    {
        try {
            if (auth()->user()->hasPermissionTo('update-klasifikasi')) {
                $klasifikasi->update([
                    'kode_klasifikasi' => $request->kode_klasifikasi,
                    'name' => $request->name,
                ]);
                $user = User::find(Auth::id());
                $subject = 'updated';
                $description = $user->name . ' mengubah klasifikasi.';
                $properties = [
                    'ip' => RequestKlasifikasi::ip(),
                    'user_agent' => RequestKlasifikasi::userAgent(),
                    'method' => RequestKlasifikasi::method(),
                    'url' => RequestKlasifikasi::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->performedOn($klasifikasi)
                    ->withProperties($properties)
                    ->log($description);
                return redirect()->back()->with([
                    'success' => $klasifikasi->name . ' berhasil diubah.',
                ]);
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak memiliki akses mengubah klasifikasi.';
                $properties = [
                    'ip' => RequestKlasifikasi::ip(),
                    'user_agent' => RequestKlasifikasi::userAgent(),
                    'method' => RequestKlasifikasi::method(),
                    'url' => RequestKlasifikasi::url(),
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
            $description = $user->name . ' gagal update klasifikasi.';
            $properties = [
                'ip' => RequestKlasifikasi::ip(),
                'user_agent' => RequestKlasifikasi::userAgent(),
                'method' => RequestKlasifikasi::method(),
                'url' => RequestKlasifikasi::url()
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Klasifikasi $klasifikasi)
    {
        try {
            if (auth()->user()->hasPermissionTo('delete-klasifikasi')) {
                $klasifikasi->delete();
                $user = User::find(Auth::id());
                $subject = 'deleted';
                $description = $user->name . ' menghapus klasifikasi.';
                $properties = [
                    'ip' => RequestKlasifikasi::ip(),
                    'user_agent' => RequestKlasifikasi::userAgent(),
                    'method' => RequestKlasifikasi::method(),
                    'url' => RequestKlasifikasi::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->performedOn($klasifikasi)
                    ->withProperties($properties)
                    ->log($description);
                return redirect()->back()->with([
                    'success' => $klasifikasi->name . ' berhasil dihapus.',
                ]);
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak memiliki akses menghapus klasifikasi.';
                $properties = [
                    'ip' => RequestKlasifikasi::ip(),
                    'user_agent' => RequestKlasifikasi::userAgent(),
                    'method' => RequestKlasifikasi::method(),
                    'url' => RequestKlasifikasi::url(),
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
            $description = $user->name . ' gagal hapus klasifikasi.';
            $properties = [
                'ip' => RequestKlasifikasi::ip(),
                'user_agent' => RequestKlasifikasi::userAgent(),
                'method' => RequestKlasifikasi::method(),
                'url' => RequestKlasifikasi::url()
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

    public function exportSample()
    {
        // Export Sample xlsx
        try {
            $user = User::find(Auth::id());
            $subject = 'export';
            $description = $user->name . ' export sample klasifikasi.';
            $properties = [
                'ip' => RequestKlasifikasi::ip(),
                'user_agent' => RequestKlasifikasi::userAgent(),
                'method' => RequestKlasifikasi::method(),
                'url' => RequestKlasifikasi::url(),
            ];

            activity($subject)
                ->by($user)
                ->withProperties($properties)
                ->log($description);
            return Excel::download(new SampleKlasifikasiExport, 'sample_klasifikasi.xlsx');
        } catch (\Throwable $th) {
            $user = User::find(Auth::id());
            $subject = 'error';
            $description = $user->name . ' gagal download sample klasifikasi.';
            $properties = [
                'ip' => RequestKlasifikasi::ip(),
                'user_agent' => RequestKlasifikasi::userAgent(),
                'method' => RequestKlasifikasi::method(),
                'url' => RequestKlasifikasi::url()
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

    public function export()
    {
        // Export xlsx
        try {
            if (auth()->user()->hasPermissionTo('export-klasifikasi')) {
                $user = User::find(Auth::id());
                $subject = 'export';
                $description = $user->name . ' export klasifikasi.';
                $properties = [
                    'ip' => RequestKlasifikasi::ip(),
                    'user_agent' => RequestKlasifikasi::userAgent(),
                    'method' => RequestKlasifikasi::method(),
                    'url' => RequestKlasifikasi::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->withProperties($properties)
                    ->log($description);
                return Excel::download(new KlasifikasiExport, time() . '_klasifikasi.xlsx');
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak memiliki akses mengeksport klasifikasi.';
                $properties = [
                    'ip' => RequestKlasifikasi::ip(),
                    'user_agent' => RequestKlasifikasi::userAgent(),
                    'method' => RequestKlasifikasi::method(),
                    'url' => RequestKlasifikasi::url(),
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
            $description = $user->name . ' gagal download klasifikasi.';
            $properties = [
                'ip' => RequestKlasifikasi::ip(),
                'user_agent' => RequestKlasifikasi::userAgent(),
                'method' => RequestKlasifikasi::method(),
                'url' => RequestKlasifikasi::url()
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

    public function import(ImportKlasifikasiRequest $request)
    {
        try {
            if (auth()->user()->hasPermissionTo('export-klasifikasi')) {
                Excel::import(new ImportKlasifikasi, $request->file_klasifikasi);
                $user = User::find(Auth::id());
                $subject = 'store';
                $description = $user->name . ' import klasifikasi.';
                $properties = [
                    'ip' => RequestKlasifikasi::ip(),
                    'user_agent' => RequestKlasifikasi::userAgent(),
                    'method' => RequestKlasifikasi::method(),
                    'url' => RequestKlasifikasi::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->withProperties($properties)
                    ->log($description);
                return redirect()->back()->with([
                    'success' => 'Berhasil import kode klasifikasi.',
                ]);
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak memiliki akses import data klasifikasi.';
                $properties = [
                    'ip' => RequestKlasifikasi::ip(),
                    'user_agent' => RequestKlasifikasi::userAgent(),
                    'method' => RequestKlasifikasi::method(),
                    'url' => RequestKlasifikasi::url(),
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
            $description = $user->name . ' gagal import klasifikasi.';
            $properties = [
                'ip' => RequestKlasifikasi::ip(),
                'user_agent' => RequestKlasifikasi::userAgent(),
                'method' => RequestKlasifikasi::method(),
                'url' => RequestKlasifikasi::url()
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

    public function delete(Klasifikasi $klasifikasi)
    {
        try {
            if (auth()->user()->hasPermissionTo('delete-klasifikasi')) {
                $klasifikasi->delete();
                $user = User::find(Auth::id());
                $subject = 'deleted';
                $description = $user->name . ' menghapus klasifikasi.';
                $properties = [
                    'ip' => RequestKlasifikasi::ip(),
                    'user_agent' => RequestKlasifikasi::userAgent(),
                    'method' => RequestKlasifikasi::method(),
                    'url' => RequestKlasifikasi::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->performedOn($klasifikasi)
                    ->withProperties($properties)
                    ->log($description);
                return redirect()->back()->with([
                    'success' => $klasifikasi->name . ' berhasil dihapus.',
                ]);
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak memiliki akses menghapus klasifikasi.';
                $properties = [
                    'ip' => RequestKlasifikasi::ip(),
                    'user_agent' => RequestKlasifikasi::userAgent(),
                    'method' => RequestKlasifikasi::method(),
                    'url' => RequestKlasifikasi::url(),
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
            $description = $user->name . ' gagal hapus klasifikasi.';
            $properties = [
                'ip' => RequestKlasifikasi::ip(),
                'user_agent' => RequestKlasifikasi::userAgent(),
                'method' => RequestKlasifikasi::method(),
                'url' => RequestKlasifikasi::url()
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

    public function data(Request $request)
    {
        $model = Klasifikasi::select([
            'updated_at', 'kode_klasifikasi',
            'name', 'id'
        ])->orderBy('kode_klasifikasi', 'asc');
        return Datatables::eloquent($model)
            ->addColumn('updated_at', function (Klasifikasi $log) {
                return Carbon::parse($log->updated_at)->format('d M Y H:i');
            })
            ->editColumn('kode_klasifikasi', function (Klasifikasi $log) {
                return $log->kode_klasifikasi;
            })
            ->editColumn('name', function (Klasifikasi $log) {
                return $log->name ?? '';
            })
            ->rawColumns(['kode_klasifikasi', 'name'])
            ->toJson();
    }

    public function edit($id)
    {
    }
}
