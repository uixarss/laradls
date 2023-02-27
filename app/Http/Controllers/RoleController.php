<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\BaseController;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
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
            if (auth()->user()->hasPermissionTo('read-klasifikasi')) {
            $data_role = Role::withCount('users')->orderBy('name', 'ASC')->get();
            $user = User::find(Auth::id());
            $subject = 'read';
            $description = $user->name . ' melihat halaman hak akses.';
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
                return view('pages.data-master.hak-akses.view', compact(['data_role']));
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak memiliki akses halaman klasifikasi.';
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
            $description = $user->name . ' gagal akses halaman hak akses.';
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
