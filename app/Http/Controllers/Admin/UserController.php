<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use App\Http\Requests\UserRequest;
use App\Models\Divisi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as RequestUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            if (auth()->user()->hasPermissionTo('read-user')) {
                $data_user = User::orderBy('name', 'ASC')->get();
                $data_divisi = Divisi::orderBy('kode', 'ASC')->get();
                $data_role = Role::orderBy('name', 'ASC')->get();
                $user = User::find(Auth::id());
                $subject = 'read';
                $description = $user->name . ' melihat halaman pengguna.';
                $properties = [
                    'ip' => RequestUser::ip(),
                    'user_agent' => RequestUser::userAgent(),
                    'method' => RequestUser::method(),
                    'url' => RequestUser::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->withProperties($properties)
                    ->log($description);
                return view('pages.data-master.pengguna.view', compact('data_user', 'data_divisi', 'data_role'));
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak bisa akses halaman pengguna.';
                $properties = [
                    'ip' => RequestUser::ip(),
                    'user_agent' => RequestUser::userAgent(),
                    'method' => RequestUser::method(),
                    'url' => RequestUser::url(),
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
            $description = $user->name . ' gagal akses halaman user.';
            $properties = [
                'ip' => RequestUser::ip(),
                'user_agent' => RequestUser::userAgent(),
                'method' => RequestUser::method(),
                'url' => RequestUser::url()
            ];

            activity($subject)
                ->by($user)
                ->withProperties($properties)
                ->log($description);
            return redirect('/dashboard')->with([
                'error' => $description,
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        try {
            if (auth()->user()->hasPermissionTo('create-user')) {
                $pengguna = User::create([
                    'email' => $request->email,
                    'name' => $request->name,
                    'kode_divisi' => $request->kode_divisi,
                    'nip' => $request->nip,
                    'no_hp' => $request->no_hp,
                    'address' => $request->address,
                    'password' => bcrypt($request->nip . '@' . $request->no_hp),
                    'remember_token' => Str::random(20),
                ]);
                $pengguna->assignRole($request->role);
                $user = User::find(Auth::id());
                $subject = 'store';
                $description = $user->name . ' berhasil menambah pengguna.';
                $properties = [
                    'ip' => RequestUser::ip(),
                    'user_agent' => RequestUser::userAgent(),
                    'method' => RequestUser::method(),
                    'url' => RequestUser::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->performedOn($pengguna)
                    ->withProperties($properties)
                    ->log($description);
                return redirect()->back()->with([
                    'success' => 'Berhasil menambah pengguna.',
                ]);
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak bisa akses membuat pengguna baru.';
                $properties = [
                    'ip' => RequestUser::ip(),
                    'user_agent' => RequestUser::userAgent(),
                    'method' => RequestUser::method(),
                    'url' => RequestUser::url(),
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
            $description = $user->name . ' gagal menambah pengguna.';
            $properties = [
                'ip' => RequestUser::ip(),
                'user_agent' => RequestUser::userAgent(),
                'method' => RequestUser::method(),
                'url' => RequestUser::url()
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
            if (auth()->user()->hasPermissionTo('update-user')) {
                $pengguna = User::find($id);
                $pengguna->update([
                    'name' => $request->name,
                    'kode_divisi' => $request->kode_divisi,
                    'nip' => $request->nip,
                    'no_hp' => $request->no_hp,
                    'address' => $request->address,
                ]);
                $pengguna->assignRole($request->role);
                $user = User::find(Auth::id());
                $subject = 'update';
                $description = $user->name . ' berhasil update pengguna.';
                $properties = [
                    'ip' => RequestUser::ip(),
                    'user_agent' => RequestUser::userAgent(),
                    'method' => RequestUser::method(),
                    'url' => RequestUser::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->performedOn($pengguna)
                    ->withProperties($properties)
                    ->log($description);
                return redirect()->back()->with([
                    'success' => $description,
                ]);
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak bisa akses mengubah data pengguna.';
                $properties = [
                    'ip' => RequestUser::ip(),
                    'user_agent' => RequestUser::userAgent(),
                    'method' => RequestUser::method(),
                    'url' => RequestUser::url(),
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
            $description = $user->name . ' gagal update pengguna.';
            $properties = [
                'ip' => RequestUser::ip(),
                'user_agent' => RequestUser::userAgent(),
                'method' => RequestUser::method(),
                'url' => RequestUser::url()
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            if (auth()->user()->hasPermissionTo('delete-user')) {
                $pengguna = User::find($id);
                $pengguna->delete();
                $user = User::find(Auth::id());
                $subject = 'delete';
                $description = $user->name . ' berhasil hapus pengguna.';
                $properties = [
                    'ip' => RequestUser::ip(),
                    'user_agent' => RequestUser::userAgent(),
                    'method' => RequestUser::method(),
                    'url' => RequestUser::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->performedOn($pengguna)
                    ->withProperties($properties)
                    ->log($description);
                return redirect()->back()->with([
                    'success' => $description,
                ]);
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak bisa akses menghapus data pengguna.';
                $properties = [
                    'ip' => RequestUser::ip(),
                    'user_agent' => RequestUser::userAgent(),
                    'method' => RequestUser::method(),
                    'url' => RequestUser::url(),
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
            $description = $user->name . ' gagal hapus pengguna.';
            $properties = [
                'ip' => RequestUser::ip(),
                'user_agent' => RequestUser::userAgent(),
                'method' => RequestUser::method(),
                'url' => RequestUser::url()
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
}
