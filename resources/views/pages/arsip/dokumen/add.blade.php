@extends('layout.master')

@section('toolbars')
    <div class="toolbar" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <!--begin::Page title-->
            <div class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <!--begin::Title-->
                <h1 class="d-flex text-dark fw-bolder fs-1 align-items-center my-1">Tambah Berkas Arsip</h1>
                <!--end::Title-->
            </div>
            <!--end::Page title-->

            <!--begin::Actions-->
            <div class="d-flex align-items-center gap-2 gap-lg-3">

                <!--begin::Secondary button-->
                <a href="{{ url('arsip/dokumen') }}" class="btn btn-sm btn-secondary">Kembali</a>
                <!--end::Secondary button-->


            </div>
            <!--end::Actions-->
        </div>
        <!--end::Container-->
    </div>
@endsection
@section('content')
    <div id="kt_content_container" class="container-xxl">
        @include('layout.alert')
        <div class="card card-flush py-4">
            {{-- begin:Card header --}}
            {{-- <div class="card-header align-items-center pt-5 pb-0 gap-2 gap-md-5">
                <div class="card-title">
                    <div class="d-flex align-items-center position-relative my-1">
                        <h1 class="d-flex text-dark fw-bolder fs-3 align-items-left my-1">Tambah Berkas Arsip</h1>
                    </div>
                </div>
            </div> --}}
            {{-- end: Card header --}}
            <div class="card-body">
                <form action="{{ route('arsip.dokumen.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-5">
                        <div class="col">
                            <label for="" class="form-label required">Nomor Berkas</label>
                            <input type="text" class="form-control" placeholder="" name="nomor_berkas" required>
                        </div>
                        <div class="col">
                            <label for="" class="form-label required ">Kode Klasifikasi</label>
                            <select name="kode_klasifikasi" id="" class="form-control" data-control="select2"
                                required>
                                <option value=""disabled aria-readonly="true">-- Select --</option>
                                @foreach ($data_klasifikasi as $klasifikasi)
                                    <option value="{{ $klasifikasi->kode_klasifikasi }}">
                                        {{ $klasifikasi->kode_klasifikasi }} | {{ $klasifikasi->name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col">
                            <label for="" class="form-label required">Uraian Perihal Dokumen / Perihal</label>
                            <input type="text" class="form-control" placeholder="Dokumen tentang .... " name="title" required>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col">
                            <label for="" class="form-label required">Tanggal</label>
                            <input type="date" class="form-control" value="{{ date('Y-m-d') }}" name="published_at"
                                required>
                        </div>
                        <div class="col">
                            <label for="" class="form-label required">Jumlah</label>
                            <input type="number" class="form-control" placeholder="1" name="jumlah" required>
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="col">
                            <label for="" class="form-label required">Pengolah</label>
                            <input type="text" class="form-control" value="{{ auth()->user()->name ?? '' }}"
                                name="author" required>
                            {{-- <select name="" id="" class="form-control" data-control="select2" required>
                                <option value="">-- Select --</option>
                            </select> --}}
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="col">
                            <label for="" class="form-label required ">Scan Surat</label>
                            <input type="file" class="form-control" name="document_file" required>
                        </div>
                    </div>

                    <div class="mt-5">
                        <div class="d-flex left-content-end">
                            <label for="" class="form-label required"><small>Wajib diisi</small></label>

                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="reset" class="btn btn-light me-3">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                Save
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
