<div class="d-flex gap-3">
    <div class="col-sm-12 col-md-7">
        <div class="card card-flush">
            <div class="card-body px-12 py-10">
                <div class="informasi d-grid gap-4">
                    <div class="row">
                        <div class="card-title">
                            <h1 class="d-flex text-dark fw-bolder fs-3 align-items-left my-1">Informasi Dokumen
                            </h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label class="form-label text-muted">Nomor Berkas</label>
                            <p class="m-0 fs-6 text-dark">{{$document->nomor_berkas}}</p>
                        </div>
                        <div class="col">
                            <label class="form-label text-muted">Jumlah</label>
                            <p class="m-0 fs-6 text-dark">{{$document->jumlah}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label class="form-label text-muted">Perihal</label>
                            <p class="m-0 fs-6 text-dark">{{$document->title}}</p>
                        </div>
                        <div class="col">
                            <label class="form-label text-muted">Klasifikasi</label>
                            <p class="m-0 fs-6 text-dark">{{$document->klasifikasi->name ?? '-'}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label class="form-label text-muted">Tanggal Berkas</label>
                            <p class="m-0 fs-6 text-dark">{{\Carbon\Carbon::parse($document->published_at)->format('d M Y')}}</p>
                        </div>
                        <div class="col">
                            <label class="form-label text-muted">Pengolah</label>
                            <p class="m-0 fs-6 text-dark">{{$document->author}}</p>
                        </div>
                    </div>
                </div>
                <div class="separator mt-6 mb-5"></div>
                <div class="berkas d-grid gap-4">
                    <div class="row">
                        <div class="card-title">
                            <h1 class="d-flex text-dark fw-bolder fs-3 align-items-left my-1">Berkas</h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label class="form-label text-muted">File Dokumen</label>
                            <p class="m-0 fs-6 text-dark">
                                <a class="btn btn-sm my-1" data-bs-toggle="modal" data-bs-target="#LihatDokumen">
                                    Lihat Dokumen
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="separator mt-6 mb-5"></div>
                <div class="lokasi d-grid gap-4">
                    <div class="row">
                        <div class="card-title">
                            <h1 class="d-flex text-dark fw-bolder fs-3 align-items-left my-1">Lokasi Arsip
                            </h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label class="form-label text-muted">Peralatan Arsip</label>
                            @foreach ($data_lokasi_dokumen as $lokasi_dokumen)
                            <p class="m-0 fs-6 text-dark">
                                {{$lokasi_dokumen->lokasi->name ?? '-'}}
                            </p>
                            @endforeach

                        </div>
                        <div class="col">
                            <label class="form-label text-muted">Kode/No</label>
                            @foreach ($data_lokasi_dokumen as $lokasi_dokumen)
                            <p class="m-0 fs-6 text-dark">
                                {{$lokasi_dokumen->lokasi->kode ?? '-'}} / {{$lokasi_dokumen->name?? '-'}}
                            </p>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card m-0 p-0">
            <iframe src="{{asset($document->location_file)}}#toolbar=1" width="100%" height="500"></iframe>
        </div>
    </div>

    <x-modal id="LihatDokumen">
        <div class="card card-flush py-4">
                <div class="card-header">
                    <h1 class="modal-title">File Dokumen</h1>
                    <input type="hidden" name="id" value="{{ $document->id }}" hidden>

                </div>
                <div class="card-body">
                    <iframe src="{{asset($document->location_file)}}#toolbar=1" width="100%" height="100%"></iframe>
                </div>
                <div class="card-footer">
                    <div class="text-end">
                        <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
        </div>
    </x-modal>
</div>
