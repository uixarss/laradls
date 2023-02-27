<div class="card mb-5 mb-lg-10">
    <div class="card-header">
        <div class="card-title">
            <h3>Lokasi Arsip</h3>
        </div>
        <div class="card-toolbar">
            <a class="btn btn-sm btn-primary my-1" data-bs-toggle="modal" data-bs-target="#UploadLokasi">
                Tambah Lokasi Arsip
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-flush align-middle table-row-bordered table-row-solid gy-4 gs-9">
                <thead class="border-gray-200 fs-5 fw-bold bg-lighten">
                    <tr>
                        <th class="min-w-250px">Nama</th>
                        <th class="min-w-100px">Kode/No</th>
                        <th class="min-w-150px"></th>
                    </tr>
                </thead>
                <tbody class="fw-6 fw-bold text-gray-600">
                    @foreach ($data_lokasi_dokumen as $lokasi_dokumen)
                        <tr>
                            <td>
                                {{ $lokasi_dokumen->lokasi->name ?? '-' }}
                            </td>
                            <td>
                                {{ $lokasi_dokumen->lokasi->kode ?? '-' }} / {{ $lokasi_dokumen->name ?? '-' }}
                            </td>
                            <td class="text-end">
                                <a href="" class="btn btn-icon btn-sm btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#edit_lokasi_{{ $lokasi_dokumen->id }}">
                                    <span class="svg-icon svg-icon-5 m-0">

                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0_42_4785)">
                                                <path
                                                    d="M9.16663 3.33331H3.33329C2.89127 3.33331 2.46734 3.50891 2.15478 3.82147C1.84222 4.13403 1.66663 4.55795 1.66663 4.99998V16.6666C1.66663 17.1087 1.84222 17.5326 2.15478 17.8452C2.46734 18.1577 2.89127 18.3333 3.33329 18.3333H15C15.442 18.3333 15.8659 18.1577 16.1785 17.8452C16.491 17.5326 16.6666 17.1087 16.6666 16.6666V10.8333"
                                                    stroke="black" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path
                                                    d="M15.4166 2.08332C15.7481 1.7518 16.1978 1.56555 16.6666 1.56555C17.1355 1.56555 17.5851 1.7518 17.9166 2.08332C18.2481 2.41484 18.4344 2.86448 18.4344 3.33332C18.4344 3.80216 18.2481 4.2518 17.9166 4.58332L9.99996 12.5L6.66663 13.3333L7.49996 9.99999L15.4166 2.08332Z"
                                                    stroke="black" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_42_4785">
                                                    <rect width="20" height="20" fill="white" />
                                                </clipPath>
                                            </defs>
                                        </svg>

                                    </span>
                                    <!--end::Svg Icon-->
                                </a>
                                <a href="{{ route('suratmasuk.delete.lokasi', $lokasi_dokumen->id) }}"
                                    class="btn btn-icon btn-sm btn-danger">
                                    <span class="svg-icon svg-icon-5 m-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                                                fill="currentColor" />
                                            <path opacity="0.5"
                                                d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                                                fill="currentColor" />
                                            <path opacity="0.5"
                                                d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                                                fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <x-modal id="UploadLokasi">
        <div class="card card-flush py-4">
            <form action="{{ route('suratmasuk.set.lokasi', $suratMasuk->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="card-header">
                    <h1 class="modal-title">Tambah Lokasi</h1>
                    <input type="hidden" name="id" value="{{ $suratMasuk->id }}" hidden>

                </div>
                <div class="card-body">
                    <label for="" class="form-label required ">Lokasi</label>
                    <select name="lokasi_id" id="" class="form-control" data-control="select2" required>
                        <option value=""disabled aria-readonly="true">-- Select --</option>
                        @foreach ($data_lokasi as $lokasi)
                            <option value="{{ $lokasi->id }}">
                                {{ $lokasi->name }}
                            </option>
                        @endforeach

                    </select>
                    <label for="">Nama</label>
                    <input type="text" class="form-control" name="name" placeholder="02" required>
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

    @foreach ($data_lokasi_dokumen as $lokasi_dokumen)
        <x-modal id="edit_lokasi_{{ $lokasi_dokumen->id }}">
            <div class="card card-flush py-4">
                <form action="{{ route('suratmasuk.update.lokasi', $lokasi_dokumen->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-header">
                        <h1 class="modal-title">Update Lokasi</h1>
                        <input type="hidden" name="id" value="{{ $lokasi_dokumen->id }}" hidden>

                    </div>
                    <div class="card-body">
                        <label for="" class="form-label required ">Lokasi</label>
                        <select name="lokasi_id" id="" class="form-control" data-control="select2" required>
                            <option value=""disabled aria-readonly="true">-- Select --</option>
                            @foreach ($data_lokasi as $lokasi)
                                <option value="{{ $lokasi->id }}"
                                    {{ $lokasi_dokumen->lokasi_id == $lokasi->id ? 'selected="selected"' : '' }}>
                                    {{ $lokasi->name }}
                                </option>
                            @endforeach

                        </select>
                        <label for="">Nama</label>
                        <input type="text" class="form-control" name="name" value="{{ $lokasi_dokumen->name }}"
                            required>
                    </div>

                    <div class="card-footer">
                        <div class="text-end">
                            <button type="button" class="btn btn-sm btn-light"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-sm btn-primary">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </x-modal>
    @endforeach
</div>
