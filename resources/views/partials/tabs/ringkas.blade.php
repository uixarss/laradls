<div class="d-flex gap-3">
    <div class="col-sm-12 col-md-7">
        <div class="card card-flush">
            <div class="card-body px-12 py-10">
                <div class="informasi d-grid gap-4">
                    <div class="row">
                        <div class="card-title">
                            <h1 class="d-flex text-dark fw-bolder fs-3 align-items-left my-1">Informasi Surat
                            </h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label class="form-label text-muted">Nomor Agenda</label>
                            <p class="m-0 fs-6 text-dark">
                                {{ $suratMasuk->indeks->kode_klasifikasi }}/{{ $suratMasuk->no_agenda }}</p>
                        </div>
                        <div class="col">
                            <label class="form-label text-muted">Nomor Surat</label>
                            <p class="m-0 fs-6 text-dark">{{ $suratMasuk->nomor_surat }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label class="form-label text-muted">Surat dari</label>
                            <p class="m-0 fs-6 text-dark">{{ $suratMasuk->nama_pengirim }}</p>
                        </div>
                        <div class="col">
                            <label class="form-label text-muted">Diterima Tanggal</label>
                            <p class="m-0 fs-6 text-dark">
                                {{ \Carbon\Carbon::parse($suratMasuk->tanggal_diterima)->format('d M Y') }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label class="form-label text-muted">Perihal</label>
                            <p class="m-0 fs-6 text-dark">{{ $suratMasuk->isi_ringkas }}</p>
                        </div>
                        <div class="col">
                            <label class="form-label text-muted">Sifat Surat</label>
                            <p class="m-0 fs-6 text-dark">001/1</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label class="form-label text-muted">Tanggal Surat</label>
                            <p class="m-0 fs-6 text-dark">
                                {{ \Carbon\Carbon::parse($suratMasuk->tanggal_surat)->format('d M Y') }}</p>
                        </div>
                        <div class="col">
                            <label class="form-label text-muted">Pengolah</label>
                            <p class="m-0 fs-6 text-dark">N/A</p>
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
                            <label class="form-label text-muted">File Naskah</label>
                            <p class="m-0 fs-6 text-dark">
                                <a href="">Lihat Naskah</a>
                            </p>
                        </div>
                        <div class="col">
                            <label class="form-label text-muted">Lampiran</label>
                            <p class="m-0 fs-6 text-dark">-</p>
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
                            <p class="m-0 fs-6 text-dark">
                                Filling Cabinet
                            </p>
                        </div>
                        <div class="col">
                            <label class="form-label text-muted">Kode/No</label>
                            <p class="m-0 fs-6 text-dark">FC12</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card m-0 p-0">
            <iframe src="{{asset($suratMasuk->file_lokasi)}}#toolbar=1" width="100%"
                height="500"></iframe>
        </div>
    </div>
</div>
