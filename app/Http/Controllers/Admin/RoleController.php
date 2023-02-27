<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\BaseController;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as UserRequest;

class RoleController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            if (auth()->user()->hasPermissionTo('read-role')) {
                $data_role = Role::withCount('users', 'permissions')->orderBy('name', 'ASC')->get();
                $data_permission = Permission::where('guard_name', '=', 'web')->orderBy('name', 'ASC')->get();
                $user = User::find(Auth::id());
                $subject = 'read';
                $description = $user->name . ' melihat halaman role.';
                $properties = [
                    'ip' => UserRequest::ip(),
                    'user_agent' => UserRequest::userAgent(),
                    'method' => UserRequest::method(),
                    'url' => UserRequest::url(),
                    'latitude' => UserRequest::fingerprint()
                ];

                activity($subject)
                    ->by($user)
                    ->withProperties($properties)
                    ->log($description);
                return view('pages.data-master.hak-akses.view', compact([
                    'data_role',
                    'data_permission'
                ]));
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak memiliki akses halaman hak akses.';
                $properties = [
                    'ip' => UserRequest::ip(),
                    'user_agent' => UserRequest::userAgent(),
                    'method' => UserRequest::method(),
                    'url' => UserRequest::url(),
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
            $description = $user->name . ' gagal akses halaman role.';
            $properties = [
                'ip' => UserRequest::ip(),
                'user_agent' => UserRequest::userAgent(),
                'method' => UserRequest::method(),
                'url' => UserRequest::url()
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            if (auth()->user()->hasPermissionTo('create-role')) {
                DB::beginTransaction();
                $role = Role::create([
                    'name' => $request->name
                ]);

                DB::commit();
                $subject = 'read';
                $description = Auth::user()->name . ' berhasil menambah role baru.';
                $properties = [
                    'ip' => UserRequest::ip(),
                    'user_agent' => UserRequest::userAgent(),
                    'method' => UserRequest::method(),
                    'url' => UserRequest::url()
                ];
                $role->givePermissionTo($request->permissions);
                activity($subject)
                    ->by(Auth::user())
                    ->withProperties($properties)
                    ->log($description);
                return redirect()->back()->with([
                    'success' => 'Berhasil menambah role baru.'
                ]);
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak memiliki akses menambah hak akses.';
                $properties = [
                    'ip' => UserRequest::ip(),
                    'user_agent' => UserRequest::userAgent(),
                    'method' => UserRequest::method(),
                    'url' => UserRequest::url(),
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
            DB::rollBack();
            $user = User::find(Auth::id());
            $subject = 'error';
            $description = $user->name . ' gagal menambah role baru.';
            $properties = [
                'ip' => UserRequest::ip(),
                'user_agent' => UserRequest::userAgent(),
                'method' => UserRequest::method(),
                'url' => UserRequest::url()
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            if (auth()->user()->hasPermissionTo('show-role')) {
                $role = Role::withCount('users', 'permissions')->find($id);
                $users = User::role($role->name)->get();
                $data_permission = Permission::where('guard_name', '=', 'web')->orderBy('name', 'ASC')->get();

                return view('pages.data-master.hak-akses.show', compact([
                    'role', 'users', 'data_permission'
                ]));
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak memiliki akses detail hak akses.';
                $properties = [
                    'ip' => UserRequest::ip(),
                    'user_agent' => UserRequest::userAgent(),
                    'method' => UserRequest::method(),
                    'url' => UserRequest::url(),
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
            return redirect('/dashboard')->with([
                'error' => $th->getMessage()
            ]);
        }
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
            if (auth()->user()->hasPermissionTo('update-role')) {
                DB::beginTransaction();
                $role = Role::find($id);
                $role->update([
                    'name' => $request->name
                ]);

                // $permissions = Permission::where('id', $request->permissions)
                // ->select('name')
                // ->get();

                // dd($request->permissions);

                $role->givePermissionTo($request->permissions);

                DB::commit();
                return redirect()->back()->with([
                    'success' => 'Berhasil update nama role.'
                ]);
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak memiliki akses mengubah hak akses.';
                $properties = [
                    'ip' => UserRequest::ip(),
                    'user_agent' => UserRequest::userAgent(),
                    'method' => UserRequest::method(),
                    'url' => UserRequest::url(),
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
            DB::rollBack();
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
            if (auth()->user()->hasPermissionTo('delete-role')) {
                DB::beginTransaction();
                $role = Role::find($id);
                $role->delete();
                DB::commit();
                return redirect()->back()->with([
                    'success' => 'Berhasil hapus role.'
                ]);
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak memiliki akses mengubah hak akses.';
                $properties = [
                    'ip' => UserRequest::ip(),
                    'user_agent' => UserRequest::userAgent(),
                    'method' => UserRequest::method(),
                    'url' => UserRequest::url(),
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
            DB::rollBack();
            return redirect()->back()->with([
                'error' => $th->getMessage()
            ]);
        }
    }
}
