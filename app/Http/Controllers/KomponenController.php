<?php

namespace App\Http\Controllers;

use App\Exports\KomponenExport;
use App\Http\Requests\KomponenRequest;
use App\Models\Komponen;
use App\Models\User;
use App\Services\KomponenService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as RequestKomponen;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SampleKomponenExport;
use App\Http\Requests\ImportKomponenRequest;
use App\Imports\ImportKomponen;
use App\Http\Controllers\Admin\BaseController;

class KomponenController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            if (auth()->user()->hasPermissionTo('read-komponen')) {
                $data_komponen = Komponen::orderBy('kode_komponen', 'ASC')->get();
                $user = User::find(Auth::id());
                $subject = 'read';
                $description = $user->name . ' melihat halaman komponen.';
                $properties = [
                    'ip' => RequestKomponen::ip(),
                    'user_agent' => RequestKomponen::userAgent(),
                    'method' => RequestKomponen::method(),
                    'url' => RequestKomponen::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->withProperties($properties)
                    ->log($description);

                return view('pages.data-master.komponen', compact('data_komponen'));
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak memiliki akses halaman komponen.';
                $properties = [
                    'ip' => RequestKomponen::ip(),
                    'user_agent' => RequestKomponen::userAgent(),
                    'method' => RequestKomponen::method(),
                    'url' => RequestKomponen::url(),
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
            $description = $user->name . ' gagal akses halaman komponen.';
            $properties = [
                'ip' => RequestKomponen::ip(),
                'user_agent' => RequestKomponen::userAgent(),
                'method' => RequestKomponen::method(),
                'url' => RequestKomponen::url()
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
    public function store(KomponenRequest $request, KomponenService $komponenService)
    {
        try {
            if (auth()->user()->hasPermissionTo('create-komponen')) {
                $komponen = $komponenService->createKomponen($request);
                $user = User::find(Auth::id());
                $subject = 'store';
                $description = $user->name . ' menambah komponen.';
                $properties = [
                    'ip' => RequestKomponen::ip(),
                    'user_agent' => RequestKomponen::userAgent(),
                    'method' => RequestKomponen::method(),
                    'url' => RequestKomponen::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->performedOn($komponen)
                    ->withProperties($properties)
                    ->log($description);
                return redirect()->back()->with([
                    'success' => $komponen->name . ' berhasil ditambahkan.',
                ]);
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak memiliki akses menambah komponen baru.';
                $properties = [
                    'ip' => RequestKomponen::ip(),
                    'user_agent' => RequestKomponen::userAgent(),
                    'method' => RequestKomponen::method(),
                    'url' => RequestKomponen::url(),
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
            $description = $user->name . ' gagal membuat komponen.';
            $properties = [
                'ip' => RequestKomponen::ip(),
                'user_agent' => RequestKomponen::userAgent(),
                'method' => RequestKomponen::method(),
                'url' => RequestKomponen::url()
            ];

            activity($subject)
                ->by($user)
                ->withProperties($properties)
                ->log($description);

            return redirect('/dashboard')->with([
                'error' => $th->getMessage()
            ]);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Komponen  $komponen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Komponen $komponen)
    {
        try {
            if (auth()->user()->hasPermissionTo('update-komponen')) {
                $komponen->update([
                    'kode_komponen' => $request->kode_komponen,
                    'name' => $request->name,
                ]);
                $user = User::find(Auth::id());
                $subject = 'updated';
                $description = $user->name . ' mengubah komponen.';
                $properties = [
                    'ip' => RequestKomponen::ip(),
                    'user_agent' => RequestKomponen::userAgent(),
                    'method' => RequestKomponen::method(),
                    'url' => RequestKomponen::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->performedOn($komponen)
                    ->withProperties($properties)
                    ->log($description);
                return redirect()->back()->with([
                    'success' => $komponen->name . ' berhasil diubah.',
                ]);
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak memiliki akses mengubah komponen.';
                $properties = [
                    'ip' => RequestKomponen::ip(),
                    'user_agent' => RequestKomponen::userAgent(),
                    'method' => RequestKomponen::method(),
                    'url' => RequestKomponen::url(),
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
            $description = $user->name . ' gagal update komponen.';
            $properties = [
                'ip' => RequestKomponen::ip(),
                'user_agent' => RequestKomponen::userAgent(),
                'method' => RequestKomponen::method(),
                'url' => RequestKomponen::url()
            ];

            activity($subject)
                ->by($user)
                ->withProperties($properties)
                ->log($description);

            return redirect('/dashboard')->with([
                'error' => $th->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Komponen  $komponen
     * @return \Illuminate\Http\Response
     */
    public function destroy(Komponen $komponen)
    {
        try {
            if (auth()->user()->hasPermissionTo('update-komponen')) {
                $komponen->delete();
                $user = User::find(Auth::id());
                $subject = 'deleted';
                $description = $user->name . ' menghapus komponen.';
                $properties = [
                    'ip' => RequestKomponen::ip(),
                    'user_agent' => RequestKomponen::userAgent(),
                    'method' => RequestKomponen::method(),
                    'url' => RequestKomponen::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->performedOn($komponen)
                    ->withProperties($properties)
                    ->log($description);
                return redirect()->back()->with([
                    'success' => $komponen->name . ' berhasil dihapus.',
                ]);
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak memiliki akses menghapus komponen.';
                $properties = [
                    'ip' => RequestKomponen::ip(),
                    'user_agent' => RequestKomponen::userAgent(),
                    'method' => RequestKomponen::method(),
                    'url' => RequestKomponen::url(),
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
            $description = $user->name . ' gagal hapus komponen.';
            $properties = [
                'ip' => RequestKomponen::ip(),
                'user_agent' => RequestKomponen::userAgent(),
                'method' => RequestKomponen::method(),
                'url' => RequestKomponen::url()
            ];

            activity($subject)
                ->by($user)
                ->withProperties($properties)
                ->log($description);

            return redirect('/dashboard')->with([
                'error' => $th->getMessage()
            ]);
        }
    }

    public function exportSample()
    {
        // Export Sample xlsx
        try {
            $user = User::find(Auth::id());
            $subject = 'export';
            $description = $user->name . ' export sample komponen.';
            $properties = [
                'ip' => RequestKomponen::ip(),
                'user_agent' => RequestKomponen::userAgent(),
                'method' => RequestKomponen::method(),
                'url' => RequestKomponen::url()
            ];

            activity($subject)
                ->by($user)
                ->withProperties($properties)
                ->log($description);
            return Excel::download(new SampleKomponenExport, 'sample_komponen.xlsx');
        } catch (\Throwable $th) {
            $user = User::find(Auth::id());
            $subject = 'error';
            $description = $user->name . ' gagal download sample komponen.';
            $properties = [
                'ip' => RequestKomponen::ip(),
                'user_agent' => RequestKomponen::userAgent(),
                'method' => RequestKomponen::method(),
                'url' => RequestKomponen::url()
            ];

            activity($subject)
                ->by($user)
                ->withProperties($properties)
                ->log($description);

            return redirect('/dashboard')->with([
                'error' => $th->getMessage()
            ]);
        }
    }

    public function import(ImportKomponenRequest $request)
    {
        try {
            if (auth()->user()->hasPermissionTo('import-komponen')) {
                Komponen::truncate();
                Excel::import(new ImportKomponen, $request->file_komponen);
                $user = User::find(Auth::id());
                $subject = 'store';
                $description = $user->name . ' import komponen.';
                $properties = [
                    'ip' => RequestKomponen::ip(),
                    'user_agent' => RequestKomponen::userAgent(),
                    'method' => RequestKomponen::method(),
                    'url' => RequestKomponen::url()
                ];

                activity($subject)
                    ->by($user)
                    ->withProperties($properties)
                    ->log($description);
                return redirect()->back()->with([
                    'success' => 'Berhasil import kode komponen.'
                ]);
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak memiliki akses mengimport data komponen.';
                $properties = [
                    'ip' => RequestKomponen::ip(),
                    'user_agent' => RequestKomponen::userAgent(),
                    'method' => RequestKomponen::method(),
                    'url' => RequestKomponen::url(),
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
            $description = $user->name . ' gagal import komponen.';
            $properties = [
                'ip' => RequestKomponen::ip(),
                'user_agent' => RequestKomponen::userAgent(),
                'method' => RequestKomponen::method(),
                'url' => RequestKomponen::url()
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

    public function export()
    {
        // Export xlsx
        try {
            if (auth()->user()->hasPermissionTo('export-komponen')) {
                $user = User::find(Auth::id());
                $subject = 'export';
                $description = $user->name . ' export komponen.';
                $properties = [
                    'ip' => RequestKomponen::ip(),
                    'user_agent' => RequestKomponen::userAgent(),
                    'method' => RequestKomponen::method(),
                    'url' => RequestKomponen::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->withProperties($properties)
                    ->log($description);
                return Excel::download(new KomponenExport, time() . '_komponen.xlsx');
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak memiliki akses eksport data komponen.';
                $properties = [
                    'ip' => RequestKomponen::ip(),
                    'user_agent' => RequestKomponen::userAgent(),
                    'method' => RequestKomponen::method(),
                    'url' => RequestKomponen::url(),
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
            $description = $user->name . ' gagal download komponen.';
            $properties = [
                'ip' => RequestKomponen::ip(),
                'user_agent' => RequestKomponen::userAgent(),
                'method' => RequestKomponen::method(),
                'url' => RequestKomponen::url()
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
