<?php

namespace App\Http\Controllers;

use App\Exports\DocumentExport;
use App\Exports\SampleDocumentExport;
use App\Models\Document;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\BaseController;
use App\Http\Requests\DocumentRequest;
use App\Http\Requests\ImportDocumentRequest;
use App\Http\Requests\LokasiDokumenRequest;
use App\Imports\DocumentImport;
use App\Models\Klasifikasi;
use App\Models\Lokasi;
use App\Models\LokasiDocument;
use Illuminate\Support\Facades\Request as RequestDocument;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Activitylog\Models\Activity;

class DocumentController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            if (auth()->user()->hasPermissionTo('read-dokumen')) {
                $data_document = Document::orderBy('published_at', 'desc')->get();
                $user = User::find(Auth::id());
                $subject = 'read';
                $description = $user->name . ' melihat halaman document.';
                $properties = [
                    'ip' => RequestDocument::ip(),
                    'user_agent' => RequestDocument::userAgent(),
                    'method' => RequestDocument::method(),
                    'url' => RequestDocument::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->withProperties($properties)
                    ->log($description);
                return view('pages.arsip.dokumen.view', compact('data_document'));
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak bisa akses halaman dokumen.';
                $properties = [
                    'ip' => RequestDocument::ip(),
                    'user_agent' => RequestDocument::userAgent(),
                    'method' => RequestDocument::method(),
                    'url' => RequestDocument::url(),
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
            $description = $user->name . ' gagal akses halaman dokumen.';
            $properties = [
                'ip' => RequestDocument::ip(),
                'user_agent' => RequestDocument::userAgent(),
                'method' => RequestDocument::method(),
                'url' => RequestDocument::url()
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
        try {
            if (auth()->user()->hasPermissionTo('create-dokumen')) {
                $data_klasifikasi = Klasifikasi::orderBy('kode_klasifikasi', 'ASC')
                    ->select(['id', 'kode_klasifikasi', 'name'])
                    ->get();
                $user = User::find(Auth::id());
                $subject = 'read';
                $description = $user->name . ' melihat halaman membuat dokumen baru.';
                $properties = [
                    'ip' => RequestDocument::ip(),
                    'user_agent' => RequestDocument::userAgent(),
                    'method' => RequestDocument::method(),
                    'url' => RequestDocument::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->withProperties($properties)
                    ->log($description);
                return view('pages.arsip.dokumen.add', compact('data_klasifikasi'));
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak memiliki akses halaman membuat dokumen baru.';
                $properties = [
                    'ip' => RequestDocument::ip(),
                    'user_agent' => RequestDocument::userAgent(),
                    'method' => RequestDocument::method(),
                    'url' => RequestDocument::url(),
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
            $description = $user->name . ' gagal akses halaman membuat dokumen baru.';
            $properties = [
                'ip' => RequestDocument::ip(),
                'user_agent' => RequestDocument::userAgent(),
                'method' => RequestDocument::method(),
                'url' => RequestDocument::url()
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
    public function store(DocumentRequest $request)
    {
        try {
            if (auth()->user()->hasPermissionTo('create-dokumen')) {
                $uuid = Str::uuid();
                $file = $request->file('document_file');
                $filename = $file->getClientOriginalName();
                $fileextension = $file->getClientOriginalExtension();
                if ($fileextension == 'pdf') {
                    $file->move('documents/' . $uuid . '/', $filename);

                    $document = Document::create([
                        'uuid' => $uuid,
                        'kode_klasifikasi' => $request->kode_klasifikasi,
                        'title' => $request->title,
                        'nomor_berkas' => $request->nomor_berkas,
                        'published_at' => $request->published_at,
                        'jumlah' => $request->jumlah,
                        'author' => $request->author,
                        'location_file' => 'documents/' . $uuid . '/' . $filename,
                        'created_by' => Auth::id()
                    ]);
                    $user = User::find(Auth::id());
                    $subject = 'store';
                    $description = $user->name . ' menambah dokumen.';
                    $properties = [
                        'ip' => RequestDocument::ip(),
                        'user_agent' => RequestDocument::userAgent(),
                        'method' => RequestDocument::method(),
                        'url' => RequestDocument::url(),
                    ];

                    activity($subject)
                        ->by($user)
                        ->performedOn($document)
                        ->withProperties($properties)
                        ->log($description);
                    return redirect()->route('arsip.dokumen.show', $document->uuid)->with([
                        'success' => $document->title . ' berhasil ditambahkan.',
                    ]);
                } else {
                    $user = User::find(Auth::id());
                    $subject = 'failed';
                    $description = $user->name . ' gagal membuat dokumen baru.';
                    $properties = [
                        'ip' => RequestDocument::ip(),
                        'user_agent' => RequestDocument::userAgent(),
                        'method' => RequestDocument::method(),
                        'url' => RequestDocument::url()
                    ];

                    activity($subject)
                        ->by($user)
                        ->withProperties($properties)
                        ->log($description);
                    return redirect()->back()->with([
                        'error' => $user->name . ' gagal upload dokumen baru. File wajib format PDF.',
                    ]);
                }
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak memiliki akses halaman membuat dokumen baru.';
                $properties = [
                    'ip' => RequestDocument::ip(),
                    'user_agent' => RequestDocument::userAgent(),
                    'method' => RequestDocument::method(),
                    'url' => RequestDocument::url(),
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
            $description = $user->name . ' gagal membuat dokumen baru.';
            $properties = [
                'ip' => RequestDocument::ip(),
                'user_agent' => RequestDocument::userAgent(),
                'method' => RequestDocument::method(),
                'url' => RequestDocument::url()
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
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        try {
            if (auth()->user()->hasPermissionTo('show-dokumen')) {
                $document = Document::where('uuid', $uuid)->first();
                $data_klasifikasi = Klasifikasi::orderBy('kode_klasifikasi', 'ASC')
                    ->select(['id', 'kode_klasifikasi', 'name'])
                    ->get();
                $data_lokasi = Lokasi::orderBy('kode', 'ASC')->get();
                $data_lokasi_dokumen = LokasiDocument::where('document_id', $document->id)
                    ->orderBy('name', 'DESC')
                    ->get();

                $data_log = Activity::where('subject_type', '=', Document::class)
                    ->where('subject_id', '=', $document->id)
                    ->orderBy('created_at', 'DESC')->get();

                $user = User::find(Auth::id());
                $subject = 'show';
                $description = $user->name . ' akses halaman show document.';
                $properties = [
                    'ip' => RequestDocument::ip(),
                    'user_agent' => RequestDocument::userAgent(),
                    'method' => RequestDocument::method(),
                    'url' => RequestDocument::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->performedOn($document)
                    ->withProperties($properties)
                    ->log($description);

                return view('pages.arsip.dokumen.show', compact(
                    'document',
                    'data_klasifikasi',
                    'data_lokasi',
                    'data_lokasi_dokumen',
                    'data_log'
                ));
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak memiliki akses halaman detail dokumen.';
                $properties = [
                    'ip' => RequestDocument::ip(),
                    'user_agent' => RequestDocument::userAgent(),
                    'method' => RequestDocument::method(),
                    'url' => RequestDocument::url(),
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
            $description = $user->name . ' gagal akses halaman show document.';
            $properties = [
                'ip' => RequestDocument::ip(),
                'user_agent' => RequestDocument::userAgent(),
                'method' => RequestDocument::method(),
                'url' => RequestDocument::url()
            ];

            activity($subject)
                ->by($user)
                ->withProperties($properties)
                ->log($description);
            return redirect('dashboard')->with([
                'error' => $th->getMessage(),
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function edit(Document $document)
    {

        return view('pages.arsip.dokumen.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            if (auth()->user()->hasPermissionTo('update-dokumen')) {
                $document = Document::find($id);
                $document->update([
                    'kode_klasifikasi' => $request->kode_klasifikasi,
                    'title' => $request->title,
                    'nomor_berkas' => $request->nomor_berkas,
                    'published_at' => $request->published_at,
                    'jumlah' => $request->jumlah,
                    'author' => $request->author,
                    'update_by' => Auth::id()
                ]);
                $user = User::find(Auth::id());
                $subject = 'store';
                $description = $user->name . ' menambah dokumen.';
                $properties = [
                    'ip' => RequestDocument::ip(),
                    'user_agent' => RequestDocument::userAgent(),
                    'method' => RequestDocument::method(),
                    'url' => RequestDocument::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->performedOn($document)
                    ->withProperties($properties)
                    ->log($description);
                return redirect()->back()->with([
                    'success' => $document->title . ' berhasil diubah.',
                ]);
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak memiliki akses update dokumen.';
                $properties = [
                    'ip' => RequestDocument::ip(),
                    'user_agent' => RequestDocument::userAgent(),
                    'method' => RequestDocument::method(),
                    'url' => RequestDocument::url(),
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
            $description = $user->name . ' gagal membuat dokumen baru.';
            $properties = [
                'ip' => RequestDocument::ip(),
                'user_agent' => RequestDocument::userAgent(),
                'method' => RequestDocument::method(),
                'url' => RequestDocument::url()
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
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            if (auth()->user()->hasPermissionTo('delete-dokumen')) {
                $document = Document::where('uuid', $id)->first();
                if (File::exists($document->location_file)) {
                    File::delete($document->location_file);
                    $document->delete($document);
                    return redirect()->back()->with([
                        'success' => 'File telah dihapus.',
                    ]);
                } else {
                    $document->delete($document);
                    return redirect()->back()->with([
                        'success' => 'File tidak ditemukan dan telah dihapus.',
                    ]);
                }
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak memiliki akses hapus dokumen.';
                $properties = [
                    'ip' => RequestDocument::ip(),
                    'user_agent' => RequestDocument::userAgent(),
                    'method' => RequestDocument::method(),
                    'url' => RequestDocument::url(),
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
            return redirect()->back()->with([
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function import(ImportDocumentRequest $request)
    {
        try {
            Excel::import(new DocumentImport, $request->document_file);
            $user = User::find(Auth::id());
            $subject = 'import';
            $description = $user->name . ' import document.';
            $properties = [
                'ip' => RequestDocument::ip(),
                'user_agent' => RequestDocument::userAgent(),
                'method' => RequestDocument::method(),
                'url' => RequestDocument::url(),
            ];

            activity($subject)
                ->by($user)
                ->withProperties($properties)
                ->log($description);
            return redirect()->back()->with([
                'success' => 'Berhasil import document.',
            ]);
        } catch (\Throwable $th) {

            $user = User::find(Auth::id());
            $subject = 'error';
            $description = $user->name . ' gagal import document.';
            $properties = [
                'ip' => RequestDocument::ip(),
                'user_agent' => RequestDocument::userAgent(),
                'method' => RequestDocument::method(),
                'url' => RequestDocument::url()
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
            if (auth()->user()->hasPermissionTo('export-dokumen')) {
                $user = User::find(Auth::id());
                $subject = 'export';
                $description = $user->name . ' export document.';
                $properties = [
                    'ip' => RequestDocument::ip(),
                    'user_agent' => RequestDocument::userAgent(),
                    'method' => RequestDocument::method(),
                    'url' => RequestDocument::url(),
                ];

                activity($subject)
                    ->by($user)
                    ->withProperties($properties)
                    ->log($description);
                return Excel::download(new DocumentExport, time() . '_document.xlsx');
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak memiliki akses export seluruh data dokumen.';
                $properties = [
                    'ip' => RequestDocument::ip(),
                    'user_agent' => RequestDocument::userAgent(),
                    'method' => RequestDocument::method(),
                    'url' => RequestDocument::url(),
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
            $description = $user->name . ' gagal download document.';
            $properties = [
                'ip' => RequestDocument::ip(),
                'user_agent' => RequestDocument::userAgent(),
                'method' => RequestDocument::method(),
                'url' => RequestDocument::url()
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

    public function exportSample()
    {
        // Export Sample xlsx
        try {
            $user = User::find(Auth::id());
            $subject = 'export';
            $description = $user->name . ' export sample dokumen.';
            $properties = [
                'ip' => RequestDocument::ip(),
                'user_agent' => RequestDocument::userAgent(),
                'method' => RequestDocument::method(),
                'url' => RequestDocument::url(),
            ];

            activity($subject)
                ->by($user)
                ->withProperties($properties)
                ->log($description);
            return Excel::download(new SampleDocumentExport, time() . '_sample_document.xlsx');
        } catch (\Throwable $th) {
            $user = User::find(Auth::id());
            $subject = 'error';
            $description = $user->name . ' gagal download sample dokumen.';
            $properties = [
                'ip' => RequestDocument::ip(),
                'user_agent' => RequestDocument::userAgent(),
                'method' => RequestDocument::method(),
                'url' => RequestDocument::url()
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

    public function download($uuid)
    {
        try {
            if (auth()->user()->hasPermissionTo('download-dokumen')) {
                $document = Document::where('uuid', $uuid)->first();
                if (File::exists($document->location_file)) {
                    $file = public_path() . '/' . $document->location_file;
                    $headers = array('Content-Type: application/pdf',);
                    $user = User::find(Auth::id());
                    $subject = 'download';
                    $description = $user->name . ' download dokumen.';
                    $properties = [
                        'ip' => RequestDocument::ip(),
                        'user_agent' => RequestDocument::userAgent(),
                        'method' => RequestDocument::method(),
                        'url' => RequestDocument::url(),
                    ];

                    activity($subject)
                        ->by($user)
                        ->performedOn($document)
                        ->withProperties($properties)
                        ->log($description);
                    // return File::download($document->location_file);
                    return Response::download($file, $document->nomor_berkas . '.pdf', $headers);
                } else {
                    return redirect()->back()->with([
                        'error' => 'File tidak ditemukan.',
                    ]);
                }
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak memiliki akses download dokumen.';
                $properties = [
                    'ip' => RequestDocument::ip(),
                    'user_agent' => RequestDocument::userAgent(),
                    'method' => RequestDocument::method(),
                    'url' => RequestDocument::url(),
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
            return redirect()->back()->with([
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function upload(Request $request, $id)
    {
        try {
            if (auth()->user()->hasPermissionTo('upload-dokumen')) {
                $document = Document::find($id);
                $uuid = $document->uuid;
                $file = $request->file('document_file');
                $filename = $file->getClientOriginalName();
                $fileextension = $file->getClientOriginalExtension();
                if (($fileextension == 'pdf')) {
                    $file->move('documents/' . $uuid . '/', $filename);

                    $document->update([
                        'location_file' => 'documents/' . $uuid . '/' . $filename,
                        'updated_by' => Auth::id()
                    ]);
                    $user = User::find(Auth::id());
                    $subject = 'store';
                    $description = $user->name . ' upload naskah dokumen.';
                    $properties = [
                        'ip' => RequestDocument::ip(),
                        'user_agent' => RequestDocument::userAgent(),
                        'method' => RequestDocument::method(),
                        'url' => RequestDocument::url(),
                    ];

                    activity($subject)
                        ->by($user)
                        ->performedOn($document)
                        ->withProperties($properties)
                        ->log($description);
                    return redirect()->back()->with([
                        'success' => $document->title . ' berhasil upload naskah dokumen.',
                    ]);
                } else {
                    $user = User::find(Auth::id());
                    $subject = 'failed';
                    $description = $user->name . ' gagal upload naskah dokumen baru.';
                    $properties = [
                        'ip' => RequestDocument::ip(),
                        'user_agent' => RequestDocument::userAgent(),
                        'method' => RequestDocument::method(),
                        'url' => RequestDocument::url()
                    ];

                    activity($subject)
                        ->by($user)
                        ->withProperties($properties)
                        ->log($description);
                    return redirect()->back()->with([
                        'error' => $user->name . ' gagal upload dokumen baru. File wajib format PDF.',
                    ]);
                }
            } else {
                $user = User::find(Auth::id());
                $subject = 'denied';
                $description = $user->name . ' tidak memiliki akses upload dokumen.';
                $properties = [
                    'ip' => RequestDocument::ip(),
                    'user_agent' => RequestDocument::userAgent(),
                    'method' => RequestDocument::method(),
                    'url' => RequestDocument::url(),
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
            $description = $user->name . ' gagal membuat dokumen baru.';
            $properties = [
                'ip' => RequestDocument::ip(),
                'user_agent' => RequestDocument::userAgent(),
                'method' => RequestDocument::method(),
                'url' => RequestDocument::url()
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


    public function setLokasi(LokasiDokumenRequest $request, $id)
    {
        try {

            $lokasi_document = LokasiDocument::create([
                'lokasi_id' => $request->lokasi_id,
                'document_id' => $id,
                'name' => $request->name,
                'created_by' => Auth::id()
            ]);
            $user = User::find(Auth::id());
            $subject = 'store';
            $description = $user->name . ' menambah lokasi dokumen.';
            $properties = [
                'ip' => RequestDocument::ip(),
                'user_agent' => RequestDocument::userAgent(),
                'method' => RequestDocument::method(),
                'url' => RequestDocument::url(),
            ];

            activity($subject)
                ->by($user)
                ->performedOn($lokasi_document)
                ->withProperties($properties)
                ->log($description);
            return redirect()->back()->with([
                'success' => $user->name . ' menambah lokasi dokumen.',
            ]);
        } catch (\Throwable $th) {
            $user = User::find(Auth::id());
            $subject = 'error';
            $description = $user->name . ' gagal menambah lokasi dokumen.';
            $properties = [
                'ip' => RequestDocument::ip(),
                'user_agent' => RequestDocument::userAgent(),
                'method' => RequestDocument::method(),
                'url' => RequestDocument::url()
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

    public function updateLokasi(Request $request, $id)
    {
        try {
            $lokasi_document = LokasiDocument::find($id);
            $lokasi_document->update([
                'lokasi_id' => $request->lokasi_id,
                'name' => $request->name,
                'updated_by' => Auth::id()
            ]);
            $user = User::find(Auth::id());
            $subject = 'updated';
            $description = $user->name . ' update lokasi dokumen.';
            $properties = [
                'ip' => RequestDocument::ip(),
                'user_agent' => RequestDocument::userAgent(),
                'method' => RequestDocument::method(),
                'url' => RequestDocument::url(),
            ];

            activity($subject)
                ->by($user)
                ->performedOn($lokasi_document)
                ->withProperties($properties)
                ->log($description);
            return redirect()->back()->with([
                'success' => $user->name . ' update lokasi dokumen.',
            ]);
        } catch (\Throwable $th) {
            $user = User::find(Auth::id());
            $subject = 'error';
            $description = $user->name . ' gagal update lokasi dokumen.';
            $properties = [
                'ip' => RequestDocument::ip(),
                'user_agent' => RequestDocument::userAgent(),
                'method' => RequestDocument::method(),
                'url' => RequestDocument::url()
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

    public function deleteLokasi($id)
    {
        try {
            $lokasi_document = LokasiDocument::find($id);
            $lokasi_document->delete();
            $user = User::find(Auth::id());
            $subject = 'updated';
            $description = $user->name . ' hapus lokasi dokumen.';
            $properties = [
                'ip' => RequestDocument::ip(),
                'user_agent' => RequestDocument::userAgent(),
                'method' => RequestDocument::method(),
                'url' => RequestDocument::url(),
            ];

            activity($subject)
                ->by($user)
                ->performedOn($lokasi_document)
                ->withProperties($properties)
                ->log($description);
            return redirect()->back()->with([
                'success' => $user->name . ' hapus lokasi dokumen.',
            ]);
        } catch (\Throwable $th) {
            $user = User::find(Auth::id());
            $subject = 'error';
            $description = $user->name . ' gagal hapus lokasi dokumen.';
            $properties = [
                'ip' => RequestDocument::ip(),
                'user_agent' => RequestDocument::userAgent(),
                'method' => RequestDocument::method(),
                'url' => RequestDocument::url()
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
