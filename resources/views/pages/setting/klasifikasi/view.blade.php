@extends('layout.master')

@section('add-css')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('menu')
    <div class="menu-item {{ request()->is('admin/settings/pengguna*') ? 'here' : '' }} me-lg-1">
        <span class="menu-link py-3">
            <a href="{{ asset('admin/settings/pengguna') }}" class="menu-title">Pengguna</a>
        </span>
    </div>
    <div class="menu-item {{ request()->is('admin/settings/divisi*') ? 'here' : '' }} me-lg-1">
        <span class="menu-link py-3">
            <a href="{{ url('admin/settings/divisi') }}" class="menu-title">Divisi</a>
        </span>
    </div>
    <div class="menu-item {{ request()->is('admin/settings/hakakses*') ? 'here' : '' }} me-lg-1">
        <span class="menu-link py-3">
            <a href="{{ url('admin/settings/hakakses') }}" class="menu-title">Hak Akses</a>
        </span>
    </div>
    <div class="menu-item {{ request()->is('admin/settings/klasifikasi*') ? 'here' : '' }} me-lg-1">
        <span class="menu-link py-3">
            <a href="{{ url('admin/settings/klasifikasi') }}" class="menu-title">Klasifikasi</a>
        </span>
    </div>
    <div class="menu-item {{ request()->is('admin/settings/komponen*') ? 'here' : '' }} me-lg-1">
        <span class="menu-link py-3">
            <a href="{{ url('admin/settings/komponen') }}" class="menu-title">Komponen</a>
        </span>
    </div>
    <div class="menu-item {{ request()->is('admin/settings/jenisdokumen*') ? 'here' : '' }} me-lg-1">
        <span class="menu-link py-3">
            <a href="{{ url('admin/settings/jenisdokumen') }}" class="menu-title">Dokumen</a>
        </span>
    </div>
    <div class="menu-item {{ request()->is('admin/settings/jenisinventaris*') ? 'here' : '' }} me-lg-1">
        <span class="menu-link py-3">
            <a href="{{ url('admin/settings/jenisinventaris') }}" class="menu-title">Inventaris</a>
        </span>
    </div>
@endsection

