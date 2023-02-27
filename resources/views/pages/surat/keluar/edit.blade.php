{{-- @extends('layout.master')

@section('content')
    <div id="kt_content_container" class="container-xxl">
        <div class="card card-flush py-4">
            <!--begin::Card body-->
            <div class="card-body">
                <form>
                    <div class="row mb-5">
                        <div class="col">
                            <label for="" class="form-label required ">Tanggal</label>
                            <input type="date" class="form-control" placeholder="">
                        </div>
                        <div class="col">
                            <label for="" class="form-label required">Kepada</label>
                            <input type="text" class="form-control" placeholder="">
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="col">
                            <label for="" class="form-label required ">Nomor Surat</label>
                            <input type="text" class="form-control" placeholder="">
                        </div>
                        <div class="col">
                            <label for="" class="form-label required">Sifat Surat</label>
                            <select class="form-select" name="" data-control="select2">
                                <option disabled selected>--Pilih Sifat Surat--</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="col d-flex ">
                            <div class="col me-2">
                                <label for="" class="form-label required">Jenis Surat</label>
                                <select class="form-select" name="" data-control="select2">
                                    <option disabled selected>--Pilih Jenis Surat--</option>
                                </select>
                            </div>
                            <a href="#" class="btn btn-icon btn-info align-self-end" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_add_jenis">
                                <span class="svg-icon svg-icon-1">
                                    <i data-feather="plus"></i>
                                </span>
                            </a>
                        </div>
                        <div class="col">
                            <label for="" class="form-label">Lampiran</label>
                            <select class="form-select" name="" data-control="select2">
                                <option disabled selected>--Pilih Lampiran--</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="col">
                            <label for="" class="form-label required ">Perihal</label>
                            <input type="text" class="form-control" placeholder="">
                        </div>
                        <div class="col">
                            <label for="" class="form-label">Tembuasan</label>
                            <input type="text" class="form-control " placeholder="">
                        </div>
                    </div>

                    <div class="row mb-7">
                        <div class="col">
                            <label for="" class="form-label required ">Isi Surat</label>
                            <textarea id="kt_docs_tinymce_basic" name="kt_docs_tinymce_basic" class="tox-target">
                            </textarea>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <!--begin::Button-->
                        <button type="reset" class="btn btn-light me-3">Cancel</button>
                        <!--end::Button-->
                        <!--begin::Button-->
                        <button type="submit" class="btn btn-primary">
                            Save
                        </button>
                        <!--end::Button-->
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
    <script src="{{ asset('assets/plugins/custom/tinymce/tinymce.bundle.js') }}"></script>
    <script>
        var options = {
            selector: "#kt_docs_tinymce_basic"
        };

        if (KTApp.isDarkMode()) {
            options["skin"] = "oxide-dark";
            options["content_css"] = "dark";
        }

        tinymce.init(options);
    </script>
@endsection --}}

@extends('layout.master')

