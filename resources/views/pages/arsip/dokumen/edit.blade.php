@extends('layout.master')


@section('content')
    <div id="kt_content_container" class="container-xxl">
        @include('layout.alert')
        <div class="card card-flush py-4">
            <div class="card-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-5">
                        <div class="col">
                            <label for="" class="form-label required">Nomor Berkas</label>
                            <input type="text" class="form-control" placeholder="" name="" required>
                        </div>
                        <div class="col">
                            <label for="" class="form-label required ">Kode Klasifikasi</label>
                            <select name="" id="" class="form-control" data-control="select2" required>
                                <option value="">-- Select --</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col">
                            <label for="" class="form-label required">Uraian Perihal Dokumen / Perihal</label>
                            <input type="text" class="form-control" placeholder="" name="isi_ringkas" required>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col">
                            <label for="" class="form-label required">Tanggal</label>
                            <input type="date" class="form-control" value="{{ date('Y-m-d') }}" name=""
                                required>
                        </div>
                        <div class="col">
                            <label for="" class="form-label required">Jumlah</label>
                            <input type="number" class="form-control" placeholder="" name="" required>
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="col">
                            <label for="" class="form-label required">Pengolah</label>
                            <select name="" id="" class="form-control" data-control="select2" required>
                                <option value="">-- Select --</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="col">
                            <label for="" class="form-label required ">Scan Surat</label>
                            <input type="file" class="form-control" placeholder="" name="file_lampiran" required>
                        </div>
                    </div>

                    <div class="mt-5">
                        <div class="d-flex left-content-end">
                            <label for="" class="form-label required"><small>Wajib diisi</small></label>

                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="reset" class="btn btn-light me-3">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                Update
                            </button>
                        </div>

                    </div>
                </form>
            </div>
            <!--end::Card body-->
        </div>
    </div>
@endsection
