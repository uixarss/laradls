@extends('layout.master')

@section('content')
<div id="kt_content_container" class="container-xxl">
    @include('layout.alert')
    <div class="card">
        <div class="card-body pt-9 pb-0">
            <div class="d-flex flex-wrap flex-sm-nowrap mb-0">
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                        <div class="d-flex flex-column">
                            <div class="d-flex align-items-center mb-1">
                                <h2 class="text-gray-800 fs-2 fw-bolder me-3 m-0">
                                    Surat Keluar
                                </h2>
                            </div>
                            <div class="d-flex flex-wrap fw-bold mb-4 fs-5 text-gray-400">
                                {{ $suratKeluar->nama_penerima }} - {{ $suratKeluar->isi_ringkas }} -
                                {{ \Carbon\Carbon::parse($suratKeluar->tanggal_surat)->format('d M Y') }}
                            </div>
                        </div>
                        <div class="d-flex mb-4">
                            <div class="me-0">
                                @if (auth()->user()->can('approve-surat-keluar'))
                                <!--begin::Approve Surat Keluar-->
                                <a href="#" class="btn btn-sm btn-icon btn-light-success" data-bs-toggle="modal" data-bs-target="#kt_modal_approve">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->


                                    <svg width="15" height="15" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_42_4395)">
                                            <path d="M18.3334 1.66667L9.16675 10.8333" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M18.3334 1.66667L12.5001 18.3333L9.16675 10.8333L1.66675 7.50001L18.3334 1.66667Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_42_4395">
                                                <rect width="20" height="20" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>

                                    <!--end::Svg Icon-->
                                </a>
                                <!--end::Approve Surat Keluar-->
                                @endif
                                @if ($suratKeluar->status != 'SUDAH DIKIRIM')
                                <!--begin::Disposisi-->
                                <a href="#" class="btn btn-sm btn-icon btn-light-info" data-bs-toggle="modal" data-bs-target="#kt_modal_disposisi">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->


                                    <svg width="15" height="15" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_42_4395)">
                                            <path d="M18.3334 1.66667L9.16675 10.8333" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M18.3334 1.66667L12.5001 18.3333L9.16675 10.8333L1.66675 7.50001L18.3334 1.66667Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_42_4395">
                                                <rect width="20" height="20" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>

                                    <!--end::Svg Icon-->
                                </a>
                                <!--end::Disposisi-->
                                @endif
                                @if (($suratKeluar->status == 'DISETUJUI') && (auth()->user()->can('send-surat-keluar')))
                                <!--begin::Send Surat Keluar-->
                                <a href="#" class="btn btn-sm btn-icon btn-light-warning" data-bs-toggle="modal" data-bs-target="#kt_modal_send">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->


                                    <svg width="15" height="15" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_42_4395)">
                                            <path d="M18.3334 1.66667L9.16675 10.8333" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M18.3334 1.66667L12.5001 18.3333L9.16675 10.8333L1.66675 7.50001L18.3334 1.66667Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_42_4395">
                                                <rect width="20" height="20" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>

                                    <!--end::Svg Icon-->
                                </a>
                                <!--end::Send Surat Keluar-->
                                @endif
                            </div>
                            <div class="me-0">
                                <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <span class="svg-icon svg-icon-muted svg-icon-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <rect x="10" y="10" width="4" height="4" rx="2" fill="currentColor" />
                                            <rect x="10" y="3" width="4" height="4" rx="2" fill="currentColor" />
                                            <rect x="10" y="17" width="4" height="4" rx="2" fill="currentColor" />
                                        </svg></span>
                                </button>
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-200px py-3" data-kt-menu="true">
                                    @if (auth()->user()->can('download-surat-keluar'))
                                    <div class="menu-item px-3">
                                        <a href="{{ route('download.suratkeluar', $suratKeluar->id) }}" class="menu-link px-3">
                                            <span class="svg-icon svg-icon-muted svg-icon-2">
                                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M17.5 12.5V15.8333C17.5 16.2754 17.3244 16.6993 17.0118 17.0118C16.6993 17.3244 16.2754 17.5 15.8333 17.5H4.16667C3.72464 17.5 3.30072 17.3244 2.98816 17.0118C2.67559 16.6993 2.5 16.2754 2.5 15.8333V12.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M5.83337 8.33331L10 12.5L14.1667 8.33331" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M10 12.5V2.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                                Download Dokumen
                                            </span>
                                        </a>
                                    </div>
                                    @endif
                                    @if (auth()->user()->can('edit-surat-keluar'))
                                    <div class="menu-item px-3">
                                        <a href="{{ route('suratkeluar.edit', $suratKeluar->uuid) }}" class="menu-link px-3">
                                            <span class="svg-icon svg-icon-muted svg-icon-2">
                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M8 13.3333H14" stroke="#92929D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M11 2.3334C11.2652 2.06819 11.6249 1.91919 12 1.91919C12.1857 1.91919 12.3696 1.95577 12.5412 2.02684C12.7128 2.09791 12.8687 2.20208 13 2.3334C13.1313 2.46472 13.2355 2.62063 13.3066 2.79221C13.3776 2.96379 13.4142 3.14769 13.4142 3.3334C13.4142 3.51912 13.3776 3.70302 13.3066 3.8746C13.2355 4.04618 13.1313 4.20208 13 4.3334L4.66667 12.6667L2 13.3334L2.66667 10.6667L11 2.3334Z" stroke="#92929D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                                Edit
                                            </span>
                                        </a>
                                    </div>
                                    @endif
                                    @if (auth()->user()->can('upload-dokumen-surat-keluar'))
                                    <div class="menu-item px-3">
                                        <button class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#kt_modal_document">
                                            <span class="svg-icon svg-icon-muted svg-icon-2">
                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M8 13.3333H14" stroke="#92929D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M11 2.3334C11.2652 2.06819 11.6249 1.91919 12 1.91919C12.1857 1.91919 12.3696 1.95577 12.5412 2.02684C12.7128 2.09791 12.8687 2.20208 13 2.3334C13.1313 2.46472 13.2355 2.62063 13.3066 2.79221C13.3776 2.96379 13.4142 3.14769 13.4142 3.3334C13.4142 3.51912 13.3776 3.70302 13.3066 3.8746C13.2355 4.04618 13.1313 4.20208 13 4.3334L4.66667 12.6667L2 13.3334L2.66667 10.6667L11 2.3334Z" stroke="#92929D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                                Upload Document
                                            </span>
                                        </button>
                                    </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder">
                <li class="nav-item">
                    <a class="nav-link text-active-primary py-5 me-6 active" data-bs-toggle="tab" href="#kt_ringkasan">Ringkasan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-active-primary py-5 me-6" data-bs-toggle="tab" href="#kt_lokasi">Lokasi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-active-primary py-5 me-6" data-bs-toggle="tab" href="#kt_riwayat">Riwayat</a>
                </li>
                @if (auth()->user()->can('read-log-surat-keluar'))
                <li class="nav-item">
                    <a class="nav-link text-active-primary py-5 me-6" data-bs-toggle="tab" href="#kt_log">Log</a>
                </li>
                @endif
                @if (auth()->user()->can('preview-surat-keluar'))
                <li class="nav-item">
                    <a class="nav-link text-active-primary py-5 me-6" data-bs-toggle="tab" href="#kt_preview">Preview</a>
                </li>
                @endif

            </ul>
        </div>
    </div>

    <div class="row gy-5 g-xl-8 mt-5">
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="kt_ringkasan" role="tabpanel">
                @include('partials.tabs.keluar.ringkas')
            </div>
            <div class="tab-pane fade" id="kt_lokasi" role="tabpanel">
                @include('partials.tabs.keluar.lokasi')
            </div>
            <div class="tab-pane fade" id="kt_riwayat" role="tabpanel">
                @include('partials.tabs.keluar.riwayat')
            </div>
            @if (auth()->user()->can('read-log-surat-keluar'))
            <div class="tab-pane fade" id="kt_log" role="tabpanel">
                @include('partials.tabs.keluar.log')
            </div>
            @endif
            @if (auth()->user()->can('preview-surat-keluar'))
            <div class="tab-pane fade" id="kt_preview" role="tabpanel">
                @include('partials.tabs.keluar.preview')
            </div>
            @endif
        </div>

    </div>
