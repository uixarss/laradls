<?php

namespace App\Http\Controllers;

use App\Http\Requests\LokasiRequest;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as RequestLokasi;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\BaseController;

class LokasiController extends BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            if (auth()->user()->hasPermissionTo('read-kearsipan')) {
                $data_lokasi = Lokasi::orderBy('kode', 'ASC')->get();
                $user = User::find(Auth::id());
                $subject = 'read';
                $description = $user->name . ' melihat halaman kearsipan.';
                $properties = [
                    'ip' => RequestLokasi::ip(),
                    'user_agent' => RequestLokasi::userAgent(),
                    'method' => RequestLokasi::method(),
                    'url' => RequestLokasi::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->withProperties($properties)
                    ->log($description);
                return view('pages.data-master.kearsipan', compact('data_lokasi'));
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak bisa akses halaman lokasi kearsipan.';
                $properties = [
                    'ip' => RequestLokasi::ip(),
                    'user_agent' => RequestLokasi::userAgent(),
                    'method' => RequestLokasi::method(),
                    'url' => RequestLokasi::url(),
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
            $description = $user->name . ' gagal akses halaman kearsipan.';
            $properties = [
                'ip' => RequestLokasi::ip(),
                'user_agent' => RequestLokasi::userAgent(),
                'method' => RequestLokasi::method(),
                'url' => RequestLokasi::url()
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
    public function store(LokasiRequest $request)
    {
        try {
            if (auth()->user()->hasPermissionTo('create-kearsipan')) {
                $kearsipan = Lokasi::create([
                    'uuid' => Str::uuid(),
                    'kode' => $request->kode,
                    'name' => $request->name,
                    'created_by' => Auth::id()
                ]);
                $user = User::find(Auth::id());
                $subject = 'store';
                $description = $user->name . ' menambah kearsipan.';
                $properties = [
                    'ip' => RequestLokasi::ip(),
                    'user_agent' => RequestLokasi::userAgent(),
                    'method' => RequestLokasi::method(),
                    'url' => RequestLokasi::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->performedOn($kearsipan)
                    ->withProperties($properties)
                    ->log($description);
                return redirect()->back()->with([
                    'success' => $kearsipan->name . ' berhasil ditambahkan.',
                ]);
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak bisa akses membuat lokasi kearsipan baru.';
                $properties = [
                    'ip' => RequestLokasi::ip(),
                    'user_agent' => RequestLokasi::userAgent(),
                    'method' => RequestLokasi::method(),
                    'url' => RequestLokasi::url(),
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
            $description = $user->name . ' gagal membuat kearsipan baru.';
            $properties = [
                'ip' => RequestLokasi::ip(),
                'user_agent' => RequestLokasi::userAgent(),
                'method' => RequestLokasi::method(),
                'url' => RequestLokasi::url()
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
     * @param  \App\Models\Lokasi  $lokasi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            if (auth()->user()->hasPermissionTo('update-kearsipan')) {
                $lokasi = Lokasi::find($id);
                $lokasi->update([
                    'kode' => $request->kode,
                    'name' => $request->name,
                    'updated_by' => Auth::id()
                ]);
                $user = User::find(Auth::id());
                $subject = 'updated';
                $description = $user->name . ' mengubah kearsipan.';
                $properties = [
                    'ip' => RequestLokasi::ip(),
                    'user_agent' => RequestLokasi::userAgent(),
                    'method' => RequestLokasi::method(),
                    'url' => RequestLokasi::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->performedOn($lokasi)
                    ->withProperties($properties)
                    ->log($description);
                return redirect()->back()->with([
                    'success' => $lokasi->name . ' berhasil diubah.',
                ]);
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak bisa akses mengubah lokasi kearsipan.';
                $properties = [
                    'ip' => RequestLokasi::ip(),
                    'user_agent' => RequestLokasi::userAgent(),
                    'method' => RequestLokasi::method(),
                    'url' => RequestLokasi::url(),
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
            $description = $user->name . ' gagal update kearsipan.';
            $properties = [
                'ip' => RequestLokasi::ip(),
                'user_agent' => RequestLokasi::userAgent(),
                'method' => RequestLokasi::method(),
                'url' => RequestLokasi::url()
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
     * @param  \App\Models\Lokasi  $lokasi
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            if (auth()->user()->hasPermissionTo('delete-kearsipan')) {
                $lokasi = Lokasi::find($id);
                $lokasi->delete();
                $user = User::find(Auth::id());
                $subject = 'deleted';
                $description = $user->name . ' menghapus kearsipan.';
                $properties = [
                    'ip' => RequestLokasi::ip(),
                    'user_agent' => RequestLokasi::userAgent(),
                    'method' => RequestLokasi::method(),
                    'url' => RequestLokasi::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->performedOn($lokasi)
                    ->withProperties($properties)
                    ->log($description);
                return redirect()->back()->with([
                    'success' => $lokasi->name . ' berhasil dihapus.',
                ]);
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak bisa akses menghapus lokasi kearsipan.';
                $properties = [
                    'ip' => RequestLokasi::ip(),
                    'user_agent' => RequestLokasi::userAgent(),
                    'method' => RequestLokasi::method(),
                    'url' => RequestLokasi::url(),
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
            $description = $user->name . ' gagal hapus kearsipan.';
            $properties = [
                'ip' => RequestLokasi::ip(),
                'user_agent' => RequestLokasi::userAgent(),
                'method' => RequestLokasi::method(),
                'url' => RequestLokasi::url()
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
}
