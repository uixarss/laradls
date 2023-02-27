@extends('layout.master')

@section('toolbar', 'toolbar-fixed')

@section('toolbars')
    <div class="toolbar" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <!--begin::Page title-->
            <div class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <!--begin::Title-->
                <h1 class="d-flex text-dark fw-bolder fs-1 align-items-center my-1">Detail Surat Masuk</h1>
                <!--end::Title-->
            </div>
            <!--end::Page title-->

            <!--begin::Actions-->
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <!--begin::Success button-->
                <a href="{{ route('download.suratmasuk', $suratMasuk->id) }}" class="btn btn-icon btn-sm btn-success">
                    <span class="svg-icon svg-icon-2">
                        <i data-feather="download"></i>
                    </span>
                </a>
                <!--end::Success button-->
                <!--begin::Warning button-->
                <a href="#" class="btn btn-icon btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#UploadNaskah">
                    <span class="svg-icon svg-icon-2">
                        <i data-feather="upload"></i>
                    </span>
                </a>
                <!--end::Warning button-->
                <!--begin::Warning button-->
                <a href="#" class="btn btn-icon btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#AddDisposisi">
                    <span class="svg-icon svg-icon-2">
                        <i data-feather="send"></i>
                    </span>
                </a>
                <!--end::Warning button-->
                <!--begin::Warning button-->
                <a href="{{ route('suratmasuk.edit', $suratMasuk->uuid) }}" class="btn btn-sm btn-warning">Edit</a>
                <!--end::Warning button-->
                <!--begin::Secondary button-->
                <a href="{{ url('suratmasuk') }}" class="btn btn-sm btn-secondary">Kembali</a>
                <!--end::Secondary button-->


            </div>
            <!--end::Actions-->
        </div>
        <!--end::Container-->
    </div>
@endsection

@section('menu')
    <div class="menu-item {{ request()->is('suratmasuk*') ? 'here' : '' }} me-lg-1">
        <span class="menu-link py-3">
            <a href="{{ url('suratmasuk') }}" class="menu-title">Masuk</a>
        </span>
    </div>
    <div class="menu-item {{ request()->is('suratkeluar*') ? 'here' : '' }} me-lg-1">
        <span class="menu-link py-3">
            <a href="{{ url('suratkeluar') }}" class="menu-title">Keluar</a>
        </span>
    </div>
@endsection