@section('content')
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">
        @include('layout.alert')
        <div class="card card-flush">
            <div class="card-header align-items-center pt-5 pb-0 gap-2 gap-md-5">
                <div class="card-title">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        <span class="svg-icon svg-icon-1 position-absolute ms-4">
                            <i data-feather="search"></i>
                        </span>
                        <input type="text" data-kt-filter="search" class="form-control form-control-solid w-250px ps-14"
                            placeholder="Search Klasifikasi" />
                    </div>
                    <!--end::Search-->
                </div>
                <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                    <!--begin::Export dropdown-->
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#kt_modal_import_klasifikasi">
                        <span class="svg-icon svg-icon-1">
                            <i data-feather="plus"></i>
                        </span>
                        Import Kode Klasifikasi
                    </a>
                    <!--end::Export dropdown-->
                    <!--begin::Export dropdown-->
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_klasifikasi">
                        <span class="svg-icon svg-icon-1">
                            <i data-feather="plus"></i>
                        </span>
                        Tambah Kode Klasifikasi
                    </a>
                    <!--end::Export dropdown-->
                </div>
            </div>
            <div class="card-body pt-0 table-responsive">
                <table class="table align-middle border rounded table-row-dashed fs-6 g-5" id="kt_datatable_example_1">
                    <thead>
                        <!--begin::Table row-->
                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase table-light">
                            <th class="min-w">Kode Klasifikasi</th>
                            <th class="min-w">Nama Klasifikasi</th>
                            <th class="min-w">Updated At</th>
                            <th class="min-w">
                                <span class="svg-icon svg-icon-1">
                                    <i data-feather="more-vertical"></i>
                                </span>
                            </th>
                        </tr>
                        <!--end::Table row-->
                    </thead>
                    <tbody class="fw-bold text-gray-600">
                        @foreach ($data_klasifikasi as $klasifikasi)
                            <tr class="">
                                <td>
                                    {{ $klasifikasi->kode_klasifikasi }}
                                </td>
                                <td>{{ $klasifikasi->name }}</td>
                                <td data-order="{{ $klasifikasi->updated_at }}">
                                    {{ \Carbon\Carbon::parse($klasifikasi->updated_at)->format('d M Y, H:i LT') }}</td>
                                <td class="">
                                    <a href="#" class="menu-dropdown" data-kt-menu-trigger="click"
                                        data-kt-menu-placement="bottom-end">
                                        <span class="svg-icon svg-icon-5 m-0">
                                            <i data-feather="more-vertical"></i>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </a>
                                    <!--begin::Menu-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4"
                                        data-kt-menu="true"
                                        style="z-index: 105; position: fixed; inset: 0px 0px auto auto; margin: 0px; transform: translate3d(-119px, 245px, 0px);"
                                        data-popper-placement="bottom-end">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3 text-warning" data-bs-toggle="modal"
                                                data-bs-target="#kt_modal_edit_confirm_{{ $klasifikasi->id }}"">Edit</a>
                                                                                        </div>
                                                                                        <!--end::Menu item-->
                                                                                        <!--begin::Menu item-->
                                                                                        <div class="
                                                
                                                           menu-item px-3">
                                                <a href="#" class="menu-link px-3 text-danger" data-bs-toggle="modal"
                                                    data-bs-target="#kt_modal_delete_confirm_{{ $klasifikasi->id }}">Hapus</a>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu-->
                                </td>
                            </tr>
                        @endforeach
                        @foreach ($data_klasifikasi as $klasifikasi)
                            <x-modal id="kt_modal_delete_confirm_{{ $klasifikasi->id }}">
                                <form action="{{ route('klasifikasi.destroy', $klasifikasi->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <h2 class="modal-title">Hapus {{ $klasifikasi->name }}</h2>
                                    <p class="my-4 fs-4 lh-5">Apakah kamu yakin ingin menghapus
                                        <b>[{{ $klasifikasi->kode_klasifikasi }}] {{ $klasifikasi->name }} ?</b>
                                        Jika iya, maka data akan terhapus permanen.
                                    </p>
                                    <div class="text-end">
                                        <button type="button" class="btn btn-sm btn-light"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            Hapus
                                        </button>
                                    </div>
                                </form>
                            </x-modal>
                            <x-modal id="kt_modal_edit_confirm_{{ $klasifikasi->id }}">
                                <form action="{{ route('klasifikasi.update', $klasifikasi) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <h2 class="modal-title">Ubah Klasifikasi</h2>
                                    <div class="form-group">
                                        <label for="">Kode Klasifikasi</label>
                                        <input type="text" name="kode_klasifikasi" class="form-control"
                                            value="{{ $klasifikasi->kode_klasifikasi }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Nama Klasifikasi</label>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ $klasifikasi->name }}" required>
                                    </div>
                                    <div class="text-end">
                                        <button type="button" class="btn btn-sm btn-light"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                    </div>
                                </form>
                            </x-modal>
                        @endforeach

                    </tbody>
                </table>
                <x-modal id="kt_modal_add_klasifikasi">
                    <form action="{{ route('klasifikasi.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <h2 class="modal-title">Tambah Klasifikasi</h2>
                        <div class="form-group">
                            <label for="">Kode Klasifikasi</label>
                            <input type="text" name="kode_klasifikasi" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="">Nama Klasifikasi</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-sm btn-primary">Tambah</button>
                        </div>
                    </form>
                </x-modal>
                <x-modal id="kt_modal_import_klasifikasi">
                    <form action="{{ route('klasifikasi.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <h2 class="modal-title">Import Excel</h2>
                        <p class="my-4 fs-4 lh-5">Menambahkan data dengan jumlah banyak sekaligus dengan mudah.</p>
                        <p class="my-4 fs-4 lh-5">1. Download Contoh File</p>
                        <a href="{{ route('download.sample.klasifikasi') }}" class="btn btn-sm btn-success">Download</a>
                        <p class="my-4 fs-4 lh-5">2. Upload File</p>
                        <small>File dalam bentuk xls, xlsx. Maksimal 2MB</small>
                        <input type="file" class="form-control" name="file_klasifikasi" required>


                        <div class="text-end">
                            <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                        </div>
                    </form>
                </x-modal>
            </div>
        </div>
    </div>
@endsection


@section('add-js')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script>
        "use strict";

        // Class definition
        var KTDatatablesButtons = function() {
            // Shared variables
            var table;
            var datatable;

            // Private functions
            var initDatatable = function() {
                // Set date data order
                const tableRows = table.querySelectorAll('tbody tr');

                tableRows.forEach(row => {
                    const dateRow = row.querySelectorAll('td');
                    const realDate = moment(dateRow[3].innerHTML, "DD MMM YYYY, LT")
                        .format(); // select date from 4th column in table
                    dateRow[3].setAttribute('data-order', realDate);
                });

                // Init datatable --- more info on datatables: https://datatables.net/manual/
                datatable = $(table).DataTable({
                    "info": false,
                    'order': [],
                    'pageLength': 10,
                });
            }


            // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
            var handleSearchDatatable = () => {
                const filterSearch = document.querySelector('[data-kt-filter="search"]');
                filterSearch.addEventListener('keyup', function(e) {
                    datatable.search(e.target.value).draw();
                });
            }

            // Public methods
            return {
                init: function() {
                    table = document.querySelector('#kt_datatable_example_1');

                    if (!table) {
                        return;
                    }

                    initDatatable();
                    handleSearchDatatable();
                }
            };
        }();

        // On document ready
        KTUtil.onDOMContentLoaded(function() {
            KTDatatablesButtons.init();
        });
    </script>
@endsection