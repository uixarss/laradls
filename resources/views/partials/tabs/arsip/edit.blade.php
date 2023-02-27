<div class="d-flex gap-3">
    <div class="col-sm-12 col-md-12">
        <div class="card card-flush py-4">
            <div class="card-body">
                <form action="{{ route('arsip.dokumen.update', $document->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row mb-5">
                        <div class="col">
                            <label for="" class="form-label required">Nomor Berkas</label>
                            <input type="text" class="form-control" name="nomor_berkas" value="{{$document->nomor_berkas}}" required>
                        </div>
                        <div class="col">
                            <label for="" class="form-label required ">Kode Klasifikasi</label>
                            <select name="kode_klasifikasi" class="form-control" data-control="select2"
                                required>
                                <option value=""disabled aria-readonly="true">-- Select --</option>
                                @foreach ($data_klasifikasi as $klasifikasi)
                                    <option value="{{ $klasifikasi->kode_klasifikasi }}" {{($klasifikasi->kode_klasifikasi == $document->kode_klasifikasi) ? ' selected="selected"' : '' }} >
                                        {{ $klasifikasi->kode_klasifikasi }} | {{ $klasifikasi->name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col">
                            <label for="" class="form-label required">Uraian Perihal Dokumen / Perihal</label>
                            <input type="text" class="form-control" value="{{$document->title}}" name="title" required>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col">
                            <label for="" class="form-label required">Tanggal</label>
                            <input type="date" class="form-control" value="{{ \Carbon\Carbon::parse($document->published_at)->format('Y-m-d')}}" name="published_at"
                                required>
                        </div>
                        <div class="col">
                            <label for="" class="form-label required">Jumlah</label>
                            <input type="number" class="form-control" value="{{$document->jumlah}}" name="jumlah" required>
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="col">
                            <label for="" class="form-label required">Pengolah</label>
                            <input type="text" class="form-control" value="{{$document->author}}" name="author" required>
                            {{-- <select name="" id="" class="form-control" data-control="select2" required>
                                <option value="">-- Select --</option>
                            </select> --}}
                        </div>
                    </div>

                    {{-- <div class="row mb-5">
                        <div class="col">
                            <label for="" class="form-label required ">Scan Surat</label>
                            <input type="file" class="form-control" placeholder="" name="file_lampiran" required>
                        </div>
                    </div> --}}

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
</div>