@section('content')
    <div id="kt_content_container" class="container-xxl">
        @include('layout.alert')
        <div class="row gy-5 g-xl-8">
            <div class="col-sm-12 col-md-8">
                <div class="card card-flush py-4">
                    {{-- begin:Card header --}}
                    <div class="card-header align-items-center pt-5 pb-0 gap-2 gap-md-5">
                        <div class="card-title">
                            <div class="d-flex align-items-center position-relative my-1">
                                <h1 class="d-flex text-dark fw-bolder fs-3 align-items-left my-1">Kartu Surat Masuk</h1>
                            </div>
                        </div>

                    </div>
                    {{-- end: Card header --}}
                    <!--begin::Card body-->
                    <div class="card-body">
                        {{-- begin: Kartu --}}
                        <div class="table-responsive">
                            <table class="table table-rounded table-flush fs-6 g-3">
                                <tbody class="border border-gray-300">
                                    <tr>
                                        <td>Tanggal Surat
                                            <p><strong>
                                                    {{ \Carbon\Carbon::parse($suratMasuk->tanggal_surat)->format('d M Y') }}</strong>
                                            </p>
                                        </td>
                                        <td>Nomor Surat
                                            <p><strong>{{ $suratMasuk->nomor_surat }}</strong></p>
                                        </td>
                                        <td>Lampiran
                                            <p>-</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">Dari
                                            <p><strong>{{ $suratMasuk->nama_pengirim }}</strong></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">Isi Ringkasan
                                            <p><strong>{{ $suratMasuk->isi_ringkas }}</strong></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Indeks
                                            <p>
                                                <strong>{{ $suratMasuk->indeks->kode_klasifikasi }} -
                                                    {{ $suratMasuk->indeks->name }}</strong>
                                            </p>
                                        </td>
                                        <td>Kode
                                            <p><strong>{{ $suratMasuk->kode->kode_klasifikasi }} -
                                                    {{ $suratMasuk->kode->name }}</strong>
                                            </p>
                                        </td>
                                        <td>Nomor Urut
                                            <p><strong>{{ $suratMasuk->no_agenda }}</strong></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Pengolah
                                            <p>
                                                <strong>{{ $suratMasuk->diterima_oleh }}</strong>
                                            </p>
                                        </td>
                                        <td>Tanggal Diterima
                                            <p>
                                                <strong>{{ \Carbon\Carbon::parse($suratMasuk->tanggal_diterima)->format('d M Y') }}</strong>
                                            </p>
                                        </td>
                                        <td>Tanda Terima
                                            <p>-</p>
                                        </td>
                                    </tr>
                                    <tr class="border-bottom border-gray-300">
                                        <td colspan="3">Catatan
                                            <p>
                                                <strong>{{ $suratMasuk->keterangan }}</strong>
                                            </p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        {{-- end: Kartu --}}
                    </div>
                    <!--end::Card body-->
                </div>
                <br>
                <div class="card card-flush py-4">
                    {{-- begin:Card header --}}
                    <div class="card-header align-items-center pt-5 pb-0 gap-2 gap-md-5">
                        <div class="card-title">
                            <div class="d-flex align-items-center position-relative my-1">
                                <h1 class="d-flex text-dark fw-bolder fs-3 align-items-left my-1">Lampiran</h1>
                            </div>
                        </div>
                        <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                            <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#UploadLampiran">
                                <span class="svg-icon svg-icon-1">
                                    <i data-feather="plus"></i>
                                </span>
                                Upload Lampiran
                            </a>
                        </div>
                    </div>
                    {{-- end: Card header --}}
                    <!--begin::Card body-->
                    <div class="card-body">
                        {{-- begin: Kartu --}}
                        <div class="table-responsive">
                            <table class="table align-middle border rounded table-row-line fs-6 g-5">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th class="min-w text-end">
                                            <span class="svg-icon svg-icon-1">
                                                <i data-feather="more-vertical"></i>
                                            </span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($suratMasuk->lampirans as $lampiran)
                                        <tr>
                                            <td>
                                                {{ $lampiran->name }} - {{ $lampiran->id }}
                                            </td>
                                            <td class="text-end">
                                                <a href="{{ route('download.lampiran', $lampiran->id) }}"
                                                    class="btn btn-icon btn-sm btn-success">
                                                    <span class="svg-icon svg-icon-5 m-0">
                                                        <i data-feather="download"></i>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                </a>
                                                <a href="{{ route('delete.lampiran', $lampiran->id) }}"
                                                    class="btn btn-icon btn-sm btn-danger">
                                                    <span class="svg-icon svg-icon-5 m-0">
                                                        <i data-feather="trash"></i>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                </a>


                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{-- end: Kartu --}}
                    </div>
                    <!--end::Card body-->
                </div>


            </div>

            <div class="col-sm-12 col-md-4">
                <div class="row gy-2">
                    <div class="card card-flush p-5">
                        <!--begin::Card body-->
                        <div class="card-body p-0">
                            <div class="d-flex flex-stack">
                                <span class="badge badge-light-info">Disposisi</span>
                                <p class="fs-7 m-0">19 Maret 2022, 3:00 PM</p>
                            </div>
                            <div class="d-flex flex-stack mt-5">
                                <p class="card-text m-0">Surat disposisi kepada <b>Sekda</b></p>
                                <p class="fs-7 m-0">Sumanto (Divisi)</p>
                            </div>
                            <input type="text" class="form-control form-control-solid mt-5 fs-7 text-gray-800"
                                placeholder="Segera direspon" readonly />
                            <div class="text-end mt-5">
                                <a href="#" class="btn btn-sm btn-outline btn-outline-default">Lihat</a>
                                <a href="#" class="btn btn-sm btn-bg-primary text-white">Terima</a>
                            </div>
                        </div>
                        <!--end::Card body-->
                    </div>
                    <div class="card card-flush p-5">
                        <!--begin::Card body-->
                        <div class="card-body p-0">
                            <div class="d-flex flex-stack">
                                <span class="badge badge-light-primary">Masuk</span>
                                <p class="fs-7 m-0">19 Maret 2022, 2:09 PM</p>
                            </div>
                            <div class="d-flex flex-stack mt-5">
                                <p class="card-text m-0">Surat diterima oleh <b>Sekda</b></p>
                                <p class="fs-7 m-0">Sumanto (Divisi)</p>
                            </div>

                        </div>
                        <!--end::Card body-->
                    </div>
                </div>

            </div>
        </div>
    </div>



    <x-modal id="UploadNaskah">
        <div class="card card-flush py-4">
            <form action="">
                <div class="card-header">
                    <h1 class=" modal-title">Upload Naskah</h1>
                </div>
                <div class="card-body">
                    <label for="">File Naskah</label>
                    <input type="file" class="form-control" required>
                </div>

                <div class="card-footer">
                    <div class="text-end">
                        <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Close</button>
                        <a href="#" class="btn btn-sm btn-primary">Upload</a>
                    </div>
                </div>
            </form>
        </div>

    </x-modal>
    <x-modal id="UploadLampiran">
        <div class="card card-flush py-4">
            <form action="{{ route('suratmasuk.upload.lampiran', $suratMasuk->uuid) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="card-header">
                    <h1 class="modal-title">Upload Lampiran</h1>
                    <input type="hidden" name="uuid" value="{{ $suratMasuk->uuid }}" hidden>

                </div>
                <div class="card-body">
                    <label for="">Nama Lampiran</label>
                    <input type="text" class="form-control" name="name" required>
                    <label for="">File Lampiran</label> <small>(hanya file pdf)</small>
                    <input type="file" class="form-control" name="file_lampiran" required>
                </div>

                <div class="card-footer">
                    <div class="text-end">
                        <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-sm btn-primary">Upload</button>
                    </div>
                </div>
            </form>
        </div>
    </x-modal>
@endsection


@section('add-js')
@endsection
