@extends('layout.master')

@section('content')
<!--begin::Container-->
<div id="kt_content_container" class="container-xxl">
    @include('layout.alert')
    <div class="row gy-5 g-xl-10">
        <!--begin::Col-->
        <div class="col-sm-6 col-xl-3 mb-xl-10">
            <!--begin::Card widget 2-->
            <div class="card h-lg-100">
                <!--begin::Body-->
                <div class="card-body d-flex justify-content-between align-items-start flex-rows">

                    <!--begin::Section-->
                    <div class="d-flex flex-column align-self-center">
                        <!--begin::Number-->
                        <span class="fw-bold fs-3x text-gray-800 lh-1 ls-n2">{{ number_format($total_surat_masuk->count()) }}</span>
                        <!--end::Number-->
                        <!--begin::Total Vendor-->
                        <div class="m-0">
                            <span class="fw-bold fs-6 text-gray-400">Total Data Surat Masuk</span>
                        </div>
                        <!--end::Total Vendor-->
                    </div>
                    <!--end::Section-->

                    <img src="{{ asset('assets/media/illustrations/inbox.svg') }}" class="h-125px" alt="">


                </div>
                <!--end::Body-->
            </div>
            <!--end::Card widget 2-->
        </div>
        <!--end::Col-->

        {{-- 
        <!--begin::Col-->
        <div class="col-sm-6 col-xl-3 mb-xl-10">
            <!--begin::Card widget 2-->
            <div class="card h-lg-100">
                <!--begin::Body-->
                <div class="card-body d-flex justify-content-between align-items-start flex-rows">

                    <!--begin::Section-->
                    <div class="d-flex flex-column align-self-center">
                        <!--begin::Number-->
                        <span class="fw-bold fs-3x text-gray-800 lh-1 ls-n2">{{ number_format($total_dokumen->count()) }}</span>
                        <!--end::Number-->
                        <!--begin::Total Vendor-->
                        <div class="m-0">
                            <span class="fw-bold fs-6 text-gray-400">Total Dokumen</span>
                        </div>
                        <!--end::Total Vendor-->
                    </div>
                    <!--end::Section-->

                    <img src="{{ asset('assets/media/illustrations/icon-document.svg') }}" class="h-125px" alt="">
                    


                </div>
                <!--end::Body-->
            </div>
            <!--end::Card widget 2-->
        </div>
        <!--end::Col-->
        --}}
        <!--begin::Col-->
        <div class="col-sm-6 col-xl-3 mb-xl-10">
            <!--begin::Card widget 2-->
            <div class="card h-lg-100">
                <!--begin::Body-->
                <div class="card-body d-flex justify-content-between align-items-start flex-rows">

                    <!--begin::Section-->
                    <div class="d-flex flex-column align-self-center">
                        <!--begin::Number-->
                        <span class="fw-bold fs-3x text-gray-800 lh-1 ls-n2">{{ number_format($total_surat_keluar->count()) }}</span>
                        <!--end::Number-->
                        <!--begin::Total Vendor-->
                        <div class="m-0">
                            <span class="fw-bold fs-6 text-gray-400">Total Data Surat Keluar</span>
                        </div>
                        <!--end::Total Vendor-->
                    </div>
                    <!--end::Section-->

                    <img src="{{ asset('assets/media/illustrations/outbox.svg') }}" class="h-125px" alt="">


                </div>
                <!--end::Body-->
            </div>
            <!--end::Card widget 2-->
        </div>
        <!--end::Col-->

        <!--begin::Col-->
        <div class="col-sm-6 col-xl-3 mb-xl-10">
            <!--begin::Card widget 2-->
            <div class="card h-lg-100">
                <!--begin::Body-->
                <div class="card-body d-flex justify-content-between align-items-start flex-rows">

                    <!--begin::Section-->
                    <div class="d-flex flex-column align-self-center">
                        <!--begin::Number-->
                        <span class="fw-bold fs-3x text-gray-800 lh-1 ls-n2">{{ number_format($data_surat_masuk->count()) }}</span>
                        <!--end::Number-->
                        <!--begin::Total Vendor-->
                        <div class="m-0">
                            <span class="fw-bold fs-6 text-gray-400">Surat Masuk</span>
                        </div>
                        <!--end::Total Vendor-->
                    </div>
                    <!--end::Section-->

                    <img src="{{ asset('assets/media/illustrations/disposisi.svg') }}" class="h-125px" alt="">


                </div>
                <!--end::Body-->
            </div>
            <!--end::Card widget 2-->
        </div>
        <!--end::Col-->

        <!--begin::Col-->
        <div class="col-sm-6 col-xl-3 mb-xl-10">
            <!--begin::Card widget 2-->
            <div class="card h-lg-100">
                <!--begin::Body-->
                <div class="card-body d-flex justify-content-between align-items-start flex-rows">

                    <!--begin::Section-->
                    <div class="d-flex flex-column align-self-center">
                        <!--begin::Number-->
                        <span class="fw-bold fs-3x text-gray-800 lh-1 ls-n2">{{ $data_user->count() }}</span>
                        <!--end::Number-->
                        <!--begin::Total Vendor-->
                        <div class="m-0">
                            <span class="fw-bold fs-6 text-gray-400">User</span>
                        </div>
                        <!--end::Total Vendor-->
                    </div>
                    <!--end::Section-->

                    <img src="{{ asset('assets/media/illustrations/user.svg') }}" class="h-125px" alt="">


                </div>
                <!--end::Body-->
            </div>
            <!--end::Card widget 2-->
        </div>
        <!--end::Col-->
    </div>

    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder">
                    <li class="nav-item">
                        <a class="nav-link text-active-primary py-5 me-2 active" data-bs-toggle="tab" href="#kt_masuk">Masuk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-active-primary py-5 me-2" data-bs-toggle="tab" href="#kt_keluar">Keluar</a>
                    </li>
                </ul>
            </div>

            <div class="card-toolbar">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-kearsipan-table-toolbar="base">
                    <div class="d-flex align-items-center position-relative my-1 me-2">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                        <span class="svg-icon svg-icon-1 position-absolute ms-6">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
                                <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        <input type="text" data-kt-kearsipan-table-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Cari Kearsipan" />
                    </div>
                </div>
                <!--end::Toolbar-->
                <!--begin::Group actions-->
                <div class="d-flex justify-content-end align-items-center d-none" data-kt-kearsipan-table-toolbar="selected">
                    <div class="fw-bolder me-5">
                        <span class="me-2" data-kt-kearsipan-table-select="selected_count"></span>Terpilih
                    </div>
                    <button type="button" class="btn btn-danger" data-kt-kearsipan-table-select="delete_selected">Hapus
                        Terpilih</button>
                </div>
                <!--end::Group actions-->
            </div>

        </div>

        <div class="card-body pt-0">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active table-responsive" id="kt_masuk" role="tabpanel">
                    <table class="table align-middle border rounded table-row-dashed fs-6 g-5" id="kt_table_kearsipan">
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase table-light">
                                <th class="w-10px pe-2">
                                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                        <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_table_surat .form-check-input" value="1" />
                                    </div>
                                </th>
                                <th class="min-w">Agenda</th>
                                <th class="min-w">Nomor Surat</th>
                                <th class="min-w">Dari</th>
                                <th class="min-w">Tanggal Surat</th>
                                <th class="min-w">Tanggal Terima</th>
                                <th class="min-w">Sifat Surat</th>
                                <th class="min-w">Status</th>
                                <th class="min-w"></th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <tbody class="text-gray-600 fw-bold">
                            @foreach ($data_surat_masuk as $sm)
                            <tr class="">
                                <td>
                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="1" />
                                    </div>
                                </td>
                                <td>{{ $sm->indeks->kode_klasifikasi }}/{{ $sm->no_agenda }}</td>
                                <td>{{ $sm->nomor_surat }}</td>
                                <td>{{ $sm->nama_pengirim }}</td>
                                <td>{{ \Carbon\Carbon::parse($sm->tanggal_surat)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($sm->tanggal_diterima)->format('d/m/Y') }}</td>
                                <td><span class="badge badge-primary">N/A</span></td>
                                <td>
                                    <div class="badge badge-light-dark">{{ $sm->status ?? '-' }}</div>
                                </td>
                                <td class="text-end">
                                    <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                        Aksi
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                        <span class="svg-icon svg-icon-5 m-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </a>
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                                        @if (auth()->user()->can('print-surat-masuk'))
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">Cetak</a>
                                        </div>
                                        <!--end::Menu item-->
                                        @endif
                                        @if (auth()->user()->can('disposisi-surat-masuk'))
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">Disposisi Surat</a>
                                        </div>
                                        <!--end::Menu item-->
                                        @endif
                                        @if (auth()->user()->can('detail-surat-masuk'))
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="{{ route('suratmasuk.show', $sm->uuid) }}" class="menu-link px-3">Detail</a>
                                        </div>
                                        <!--end::Menu item-->
                                        @endif
                                        @if (auth()->user()->can('download-surat-masuk'))
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="{{ route('download.suratmasuk', $sm->id) }}" class="menu-link px-3">Download</a>
                                        </div>
                                        <!--end::Menu item-->
                                        @endif
                                        @if (auth()->user()->can('edit-surat-masuk'))
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="{{ route('suratmasuk.edit', $sm->uuid) }}" class="menu-link px-3 text-warning">Edit</a>
                                        </div>
                                        <!--end::Menu item-->
                                        @endif
                                        @if (auth()->user()->can('delete-surat-masuk'))
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3 text-danger" data-bs-toggle="modal" data-bs-target="#kt_modal_delete_confirm{{ $sm->id }}">Hapus</a>
                                        </div>
                                        <!--end::Menu item-->
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @foreach ($data_surat_masuk as $sm)
                            <!-- begin::ModalDelete -->
                            <div class="modal fade" tabindex="-1" id="kt_modal_delete_confirm{{ $sm->id }}">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="" method="post">
                                            @csrf
                                            @method('delete')
                                            <div class="d-flex justify-content-between py-5 px-6">
                                                <div>
                                                    <h2 class="fw-bold">Hapus Surat Masuk</h2>
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

                                            <div class="py-2 px-6">
                                                <p class="m-0 fs-4 lh-5">Apakah kamu yakin ingin menghapus
                                                    <b>{{ $sm->nomor_surat }}? ?</b>
                                                    Jika iya, maka data akan terhapus permanen.
                                                </p>
                                            </div>

                                            <div class="text-end py-5 px-6">
                                                <button type="button" class="btn btn-sm btn-light me-1" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- end::ModalDelete -->
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade table-responsive" id="kt_keluar" role="tabpanel">
                    <table class="table align-middle border rounded table-row-dashed fs-6 g-5" id="kt_table_kearsipan">
                        <thead>
                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase table-light gs-0">
                                <th class="w-10px pe-2">
                                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                        <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_table_surat .form-check-input" value="1" />
                                    </div>
                                </th>
                                <th class="min-w">Agenda</th>
                                <th class="min-w">Nomor Surat</th>
                                <th class="min-w">Perihal</th>
                                <th class="min-w">Dari</th>
                                <th class="min-w">Kepada</th>
                                <th class="min-w">Tanggal Surat</th>
                                <th class="min-w">Pengolah</th>
                                <th class="min-w">Status</th>
                                <th class="min-w">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 fw-bold">
                            @foreach ($data_surat_keluar as $sm)
                            <tr class="">
                                <td>
                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="1" />
                                    </div>
                                </td>
                                <td>
                                    {{-- {{ $sm->indeks->kode_klasifikasi }}/{{ $sm->no_agenda }} --}}
                                    {{$sm->nomor ?? ' '}}
                                </td>
                                <td>{{ $sm->nomor_surat }}</td>
                                <td>
                                    {{ $sm->isi_ringkas }}
                                </td>
                                <td>{{ $sm->dikirim_oleh }}</td>
                                <td>{{ $sm->nama_penerima }}</td>
                                <td>{{ \Carbon\Carbon::parse($sm->tanggal_surat)->format('d/m/Y') }}</td>
                                {{-- <td>{{ \Carbon\Carbon::parse($sm->tanggal_diterima)->format('d/m/Y') }}</td> --}}
                                <td><span class="badge badge-primary">
                                        {{ $sm->creator->name ?? 'N/A'}}
                                    </span></td>
                                <td>
                                    <div class="badge badge-light-dark">{{ $sm->status ?? '-' }}</div>
                                </td>
                                <td class="text-end">
                                    <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                        Aksi
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                        <span class="svg-icon svg-icon-5 m-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </a>
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                                        @if (auth()->user()->can('detail-surat-keluar'))
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="{{ route('suratkeluar.show', $sm->uuid) }}" class="menu-link px-3">Detail</a>
                                        </div>
                                        <!--end::Menu item-->
                                        @endif
                                        @if (auth()->user()->can('download-surat-keluar'))
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="{{ route('download.suratkeluar', $sm->id) }}" class="menu-link px-3">Download</a>
                                        </div>
                                        <!--end::Menu item-->
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @foreach ($data_surat_keluar as $sm)
                            <!-- begin::ModalDelete -->
                            <div class="modal fade" tabindex="-1" id="kt_modal_delete_confirm{{ $sm->id }}">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="" method="post">
                                            @csrf
                                            @method('delete')
                                            <div class="d-flex justify-content-between py-5 px-6">
                                                <div>
                                                    <h2 class="fw-bold">Hapus Surat Keluar</h2>
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

                                            <div class="py-2 px-6">
                                                <p class="m-0 fs-4 lh-5">Apakah kamu yakin ingin menghapus
                                                    <b>{{ $sm->nomor_surat }}? ?</b>
                                                    Jika iya, maka data akan terhapus permanen.
                                                </p>
                                            </div>

                                            <div class="text-end py-5 px-6">
                                                <button type="button" class="btn btn-sm btn-light me-1" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- end::ModalDelete -->
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>


</div>
<!--end::Container-->
@endsection