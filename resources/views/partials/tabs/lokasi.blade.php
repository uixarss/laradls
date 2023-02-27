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
                    {{-- @foreach ($data_lokasi_dokumen as $lokasi_dokumen) --}}
                    <tr>
                        <td>
                            {{-- {{$lokasi_dokumen->lokasi->name ?? '-'}} --}}
                        </td>
                        <td>
                            {{-- {{$lokasi_dokumen->lokasi->kode ?? '-'}} / {{$lokasi_dokumen->name?? '-'}} --}}
                        </td>
                        <td class="text-end">
                            <a href="" class="btn btn-icon btn-sm btn-danger">
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
                    {{-- @endforeach  --}}
                </tbody>
            </table>
        </div>
    </div>
</div>
