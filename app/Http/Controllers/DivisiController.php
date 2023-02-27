<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\BaseController;
use App\Http\Requests\StoreDivisiRequest;
use App\Http\Requests\UpdateDivisiRequest;
use App\Models\Divisi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as RequestDivisi;

class DivisiController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data_divisi = Divisi::orderBy('kode', 'ASC')->get();
            $user = User::find(Auth::id());
            $subject = 'read';
            $description = $user->name . ' melihat halaman divisi.';
            $properties = [
                'ip' => RequestDivisi::ip(),
                'user_agent' => RequestDivisi::userAgent(),
                'method' => RequestDivisi::method(),
                'url' => RequestDivisi::url(),
            ];

            activity($subject)
                ->by($user)
                ->withProperties($properties)
                ->log($description);
            return view('pages.data-master.divisi', compact('data_divisi'));
        } catch (\Throwable $th) {
            $user = User::find(Auth::id());
            $subject = 'error';
            $description = $user->name . ' gagal akses halaman divisi.';
            $properties = [
                'ip' => RequestDivisi::ip(),
                'user_agent' => RequestDivisi::userAgent(),
                'method' => RequestDivisi::method(),
                'url' => RequestDivisi::url()
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDivisiRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDivisiRequest $request)
    {
        try {

            $divisi = Divisi::create([
                'kode' => $request->kode,
                'name' => $request->name,
                'created_by' => Auth::id(),
            ]);
            $user = User::find(Auth::id());
            $subject = 'store';
            $description = $user->name . ' melihat halaman divisi.';
            $properties = [
                'ip' => RequestDivisi::ip(),
                'user_agent' => RequestDivisi::userAgent(),
                'method' => RequestDivisi::method(),
                'url' => RequestDivisi::url(),
            ];

            activity($subject)
                ->by($user)
                ->performedOn($divisi)
                ->withProperties($properties)
                ->log($description);
            return redirect()->back()->with([
                'success' => 'Berhasil menambah divisi.',
            ]);
        } catch (\Throwable $th) {
            $user = User::find(Auth::id());
            $subject = 'error';
            $description = $user->name . ' gagal melihat halaman divisi.';
            $properties = [
                'ip' => RequestDivisi::ip(),
                'user_agent' => RequestDivisi::userAgent(),
                'method' => RequestDivisi::method(),
                'url' => RequestDivisi::url(),
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
     * @param  \App\Models\Divisi  $divisi
     * @return \Illuminate\Http\Response
     */
    public function show(Divisi $divisi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Divisi  $divisi
     * @return \Illuminate\Http\Response
     */
    public function edit(Divisi $divisi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDivisiRequest  $request
     * @param  \App\Models\Divisi  $divisi
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDivisiRequest $request, Divisi $divisi)
    {
        try {

            $divisi->update([
                'kode' => $request->kode,
                'name' => $request->name,
                'updated_by' => Auth::id(),
            ]);
            $user = User::find(Auth::id());
            $subject = 'updated';
            $description = $user->name . ' melihat halaman divisi.';
            $properties = [
                'ip' => RequestDivisi::ip(),
                'user_agent' => RequestDivisi::userAgent(),
                'method' => RequestDivisi::method(),
                'url' => RequestDivisi::url(),
            ];

            activity($subject)
                ->by($user)
                ->performedOn($divisi)
                ->withProperties($properties)
                ->log($description);
            return redirect()->back()->with([
                'success' => 'Berhasil mengubah kode/nama divisi.',
            ]);
        } catch (\Throwable $th) {
            $subject = 'error';
            $description = $user->name . ' gagal update divisi.';
            $properties = [
                'ip' => RequestDivisi::ip(),
                'user_agent' => RequestDivisi::userAgent(),
                'method' => RequestDivisi::method(),
                'url' => RequestDivisi::url(),
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
     * @param  \App\Models\Divisi  $divisi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Divisi $divisi)
    {
        try {

            $divisi->delete();
            $user = User::find(Auth::id());
            $subject = 'delete';
            $description = $user->name . ' melihat halaman divisi.';
            $properties = [
                'ip' => RequestDivisi::ip(),
                'user_agent' => RequestDivisi::userAgent(),
                'method' => RequestDivisi::method(),
                'url' => RequestDivisi::url(),
            ];

            activity($subject)
                ->by($user)
                ->performedOn($divisi)
                ->withProperties($properties)
                ->log($description);
            return redirect()->back()->with([
                'success' => 'Berhasil menghapus divisi.',
            ]);
        } catch (\Throwable $th) {
            $subject = 'error';
            $description = $user->name . ' gagal menghapus divisi.';
            $properties = [
                'ip' => RequestDivisi::ip(),
                'user_agent' => RequestDivisi::userAgent(),
                'method' => RequestDivisi::method(),
                'url' => RequestDivisi::url(),
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
