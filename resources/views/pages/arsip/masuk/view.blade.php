@extends('layouts.app')

@section('add-css')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('menu')
    <div class="menu-item {{ request()->is('suratmasuk*') ? 'here' : '' }} me-lg-1">
        <span class="menu-link py-3">
            <a href="{{ url('suratmasuk') }}" class="menu-title">Masuk</a>
        </span>
    </div>
    <div class="menu-item {{ request()->is('surat/keluar*') ? 'here' : '' }} me-lg-1">
        <span class="menu-link py-3">
            <a href="{{ url('suratkeluar') }}" class="menu-title">Keluar</a>
        </span>
    </div>
@endsection

@section('content')
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">
        <div class="card card-flush">
            <div class="card-header align-items-center pt-5 pb-0 gap-2 gap-md-5">
                <div class="card-title">
                    <div class="d-flex align-items-center position-relative my-1">
                        <span class="svg-icon svg-icon-1 position-absolute ms-4">
                            <i data-feather="search"></i>
                        </span>
                        <input type="text" data-kt-filter="search" class="form-control form-control-solid w-250px ps-14"
                            placeholder="Search Report" />
                    </div>
                </div>
                <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                    <a href="{{ url('suratmasuk/create') }}" class="btn btn-primary">
                        <span class="svg-icon svg-icon-1">
                            <i data-feather="plus"></i>
                        </span>
                        Tambah Surat Masuk
                    </a>
                </div>
            </div>
            <div class="card-body pt-0">
                <table class="table align-middle border rounded table-row-dashed fs-6 g-5" id="kt_datatable_example_1">
                    <thead>
                        <!--begin::Table row-->
                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase table-light">
                            <th class="min-w">Indeks</th>
                            <th class="min-w">Kode</th>
                            <th class="min-w">Nomor Urut</th>
                            <th class="min-w">Dari</th>
                            <th class="min-w">Pengolah</th>

                            <th class="min-w">Tanggal</th>
                            <th class="min-w">Tanda Terima</th>
                            <th class="min-w">Status</th>
                            <th class="min-w">
                                <span class="svg-icon svg-icon-1">
                                    <i data-feather="more-vertical"></i>
                                </span>
                            </th>
                        </tr>
                        <!--end::Table row-->
                    </thead>
                    <tbody class="fw-bold text-gray-600">
                        @foreach ($data_sm as $sm)
                            <tr class="">
                                <td>
                                    {{-- {{ $sm->indeks->kode_klasifikasi }} -
                                    {{ $sm->indeks->name }} --}}
                                    {{ $sm->nomor ?? '-' }}
                                </td>
                                <td>
                                    {{ $sm->kode->kode_klasifikasi }} -
                                    {{ $sm->kode->name }}
                                </td>
                                <td>{{ $sm->no_agenda }}</td>
                                <td>{{ $sm->nama_pengirim }}</td>
                                <td>{{ $sm->diterima_oleh }}</td>
                                <td data-order="2022-03-10T14:40:00+05:00">
                                    {{ \Carbon\Carbon::parse($sm->created_at)->format('d/m/Y') }}</td>
                                <td>
                                    -
                                </td>
                                <td>
                                    <div class="badge badge-light-success">{{ $sm->status ?? '-' }}</div>
                                </td>
                                <td class="">
                                    <a href="#" class="menu-dropdown" data-kt-menu-trigger="click"
                                        data-kt-menu-placement="bottom-end">
                                        <span class="svg-icon svg-icon-5 m-0">
                                            <i data-feather="more-vertical"></i>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </a>
                                    <!--begin::Menu-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-150px py-4"
                                        data-kt-menu="true"
                                        style="z-index: 105; position: fixed; inset: 0px 0px auto auto; margin: 0px; transform: translate3d(-119px, 245px, 0px);"
                                        data-popper-placement="bottom-end">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="{{ route('suratmasuk.show', $sm->uuid) }}"
                                                class="menu-link px-3">Detail</a>
                                        </div>
                                        <!--end::Menu item-->
                                        
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="{{ route('download.suratmasuk', $sm->id) }}"
                                                class="menu-link px-3">Download</a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="{{ route('suratmasuk.edit', $sm->uuid) }}"
                                                class="menu-link px-3 text-warning">Edit</a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3 text-danger" data-bs-toggle="modal"
                                                data-bs-target="#kt_modal_delete_confirm{{ $sm->id }}">Hapus</a>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu-->
                                </td>
                            </tr>
                        @endforeach
                        @foreach ($data_sm as $sm)
                            <x-modal id="kt_modal_delete_confirm{{ $sm->id }}">
                                <form action="">
                                    <h2 class="modal-title">Hapus Surat Masuk</h2>
                                    <p class="my-4 fs-4 lh-5">Apakah kamu yakin ingin menghapus
                                        <b>{{ $sm->nomor_surat }}?</b>Jika
                                        iya,
                                        maka data akan terhapus permanen.
                                    </p>
                                    <div class="text-end">
                                        <button type="button" class="btn btn-sm btn-light"
                                            data-bs-dismiss="modal">Close</button>
                                        <a href="#" class="btn btn-sm btn-danger">Hapus</a>
                                    </div>
                                </form>
                            </x-modal>
                        @endforeach
                    </tbody>
                </table>
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
