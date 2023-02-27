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
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