@section('content')
    <div id="kt_content_container" class="container-xxl">
        @include('layout.alert')
        <div class="card card-flush py-4">
            <!--begin::Card body-->
            <div class="card-body">
                <form action="{{route('suratkeluar.update', $suratKeluar->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row mb-5">
                        <div class="col">
                            <label for="" class="form-label required">Kepada</label>
                            <select name="nama_penerima" id="nama_penerima" class="form-control" data-control="select2"
                                required>
                                @foreach ($data_komponen as $komponen)
                                    <option value="{{ $komponen->name }}"
                                        {{ $suratKeluar->nama_pengirim == $komponen->name ? 'selected' : '' }}>
                                        {{ $komponen->kode_komponen }} -
                                        {{ $komponen->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col">
                            <label for="" class="form-label required">Tanggal Surat</label>
                            <input type="date" class="form-control" value="{{ $suratKeluar->tanggal_surat }}"
                                name="tanggal_surat" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col">
                            <label for="" class="form-label required ">Nomor Surat</label>
                            <input type="text" class="form-control" value="{{ $suratKeluar->nomor_surat }}"
                                name="nomor_surat" required>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col">
                            <label for="" class="form-label required">Isi Singkat</label>
                            <input type="text" class="form-control" value="{{ $suratKeluar->isi_ringkas }}"
                                name="isi_ringkas" required>
                        </div>
                    </div>
                    <div class="row mb-5">
                        {{-- <div class="col">
                            <label for="" class="form-label required ">No. Indeks</label>
                            <select name="indeks_berkas" id="indeks_berkas" class="form-control" data-control="select2"
                                required>
                                @foreach ($data_kode as $kode)
                                    <option value="{{ $kode->kode_klasifikasi }}"
                                        {{ $suratKeluar->indeks_berkas == $kode->kode_klasifikasi ? 'selected' : '' }}>
                                        [{{ $kode->kode_klasifikasi }}]
                                        {{ $kode->name }}</option>
                                @endforeach
                            </select>
                        </div> --}}
                        <div class="col">
                            <label for="" class="form-label required ">Kode Klasifikasi</label>
                            <select name="kd_klasifikasi" id="kd_klasifikasi" class="form-control" data-control="select2"
                                required>
                                @foreach ($data_kode as $kode)
                                    <option value="{{ $kode->kode_klasifikasi }}"
                                        {{ $suratKeluar->kd_klasifikasi == $kode->kode_klasifikasi ? 'selected' : '' }}>
                                        [{{ $kode->kode_klasifikasi }}]
                                        {{ $kode->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- <div class="col">
                            <label for="" class="form-label">No. Urut</label> <small>(otomatis oleh sistem)</small>
                            <input type="text" class="form-control" value="{{ $suratKeluar->no_agenda }}"
                                name="no_agenda" readonly>
                        </div> --}}

                    </div>

                    <div class="row mb-5">

                        <div class="col">
                            <label for="" class="form-label required">Bagian</label>
                            <select name="dikirim_oleh" id="dikirim_oleh" class="form-control" data-control="select2"
                                required>
                                @foreach ($data_divisi as $divisi)
                                    <option value="{{ $divisi->name }}"
                                        {{ $suratKeluar->dikirim_oleh == $divisi->name ? 'selected' : '' }}>
                                        {{ $divisi->kode }} -
                                        {{ $divisi->name }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="col">
                            <label for="" class="form-label ">Tanggal Dikirim</label>
                            <input type="date" class="form-control" value="{{ $suratKeluar->tanggal_dikirim }}"
                                name="tanggal_dikirim">
                        </div>
                        {{-- <div class="col">
                            <label for="" class="form-label required">Dikirim oleh</label>
                            <input type="text" class="form-control" placeholder="" name="dikirim_oleh"
                                value="{{ $suratKeluar->dikirim_oleh ?? '' }}">
                        </div> --}}
                    </div>

                    <div class="row mb-5">
                        <div class="col">
                            <label for="" class="form-label ">Status</label>
                            <select name="status" id="status" class="form-control" data-control="select2">
                                <option value="SUDAH DIKIRIM" {{($suratKeluar->status == 'SUDAH DIKIRIM') ? 'selected' : ''}} >SUDAH DIKIRIM</option>
                                @can('approve-surat-keluar')
                                <option value="DITERIMA" {{($suratKeluar->status == 'DITERIMA') ? 'selected' : ''}} >SUDAH DIKIRIM</option>
                                @endcan
                                <option value="TOLAK" {{($suratKeluar->status == 'TOLAK') ? 'selected' : ''}} >TOLAK</option>
                                <option value="REVISI" {{($suratKeluar->status == 'REVISI') ? 'selected' : ''}} >REVISI</option>
                                <option value="DRAFT" {{($suratKeluar->status == 'DRAFT') ? 'selected' : ''}} >DRAFT</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="col">
                            <label for="" class="form-label">Catatan</label>
                            <input type="text" class="form-control" name="keterangan"
                                value="{{ $suratKeluar->keterangan }}">
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

    {{-- <div class="modal fade" tabindex="-1" id="kt_modal_add_jenis">
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
    </div> --}}
@endsection


@section('add-js')
@endsection