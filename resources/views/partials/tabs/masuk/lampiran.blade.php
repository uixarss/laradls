<div class="card mb-5 mb-lg-10">
    <div class="card-header">
        <div class="card-title">
            <h3>Lampiran</h3>
        </div>
        <div class="card-toolbar">
            <a class="btn btn-sm btn-primary my-1" data-bs-toggle="modal" data-bs-target="#UploadLampiran">
                Upload Lampiran
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-flush align-middle table-row-bordered table-row-solid gy-4 gs-9">
                <thead class="border-gray-200 fs-5 fw-bold bg-lighten">
                    <tr>
                        <th class="min-w-250px">Nama</th>
                        <th class="min-w-150px"></th>
                    </tr>
                </thead>
                <tbody class="fw-6 fw-bold text-gray-600">
                    @foreach ($suratMasuk->lampirans as $lampiran)
                        <tr>
                            <td>
                                {{ $lampiran->name }} - {{ $lampiran->id }}
                            </td>
                            <td class="text-end">
                                <a href="#" class="btn btn-icon btn-sm btn-bg-secondary" data-bs-toggle="modal" data-bs-target="#LihatLampiran{{$lampiran->id}}">
                                    <span class="svg-icon svg-icon-5 m-0">

                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0_668_4975)">
                                                <path
                                                    d="M0.666748 7.99996C0.666748 7.99996 3.33341 2.66663 8.00008 2.66663C12.6667 2.66663 15.3334 7.99996 15.3334 7.99996C15.3334 7.99996 12.6667 13.3333 8.00008 13.3333C3.33341 13.3333 0.666748 7.99996 0.666748 7.99996Z"
                                                    stroke="#92929D" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path
                                                    d="M8 10C9.10457 10 10 9.10457 10 8C10 6.89543 9.10457 6 8 6C6.89543 6 6 6.89543 6 8C6 9.10457 6.89543 10 8 10Z"
                                                    stroke="black" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_668_4975">
                                                    <rect width="16" height="16" fill="white" />
                                                </clipPath>
                                            </defs>
                                        </svg>

                                    </span>
                                    <!--end::Svg Icon-->
                                </a>
                                <a href="{{ route('download.lampiran', $lampiran->id) }}"
                                    class="btn btn-icon btn-sm btn-success">
                                    <span class="svg-icon svg-icon-5 m-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <path opacity="0.3"
                                                d="M19 15C20.7 15 22 13.7 22 12C22 10.3 20.7 9 19 9C18.9 9 18.9 9 18.8 9C18.9 8.7 19 8.3 19 8C19 6.3 17.7 5 16 5C15.4 5 14.8 5.2 14.3 5.5C13.4 4 11.8 3 10 3C7.2 3 5 5.2 5 8C5 8.3 5 8.7 5.1 9H5C3.3 9 2 10.3 2 12C2 13.7 3.3 15 5 15H19Z"
                                                fill="currentColor" />
                                            <path d="M13 17.4V12C13 11.4 12.6 11 12 11C11.4 11 11 11.4 11 12V17.4H13Z"
                                                fill="currentColor" />
                                            <path opacity="0.3"
                                                d="M8 17.4H16L12.7 20.7C12.3 21.1 11.7 21.1 11.3 20.7L8 17.4Z"
                                                fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </a>
                                <a href="{{ route('delete.lampiran', $lampiran->id) }}"
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
                        <x-modal id="LihatLampiran{{$lampiran->id}}">
                            <div class="card card-flush py-4">
                                <div class="card-header">
                                    <h1 class="modal-title">File Dokumen</h1>
                                </div>
                                <div class="card-body">
                                    <iframe src="{{ asset($lampiran->file_lokasi) }}" width="100%" height="100%"></iframe>
                                </div>
                                <div class="card-footer">
                                    <div class="text-end">
                                        <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </x-modal>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>
