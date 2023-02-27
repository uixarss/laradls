@extends('layout.master')

@section('content')
    <div id="kt_content_container" class="container-xxl">
        @include('layout.alert')
        <div class="card card-flush py-4">
            <!--begin::Card body-->
            <div class="card-body">
                <form action="{{ route('suratkeluar.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-5">
                        <div class="col">
                            <label for="" class="form-label required ">Kode Klasifikasi</label>
                            <select name="kd_klasifikasi" id="kd_klasifikasi" class="form-control" data-control="select2"
                                required>
                                @foreach ($data_kode as $kode)
                                    <option value="{{ $kode->kode_klasifikasi }}">
                                        [{{ $kode->kode_klasifikasi }}]
                                        {{ $kode->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label for="" class="form-label">No. Urut</label> <small>(otomatis oleh sistem)</small>
                            <input type="text" class="form-control" placeholder="" name="no_agenda"
                                value="{{ ++$nomor_urut ?? 1 }}" readonly>
                        </div>

                    </div>
                    <div class="row mb-5">
                        {{-- <div class="col">
                            <label for="" class="form-label required ">Nomor Surat</label>
                            <input type="text" class="form-control" placeholder="" name="nomor_surat" required>
                        </div> --}}
                        <div class="col">
                            <label for="" class="form-label required">Kepada</label>
                            <select name="nama_penerima" id="nama_penerima" class="form-control" data-control="select2"
                                required>
                                @foreach ($data_komponen as $komponen)
                                    <option value="{{ $komponen->name }}">{{ $komponen->kode_komponen }} -
                                        {{ $komponen->name }}</option>
                                @endforeach
                            </select>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_add_komponen">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2"
                                            rx="1" transform="rotate(-90 11.364 20.364)" fill="black" />
                                        <rect x="4.36396" y="11.364" width="16" height="2" rx="1"
                                            fill="black" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                                Tambah Komponen
                            </button>
                        </div>
                        {{-- <div class="col">
                            <label for="" class="form-label"></label>
                            
                        </div> --}}


                    </div>
                    <div class="row mb-5">
                        <div class="col">
                            <label for="" class="form-label required">Perihal</label>
                            <input type="text" class="form-control" placeholder="" name="isi_ringkas" required>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col">
                            <label for="" class="form-label required">Tanggal Surat</label>
                            <input type="date" class="form-control" placeholder="" name="tanggal_surat"
                                value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col">
                            <label for="" class="form-label required ">Sifat Surat</label>
                            <select name="jenis_surat" id="jenis_surat" class="form-control" data-control="select2"
                                required>
                                @foreach ($data_jenis_surat as $jenis)
                                    <option value="{{ $jenis->kode }}">
                                        {{ $jenis->name }}</option>
                                @endforeach
                            </select>
                        </div>



                    </div>

                    <div class="row mb-5">

                        <div class="col">
                            <label for="" class="form-label required">Pengolah</label>
                            <select name="dikirim_oleh" id="dikirim_oleh" class="form-control" data-control="select2"
                                required>
                                @foreach ($data_divisi as $divisi)
                                    <option value="{{ $divisi->name }}"
                                        {{ $divisi->kode == auth()->user()->kode_divisi ? 'selected' : '' }}>
                                        {{ $divisi->kode }} -
                                        {{ $divisi->name }}</option>
                                @endforeach
                            </select>

                        </div>
                        {{-- <div class="col">
                            <label for="" class="form-label required">Tanggal Surat</label>
                            <input type="date" class="form-control" value="{{ date('Y-m-d') }}"
                                name="tanggal_surat" required>
                        </div> --}}
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
                            <input type="text" class="form-control" name="keterangan" placeholder="">
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
                                Save
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
    <div class="modal fade" tabindex="-1" id="kt_modal_add_komponen">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('data-master.komponen.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex justify-content-between py-5 px-6">
                        <div>
                            <h2 class="fw-bold">Tambah Pengirim</h2>
                        </div>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-dark ms-2" data-bs-dismiss="modal"
                            aria-label="Close">
                            <span class="svg-icon svg-icon-1x">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none">
                                    <path opacity="0.3"
                                        d="M6 19.7C5.7 19.7 5.5 19.6 5.3 19.4C4.9 19 4.9 18.4 5.3 18L18 5.3C18.4 4.9 19 4.9 19.4 5.3C19.8 5.7 19.8 6.29999 19.4 6.69999L6.7 19.4C6.5 19.6 6.3 19.7 6 19.7Z"
                                        fill="black" />
                                    <path
                                        d="M18.8 19.7C18.5 19.7 18.3 19.6 18.1 19.4L5.40001 6.69999C5.00001 6.29999 5.00001 5.7 5.40001 5.3C5.80001 4.9 6.40001 4.9 6.80001 5.3L19.5 18C19.9 18.4 19.9 19 19.5 19.4C19.3 19.6 19 19.7 18.8 19.7Z"
                                        fill="black" />
                                </svg>
                            </span>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="d-grid gap-3 pt-2 pb-5 px-6">
                        <div class="">
                            <label class="required form-label">Kode Komponen</label>
                            <input type="text" name="kode_komponen" class="form-control" placeholder="Contoh: AWD"
                                required />
                        </div>
                        <div class="">
                            <label class="required form-label">Nama Komponen</label>
                            <input type="text" name="name" class="form-control"
                                placeholder="Contoh: PT. Agung Wisnu Daya" required />
                        </div>
                    </div>

                    <div class="text-end py-5 px-6">
                        <button type="button" class="btn btn-sm btn-light me-1" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('add-js')
@endsection
