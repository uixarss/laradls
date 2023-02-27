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
                                    Dokumen
                                </h2>
                            </div>
                            <div class="d-flex flex-wrap fw-bold mb-4 fs-5 text-gray-400">
                                {{ $document->nomor_berkas }} - {{ $document->title }} -
                                {{ \Carbon\Carbon::parse($document->published_at)->format('d M Y') }}
                            </div>
                        </div>
                        <div class="d-flex mb-4 justify-content-end gap-3">
                            <!--begin::Upload Document-->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_upload_document">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="black" />
                                        <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="black" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                                Upload Document
                            </button>
                            <!--end::Upload Document-->
                            <a href="{{ route('arsip.dokumen.download', ['uuid' => $document->uuid]) }}" class="btn btn-sm btn-primary me-3">
                                Download
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder">
                <li class="nav-item">
                    <a class="nav-link text-active-primary py-5 me-6 active" data-bs-toggle="tab" href="#kt_ringkasan">Ringkasan</a>
                </li>
                @if (auth()->user()->can('edit-dokumen'))
                <li class="nav-item">
                    <a class="nav-link text-active-primary py-5 me-6" data-bs-toggle="tab" href="#kt_edit">Edit</a>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link text-active-primary py-5 me-6" data-bs-toggle="tab" href="#kt_lokasi">Lokasi</a>
                </li>
                @if (auth()->user()->can('read-log-dokumen'))
                <li class="nav-item">
                    <a class="nav-link text-active-primary py-5 me-6" data-bs-toggle="tab" href="#kt_log">Log</a>
                </li>
                @endif
            </ul>
        </div>
    </div>


    <div class="row gy-5 g-xl-8 mt-5">
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="kt_ringkasan" role="tabpanel">
                @include('partials.tabs.arsip.ringkas')
            </div>
            @if (auth()->user()->can('edit-dokumen'))
            <div class="tab-pane fade" id="kt_edit" role="tabpanel">
                @include('partials.tabs.arsip.edit')
            </div>
            @endif
            <div class="tab-pane fade" id="kt_lokasi" role="tabpanel">
                @include('partials.tabs.arsip.lokasi')
            </div>
            @if (auth()->user()->can('read-log-dokumen'))
            <div class="tab-pane fade" id="kt_log" role="tabpanel">
                @include('partials.tabs.arsip.log')
            </div>
            @endif
        </div>

    </div>

    <div class="modal fade" tabindex="-1" id="kt_modal_upload_document">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('arsip.dokumen.upload', [$document->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex justify-content-between py-5 px-6">
                        <div>
                            <h2 class="fw-bold">Upload Naskah</h2>
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
                            <label class="required form-label">File Document</label>
                            <input type="file" name="document_file" class="form-control form-control" required />
                        </div>
                        <div class="d-flex left-content-end">
                            <label for="" class="form-label required"><small>Wajib diisi</small></label>

                        </div>
                    </div>

                    <div class="text-end py-5 px-6">
                        <button type="button" class="btn btn-sm btn-light me-1" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-sm btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection