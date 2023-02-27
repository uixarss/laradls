@extends('layout.master')

@section('toolbar', 'toolbar-fixed')

@section('toolbars')
    <div class="toolbar" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <!--begin::Page title-->
            <div class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <!--begin::Title-->
                <h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Edit Surat Masuk
                    [{{ $suratMasuk->uuid }}]</h1>
                <!--end::Title-->
            </div>
            <!--end::Page title-->

            <!--begin::Actions-->
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <!--begin::success button-->
                <a href="{{ route('suratmasuk.show', $suratMasuk->uuid) }}" class="btn btn-sm btn-success">Detail</a>
                <!--end::success button-->
                <!--begin::Secondary button-->
                <a href="{{ url('suratmasuk') }}" class="btn btn-sm btn-secondary">Batal</a>
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
        <div class="card card-flush py-4">
            <!--begin::Card body-->
            <div class="card-body">
                <form>
                    <div class="row mb-5">
                        <div class="col">
                            <label for="" class="form-label required">Dari</label>
                            <select name="nama_pengirim" id="nama_pengirim" class="form-control" data-control="select2"
                                required>
                                @foreach ($data_komponen as $komponen)
                                    <option value="{{ $komponen->name }}"
                                        {{ $suratMasuk->nama_pengirim == $komponen->name ? 'selected' : '' }}>
                                        {{ $komponen->kode_komponen }} -
                                        {{ $komponen->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col">
                            <label for="" class="form-label required">Tanggal Surat</label>
                            <input type="date" class="form-control" value="{{ $suratMasuk->tanggal_surat }}"
                                name="tanggal_surat" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col">
                            <label for="" class="form-label required ">Nomor Surat</label>
                            <input type="text" class="form-control" value="{{ $suratMasuk->nomor_surat }}"
                                name="nomor_surat" required>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col">
                            <label for="" class="form-label required">Isi Singkat</label>
                            <input type="text" class="form-control" value="{{ $suratMasuk->isi_ringkas }}"
                                name="isi_ringkas" required>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col">
                            <label for="" class="form-label required ">No. Indeks</label>
                            <select name="indeks_berkas" id="indeks_berkas" class="form-control" data-control="select2"
                                required>
                                @foreach ($data_kode as $kode)
                                    <option value="{{ $kode->kode_klasifikasi }}"
                                        {{ $suratMasuk->indeks_berkas == $kode->kode_klasifikasi ? 'selected' : '' }}>
                                        [{{ $kode->kode_klasifikasi }}]
                                        {{ $kode->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label for="" class="form-label required ">Kode Klasifikasi</label>
                            <select name="kd_klasifikasi" id="kd_klasifikasi" class="form-control" data-control="select2"
                                required>
                                @foreach ($data_kode as $kode)
                                    <option value="{{ $kode->kode_klasifikasi }}"
                                        {{ $suratMasuk->kd_klasifikasi == $kode->kode_klasifikasi ? 'selected' : '' }}>
                                        [{{ $kode->kode_klasifikasi }}]
                                        {{ $kode->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label for="" class="form-label">No. Urut</label> <small>(otomatis oleh sistem)</small>
                            <input type="text" class="form-control" value="{{ $suratMasuk->no_agenda }}"
                                name="no_agenda" readonly>
                        </div>

                    </div>

                    <div class="row mb-5">

                        <div class="col">
                            <label for="" class="form-label required">Pengolah</label>
                            <select name="diterima_oleh" id="diterima_oleh" class="form-control" data-control="select2"
                                required>
                                @foreach ($data_divisi as $divisi)
                                    <option value="{{ $divisi->name }}"
                                        {{ $suratMasuk->diterima_oleh == $divisi->name ? 'selected' : '' }}>
                                        {{ $divisi->kode }} -
                                        {{ $divisi->name }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="col">
                            <label for="" class="form-label required">Tanggal Diterima</label>
                            <input type="date" class="form-control" value="{{ $suratMasuk->tanggal_diterima }}"
                                name="tanggal_diterima" required>
                        </div>
                        {{-- <div class="col">
                            <label for="" class="form-label required">Tanda terima</label>
                            <input type="text" class="form-control" placeholder="" name="diterima_oleh"
                                value="{{ auth()->user()->name }}" readonly>
                        </div> --}}
                    </div>

                    <div class="row mb-5">
                        <div class="col">
                            <label for="" class="form-label required ">Scan Surat</label>
                            <input type="file" class="form-control" placeholder="" name="file_lampiran" required>
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="col">
                            <label for="" class="form-label">Catatan</label>
                            <input type="text" class="form-control" name="keterangan"
                                value="{{ $suratMasuk->keterangan }}">
                        </div>
                    </div>

                    <div class="mt-5">
                        <div class="d-flex left-content-end">
                            <label for="" class="form-label required"><small>Wajib diisi</small></label>

                        </div>
                        <div class="d-flex justify-content-end">
                            <!--begin::Button-->
                            <button type="reset" class="btn btn-light me-3">Cancel</button>
                            <!--end::Button-->
                            <!--begin::Button-->
                            <button type="submit" class="btn btn-primary">
                                Update
                            </button>
                            <!--end::Button-->
                        </div>
                    </div>

                </form>
            </div>
            <!--end::Card body-->
        </div>


    </div>

    <div class="modal fade" tabindex="-1" id="kt_modal_add_jenis">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header p-4">
                    <h5 class="modal-title">Tambah Jenis Surat</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <span class="svg-icon svg-icon-2x text-muted">
                            <i data-feather="x"></i>
                        </span>
                    </div>
                    <!--end::Close-->
                </div>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="modal-body p-4">

                        <div class="mb-3">
                            <label for="" class="form-label required ">Kode</label>
                            <input type="text" class="form-control" name="" placeholder="" required>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label required ">Nama</label>
                            <input type="text" class="form-control" name="" placeholder="" required>
                        </div>


                    </div>

                    <div class="modal-footer p-4">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('add-js')
@endsection
