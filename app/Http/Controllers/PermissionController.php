<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\BaseController;
use App\Http\Requests\PermissionRequest;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as RequestPermission;

class PermissionController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data_permission = Permission::orderBy('name', 'ASC')->get();
            $user = User::find(Auth::id());
            $subject = 'read';
            $description = $user->name . ' melihat halaman permission.';
            $properties = [
                'ip' => RequestPermission::ip(),
                'user_agent' => RequestPermission::userAgent(),
                'method' => RequestPermission::method(),
                'url' => RequestPermission::url(),
            ];

            activity($subject)
                ->by($user)
                ->withProperties($properties)
                ->log($description);
            return view('pages.data-master.permission.view', compact('data_permission'));
        } catch (\Throwable $th) {
            $user = User::find(Auth::id());
            $subject = 'error';
            $description = $user->name . ' gagal akses halaman permission.';
            $properties = [
                'ip' => RequestPermission::ip(),
                'user_agent' => RequestPermission::userAgent(),
                'method' => RequestPermission::method(),
                'url' => RequestPermission::url()
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
    public function store(PermissionRequest $request)
    {
        try {
            $data_permission = Permission::create([
                'name' => $request->name,
                'guard_name' => 'web'
            ]);
            $user = User::find(Auth::id());
            $subject = 'store';
            $description = $user->name . ' berhasil menambah permission ' . $data_permission->name;
            $properties = [
                'ip' => RequestPermission::ip(),
                'user_agent' => RequestPermission::userAgent(),
                'method' => RequestPermission::method(),
                'url' => RequestPermission::url(),
            ];

            activity($subject)
                ->by($user)
                ->performedOn($data_permission)
                ->withProperties($properties)
                ->log($description);
            return redirect()->back()->with([
                'succcess' => $user->name . ' berhasil menambah permission ' . $data_permission->name
            ]);
        } catch (\Throwable $th) {
            $user = User::find(Auth::id());
            $subject = 'error';
            $description = $user->name . ' gagal menambah permission.';
            $properties = [
                'ip' => RequestPermission::ip(),
                'user_agent' => RequestPermission::userAgent(),
                'method' => RequestPermission::method(),
                'url' => RequestPermission::url()
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $permission = Permission::find($id);
            $permission->update([
                'name' => $request->name
            ]);
            $user = User::find(Auth::id());
            $subject = 'update';
            $description = $user->name . ' berhasil mengubah permission ' . $permission->name;
            $properties = [
                'ip' => RequestPermission::ip(),
                'user_agent' => RequestPermission::userAgent(),
                'method' => RequestPermission::method(),
                'url' => RequestPermission::url(),
            ];

            activity($subject)
                ->by($user)
                ->performedOn($permission)
                ->withProperties($properties)
                ->log($description);
            return redirect()->back()->with([
                'succcess' => $user->name . ' berhasil mengubah permission ' . $permission->name
            ]);
        } catch (\Throwable $th) {
            $user = User::find(Auth::id());
            $subject = 'error';
            $description = $user->name . ' gagal mengubah permission.';
            $properties = [
                'ip' => RequestPermission::ip(),
                'user_agent' => RequestPermission::userAgent(),
                'method' => RequestPermission::method(),
                'url' => RequestPermission::url()
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
            $permission = Permission::find($id);
            $permission->delete();
            $user = User::find(Auth::id());
            $subject = 'delete';
            $description = $user->name . ' berhasil menghapus permission ' . $permission->name;
            $properties = [
                'ip' => RequestPermission::ip(),
                'user_agent' => RequestPermission::userAgent(),
                'method' => RequestPermission::method(),
                'url' => RequestPermission::url(),
            ];

            activity($subject)
                ->by($user)
                ->performedOn($permission)
                ->withProperties($properties)
                ->log($description);
            return redirect()->back()->with([
                'succcess' => $user->name . ' berhasil menghapus permission ' . $permission->name
            ]);
        } catch (\Throwable $th) {
            $user = User::find(Auth::id());
            $subject = 'error';
            $description = $user->name . ' gagal menghapus permission.';
            $properties = [
                'ip' => RequestPermission::ip(),
                'user_agent' => RequestPermission::userAgent(),
                'method' => RequestPermission::method(),
                'url' => RequestPermission::url()
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
