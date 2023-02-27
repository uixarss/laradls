<?php

namespace App\Http\Controllers;

use App\Helpers\WordTemplate;
use App\Http\Requests\StoreTemplateSuratRequest;
use App\Models\TemplateSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as RequestTemplateSurat;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\BaseController;
use App\Models\SuratKeluar;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use SebastianBergmann\Template\Template;

class TemplateSuratController extends BaseController
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
                $data_template = TemplateSurat::orderBy('kode', 'ASC')->get();
                $user = User::find(Auth::id());
                $subject = 'read';
                $description = $user->name . ' melihat halaman template.';
                $properties = [
                    'ip' => RequestTemplateSurat::ip(),
                    'user_agent' => RequestTemplateSurat::userAgent(),
                    'method' => RequestTemplateSurat::method(),
                    'url' => RequestTemplateSurat::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->withProperties($properties)
                    ->log($description);
                return view('pages.data-master.template', compact('data_template'));
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak bisa akses halaman lokasi template.';
                $properties = [
                    'ip' => RequestTemplateSurat::ip(),
                    'user_agent' => RequestTemplateSurat::userAgent(),
                    'method' => RequestTemplateSurat::method(),
                    'url' => RequestTemplateSurat::url(),
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
            $description = $user->name . ' gagal akses halaman template.';
            $properties = [
                'ip' => RequestTemplateSurat::ip(),
                'user_agent' => RequestTemplateSurat::userAgent(),
                'method' => RequestTemplateSurat::method(),
                'url' => RequestTemplateSurat::url()
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
    public function store(StoreTemplateSuratRequest $request)
    {
        try {
            if (auth()->user()->hasPermissionTo('create-template')) {
                $uuid = Str::uuid();
                $file = $request->file('file_template');
                $filename = $file->getClientOriginalName();
                $fileextension = $file->getClientOriginalExtension();
                if ($fileextension == 'rtf') {
                    $file->move('template/' . $uuid . '/', $filename);

                    $document = TemplateSurat::create([
                        'uuid' => $uuid,
                        'kode' => $request->kode,
                        'name' => $request->name,
                        'location' => 'template/' . $uuid . '/' . $filename,
                        'created_by' => Auth::id()
                    ]);
                    $user = User::find(Auth::id());
                    $subject = 'store';
                    $description = $user->name . ' menambah template surat baru.';
                    $properties = [
                        'ip' => RequestTemplateSurat::ip(),
                        'user_agent' => RequestTemplateSurat::userAgent(),
                        'method' => RequestTemplateSurat::method(),
                        'url' => RequestTemplateSurat::url(),
                    ];

                    activity($subject)
                        ->by($user)
                        ->performedOn($document)
                        ->withProperties($properties)
                        ->log($description);
                    return redirect()->back()->with([
                        'success' => $description,
                    ]);
                } else {
                    $user = User::find(Auth::id());
                    $subject = 'failed';
                    $description = $user->name . ' gagal membuat template surat baru.';
                    $properties = [
                        'ip' => RequestTemplateSurat::ip(),
                        'user_agent' => RequestTemplateSurat::userAgent(),
                        'method' => RequestTemplateSurat::method(),
                        'url' => RequestTemplateSurat::url()
                    ];

                    activity($subject)
                        ->by($user)
                        ->withProperties($properties)
                        ->log($description);
                    return redirect()->back()->with([
                        'error' => $user->name . ' gagal upload template surat baru. File wajib format RTF.',
                    ]);
                }
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak bisa akses halaman template surat.';
                $properties = [
                    'ip' => RequestTemplateSurat::ip(),
                    'user_agent' => RequestTemplateSurat::userAgent(),
                    'method' => RequestTemplateSurat::method(),
                    'url' => RequestTemplateSurat::url(),
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
            $description = $user->name . ' gagal akses halaman template surat.';
            $properties = [
                'ip' => RequestTemplateSurat::ip(),
                'user_agent' => RequestTemplateSurat::userAgent(),
                'method' => RequestTemplateSurat::method(),
                'url' => RequestTemplateSurat::url()
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            if (auth()->user()->hasPermissionTo('update-template')) {
                $template = TemplateSurat::find($id);
                $template->update([
                    'kode' => $request->kode,
                    'name' => $request->name,
                    'updated_by' => Auth::id()
                ]);
                $user = User::find(Auth::id());
                $subject = 'update';
                $description = $user->name . ' mengubah kode/nama template surat.';
                $properties = [
                    'ip' => RequestTemplateSurat::ip(),
                    'user_agent' => RequestTemplateSurat::userAgent(),
                    'method' => RequestTemplateSurat::method(),
                    'url' => RequestTemplateSurat::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->performedOn($template)
                    ->withProperties($properties)
                    ->log($description);
                return redirect()->back()->with([
                    'success' => $description,
                ]);
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak bisa akses mengubah template surat.';
                $properties = [
                    'ip' => RequestTemplateSurat::ip(),
                    'user_agent' => RequestTemplateSurat::userAgent(),
                    'method' => RequestTemplateSurat::method(),
                    'url' => RequestTemplateSurat::url(),
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
            $description = $user->name . ' gagal akses halaman template surat.';
            $properties = [
                'ip' => RequestTemplateSurat::ip(),
                'user_agent' => RequestTemplateSurat::userAgent(),
                'method' => RequestTemplateSurat::method(),
                'url' => RequestTemplateSurat::url()
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
            if (auth()->user()->hasPermissionTo('delete-template')) {
                $template = TemplateSurat::find($id);
                if (File::exists($template->location)) {
                    File::delete($template->location);
                }
                $template->delete();
                $user = User::find(Auth::id());
                $subject = 'delete';
                $description = $user->name . ' menghapus template surat.';
                $properties = [
                    'ip' => RequestTemplateSurat::ip(),
                    'user_agent' => RequestTemplateSurat::userAgent(),
                    'method' => RequestTemplateSurat::method(),
                    'url' => RequestTemplateSurat::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->performedOn($template)
                    ->withProperties($properties)
                    ->log($description);
                return redirect()->back()->with([
                    'success' => $description,
                ]);
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak bisa akses mengubah template surat.';
                $properties = [
                    'ip' => RequestTemplateSurat::ip(),
                    'user_agent' => RequestTemplateSurat::userAgent(),
                    'method' => RequestTemplateSurat::method(),
                    'url' => RequestTemplateSurat::url(),
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
            $description = $user->name . ' gagal akses halaman template surat.';
            $properties = [
                'ip' => RequestTemplateSurat::ip(),
                'user_agent' => RequestTemplateSurat::userAgent(),
                'method' => RequestTemplateSurat::method(),
                'url' => RequestTemplateSurat::url()
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

    public function download(Request $request, $id)
    {
        try {
            $suratKeluar = SuratKeluar::find($id);
            $template = TemplateSurat::find($request->id_template);
            $file = public_path($template->location);
            $direktur = User::role('direktur utama')->first();


            $array = array(
                '[NOMOR_SURAT]' => $suratKeluar->nomor_surat,
                '[ISI_RINGKAS]' => $suratKeluar->isi_ringkas,
                '[NAMA]' => $suratKeluar->nama_penerima,
                '[TANGGAL]' => Carbon::parse($suratKeluar->tanggal_surat)->format('d F Y'),
                '[DIRECTOR]' => $direktur->name,
            );

            $nama_file = $request->name . '.doc';

            $user = User::find(Auth::id());
            $subject = 'download';
            $description = $user->name . ' download '. $nama_file;
            $properties = [
                'ip' => RequestTemplateSurat::ip(),
                'user_agent' => RequestTemplateSurat::userAgent(),
                'method' => RequestTemplateSurat::method(),
                'url' => RequestTemplateSurat::url(),
            ];

            activity($subject)
                ->by($user)
                ->performedOn($suratKeluar)
                ->withProperties($properties)
                ->log($description);

            return WordTemplate::export($file, $array, $nama_file);
        } catch (\Throwable $th) {
            $user = User::find(Auth::id());
            $subject = 'error';
            $description = $user->name . ' gagal akses halaman template surat.';
            $properties = [
                'ip' => RequestTemplateSurat::ip(),
                'user_agent' => RequestTemplateSurat::userAgent(),
                'method' => RequestTemplateSurat::method(),
                'url' => RequestTemplateSurat::url()
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
