<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\BaseController;
use App\Http\Requests\JenisSuratRequest;
use App\Models\JenisSurat;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as RequestJenisSurat;

class JenisSuratController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            if (auth()->user()->hasPermissionTo('read-sifat-surat')) {
                $data_jenis = JenisSurat::orderBy('kode', 'ASC')->get();
                $user = User::find(Auth::id());
                $subject = 'read';
                $description = $user->name . ' melihat halaman jenis surat.';
                $properties = [
                    'ip' => RequestJenisSurat::ip(),
                    'user_agent' => RequestJenisSurat::userAgent(),
                    'method' => RequestJenisSurat::method(),
                    'url' => RequestJenisSurat::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->withProperties($properties)
                    ->log($description);
                return view('pages.data-master.jenissurat', compact('data_jenis'));
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak bisa akses halaman sifat surat.';
                $properties = [
                    'ip' => RequestJenisSurat::ip(),
                    'user_agent' => RequestJenisSurat::userAgent(),
                    'method' => RequestJenisSurat::method(),
                    'url' => RequestJenisSurat::url(),
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
                'ip' => RequestJenisSurat::ip(),
                'user_agent' => RequestJenisSurat::userAgent(),
                'method' => RequestJenisSurat::method(),
                'url' => RequestJenisSurat::url()
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
    public function store(JenisSuratRequest $request)
    {
        try {
            if (auth()->user()->hasPermissionTo('create-sifat-surat')) {
                $jenis = JenisSurat::create([
                    'uuid' => Str::uuid(),
                    'kode' => $request->kode,
                    'name' => $request->name,
                    'created_by' => Auth::id()
                ]);
                $user = User::find(Auth::id());
                $subject = 'store';
                $description = $user->name . ' menambah jenis surat.';
                $properties = [
                    'ip' => RequestJenisSurat::ip(),
                    'user_agent' => RequestJenisSurat::userAgent(),
                    'method' => RequestJenisSurat::method(),
                    'url' => RequestJenisSurat::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->performedOn($jenis)
                    ->withProperties($properties)
                    ->log($description);
                return redirect()->back()->with([
                    'success' => $jenis->name . ' berhasil ditambahkan.',
                ]);
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak bisa akses membuat sifat surat baru.';
                $properties = [
                    'ip' => RequestJenisSurat::ip(),
                    'user_agent' => RequestJenisSurat::userAgent(),
                    'method' => RequestJenisSurat::method(),
                    'url' => RequestJenisSurat::url(),
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
            $description = $user->name . ' gagal membuat jenis surat baru.';
            $properties = [
                'ip' => RequestJenisSurat::ip(),
                'user_agent' => RequestJenisSurat::userAgent(),
                'method' => RequestJenisSurat::method(),
                'url' => RequestJenisSurat::url()
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
            if (auth()->user()->hasPermissionTo('update-sifat-surat')) {
                $jenis = JenisSurat::find($id);
                $jenis->update([
                    'kode' => $request->kode,
                    'name' => $request->name,
                    'updated_by' => Auth::id()
                ]);
                $user = User::find(Auth::id());
                $subject = 'updated';
                $description = $user->name . ' mengubah jenis surat.';
                $properties = [
                    'ip' => RequestJenisSurat::ip(),
                    'user_agent' => RequestJenisSurat::userAgent(),
                    'method' => RequestJenisSurat::method(),
                    'url' => RequestJenisSurat::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->performedOn($jenis)
                    ->withProperties($properties)
                    ->log($description);
                return redirect()->back()->with([
                    'success' => $jenis->name . ' berhasil diubah.',
                ]);
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak bisa akses mengubah sifat surat.';
                $properties = [
                    'ip' => RequestJenisSurat::ip(),
                    'user_agent' => RequestJenisSurat::userAgent(),
                    'method' => RequestJenisSurat::method(),
                    'url' => RequestJenisSurat::url(),
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
            $description = $user->name . ' gagal update jenis surat.';
            $properties = [
                'ip' => RequestJenisSurat::ip(),
                'user_agent' => RequestJenisSurat::userAgent(),
                'method' => RequestJenisSurat::method(),
                'url' => RequestJenisSurat::url()
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
            if (auth()->user()->hasPermissionTo('delete-sifat-surat')) {
                $jenis = JenisSurat::find($id);
                $jenis->delete();
                $user = User::find(Auth::id());
                $subject = 'deleted';
                $description = $user->name . ' menghapus jenis surat.';
                $properties = [
                    'ip' => RequestJenisSurat::ip(),
                    'user_agent' => RequestJenisSurat::userAgent(),
                    'method' => RequestJenisSurat::method(),
                    'url' => RequestJenisSurat::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->performedOn($jenis)
                    ->withProperties($properties)
                    ->log($description);
                return redirect()->back()->with([
                    'success' => $jenis->name . ' berhasil dihapus.',
                ]);
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak bisa akses mengubah sifat surat.';
                $properties = [
                    'ip' => RequestJenisSurat::ip(),
                    'user_agent' => RequestJenisSurat::userAgent(),
                    'method' => RequestJenisSurat::method(),
                    'url' => RequestJenisSurat::url(),
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
            $description = $user->name . ' gagal hapus jenis surat.';
            $properties = [
                'ip' => RequestJenisSurat::ip(),
                'user_agent' => RequestJenisSurat::userAgent(),
                'method' => RequestJenisSurat::method(),
                'url' => RequestJenisSurat::url()
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