</div>

<x-modal id="kt_modal_document">
    <div class="card card-flush py-4">
        <form action="{{ route('upload.document.suratkeluar', $suratKeluar->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-header">
                <h1 class=" modal-title">Upload Document</h1>
            </div>
            <div class="card-body">
                <label for="">File Document</label>
                <input type="file" class="form-control" name="file_lampiran" required>
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
<div class="modal fade" tabindex="-1" id="kt_modal_disposisi">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('suratkeluar.store.riwayat', $suratKeluar->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="d-flex justify-content-between py-5 px-6">
                    <div>
                        <h2 class="fw-bold">Progress Surat Keluar </h2>
                    </div>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-dark ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-1x">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path opacity="0.3" d="M6 19.7C5.7 19.7 5.5 19.6 5.3 19.4C4.9 19 4.9 18.4 5.3 18L18 5.3C18.4 4.9 19 4.9 19.4 5.3C19.8 5.7 19.8 6.29999 19.4 6.69999L6.7 19.4C6.5 19.6 6.3 19.7 6 19.7Z" fill="black" />
                                <path d="M18.8 19.7C18.5 19.7 18.3 19.6 18.1 19.4L5.40001 6.69999C5.00001 6.29999 5.00001 5.7 5.40001 5.3C5.80001 4.9 6.40001 4.9 6.80001 5.3L19.5 18C19.9 18.4 19.9 19 19.5 19.4C19.3 19.6 19 19.7 18.8 19.7Z" fill="black" />
                            </svg>
                        </span>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="d-grid gap-3 pt-2 pb-5 px-6">
                    <div class="">
                        <label class="required form-label">Diteruskan Kepada</label>
                        <select name="diteruskan_kepada[]" class="form-select form-select-solid" data-control="select2" data-close-on-select="false" data-placeholder="Select an option" data-allow-clear="true" multiple="multiple">
                            @foreach ($data_user as $user)
                            <option value="{{ $user->id }}">
                                {{ $user->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="">
                        <label class="required form-label">Status</label>
                        <select name="status" class="form-select form-select-solid" data-control="select2" data-close-on-select="false" data-placeholder="Pilih Status" data-allow-clear="true">
                            <option value="REVISI">
                                REVISI
                            </option>
                            {{-- <option value="PENDING">
                                    PENDING
                                </option> --}}
                            <option value="PROSES">
                                PROSES
                            </option>
                            <option value="DITERIMA">
                                DITERIMA
                            </option>
                            <option value="DRAFT">
                                DRAFT
                            </option>

                        </select>
                    </div>
                    <div class="">
                        <label class="required form-label">Catatan</label>
                        <input type="text" name="catatan" class="form-control form-control" required />
                    </div>
                </div>

                <div class="text-end py-5 px-6">
                    <button type="button" class="btn btn-sm btn-light me-1" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="kt_modal_approve">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('suratkeluar.approve', $suratKeluar->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="d-flex justify-content-between py-5 px-6">
                    <div>
                        <h2 class="fw-bold">Menyetujui Surat Keluar </h2>
                    </div>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-dark ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-1x">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path opacity="0.3" d="M6 19.7C5.7 19.7 5.5 19.6 5.3 19.4C4.9 19 4.9 18.4 5.3 18L18 5.3C18.4 4.9 19 4.9 19.4 5.3C19.8 5.7 19.8 6.29999 19.4 6.69999L6.7 19.4C6.5 19.6 6.3 19.7 6 19.7Z" fill="black" />
                                <path d="M18.8 19.7C18.5 19.7 18.3 19.6 18.1 19.4L5.40001 6.69999C5.00001 6.29999 5.00001 5.7 5.40001 5.3C5.80001 4.9 6.40001 4.9 6.80001 5.3L19.5 18C19.9 18.4 19.9 19 19.5 19.4C19.3 19.6 19 19.7 18.8 19.7Z" fill="black" />
                            </svg>
                        </span>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="d-grid gap-3 pt-2 pb-5 px-6">
                    <!-- <div class="">
                            <label class="required form-label">Diteruskan Kepada</label>
                            <select name="diteruskan_kepada[]" class="form-select form-select-solid"
                                data-control="select2" data-close-on-select="false" data-placeholder="Select an option"
                                data-allow-clear="true" multiple="multiple">
                                @foreach ($data_user as $user)
                                    <option value="{{ $user->id }}">
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div> -->
                    <div class="">
                        <label class="required form-label">Status</label>
                        <select name="status" class="form-select form-select-solid" data-control="select2" data-close-on-select="false" data-placeholder="Pilih Status" data-allow-clear="true">
                            {{-- <option value="REVISI">
                                    REVISI
                                </option> --}}
                            {{-- <option value="PENDING">
                                    PENDING
                                </option> --}}
                            {{-- <option value="PROSES">
                                    PROSES
                                </option> --}}
                            <option value="DISETUJUI">
                                DISETUJUI
                            </option>
                            {{-- <option value="DRAFT">
                                    DRAFT
                                </option> --}}

                        </select>
                    </div>
                    {{-- <div class="">
                            <label class="required form-label">Catatan</label>
                            <input type="text" name="catatan" class="form-control form-control" required />
                        </div> --}}
                </div>

                <div class="text-end py-5 px-6">
                    <button type="button" class="btn btn-sm btn-light me-1" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="kt_modal_send">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('suratkeluar.send', $suratKeluar->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="d-flex justify-content-between py-5 px-6">
                    <div>
                        <h2 class="fw-bold">Kirim Surat Keluar </h2>
                    </div>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-dark ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-1x">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path opacity="0.3" d="M6 19.7C5.7 19.7 5.5 19.6 5.3 19.4C4.9 19 4.9 18.4 5.3 18L18 5.3C18.4 4.9 19 4.9 19.4 5.3C19.8 5.7 19.8 6.29999 19.4 6.69999L6.7 19.4C6.5 19.6 6.3 19.7 6 19.7Z" fill="black" />
                                <path d="M18.8 19.7C18.5 19.7 18.3 19.6 18.1 19.4L5.40001 6.69999C5.00001 6.29999 5.00001 5.7 5.40001 5.3C5.80001 4.9 6.40001 4.9 6.80001 5.3L19.5 18C19.9 18.4 19.9 19 19.5 19.4C19.3 19.6 19 19.7 18.8 19.7Z" fill="black" />
                            </svg>
                        </span>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="d-grid gap-3 pt-2 pb-5 px-6">
                    <div class="">
                        <label class="required form-label">Dikirim Pada Tanggal</label>
                        <input type="date" name="tanggal_dikirim" class="form-control form-control" required />
                    </div>

                    {{-- <div class="">
                            <label class="required form-label">Dikirim Oleh</label>
                            <input type="text" name="dikirim_oleh" class="form-control form-control" required />
                        </div> --}}
                </div>

                <div class="text-end py-5 px-6">
                    <button type="button" class="btn btn-sm btn-light me-1" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


@section('add-js')
@endsection