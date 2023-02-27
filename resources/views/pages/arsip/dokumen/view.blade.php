@extends('layout.master')

@section('add-css')
<link href="{{ asset('assets/plugins/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<!--begin::Container-->
<div id="kt_content_container" class="container-xxl">
    @include('layout.alert')
    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <div class="d-flex align-items-center position-relative my-1">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                    <span class="svg-icon svg-icon-1 position-absolute ms-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
                            <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                    <input type="text" data-kt-kearsipan-table-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Cari Dokumen" />
                </div>
            </div>

            <div class="card-toolbar">
                <div class="d-flex justify-content-end gap-3" data-kt-kearsipan-table-toolbar="base">
                    @if (auth()->user()->can('export-dokumen'))
                    <a href="{{route('arsip.export.dokumen')}}" class="btn btn-outline btn-outline-primary btn-active-light-primary">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                        <span class="svg-icon svg-icon-2">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17.5 12.5V15.8333C17.5 16.2754 17.3244 16.6993 17.0118 17.0118C16.6993 17.3244 16.2754 17.5 15.8333 17.5H4.16667C3.72464 17.5 3.30072 17.3244 2.98816 17.0118C2.67559 16.6993 2.5 16.2754 2.5 15.8333V12.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M5.83337 8.33331L10 12.5L14.1667 8.33331" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M10 12.5V2.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        Export Excel
                    </a>
                    @endif
                    @if (auth()->user()->can('import-dokumen'))
                    <button type="button" class="btn btn-outline btn-outline-primary btn-active-light-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_import">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                        <span class="svg-icon svg-icon-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22ZM16 12.6L12.7 9.3C12.3 8.9 11.7 8.9 11.3 9.3L8 12.6H11V18C11 18.6 11.4 19 12 19C12.6 19 13 18.6 13 18V12.6H16Z" fill="black" />
                                <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        Import Excel
                    </button>
                    @endif
                    <a class="btn btn-primary" href="{{ url('arsip/dokumen/create') }}">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                        <span class="svg-icon svg-icon-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="black" />
                                <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        Pendataan Arsip
                    </a>
                </div>

                <div class="d-flex justify-content-end align-items-center d-none" data-kt-kearsipan-table-toolbar="selected">
                    <div class="fw-bolder me-5">
                        <span class="me-2" data-kt-kearsipan-table-select="selected_count"></span>Terpilih
                    </div>
                    <button type="button" class="btn btn-danger" data-kt-kearsipan-table-select="delete_selected">Hapus
                        Terpilih</button>
                </div>
            </div>

        </div>

        <div class="card-body pt-0">
            <table class="table align-middle border rounded table-row-dashed fs-6 g-5" id="kt_table_kearsipan">
                <thead>
                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase table-light gs-0">
                        <th class="w-10px pe-2">
                            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_table_kearsipan .form-check-input" value="1" />
                            </div>
                        </th>
                        <td>No. Berkas</td>
                        <th class="min-w">Klasifikasi</th>
                        <th class="min-w">Perihal</th>
                        <th class="min-w">Kurun Waktu</th>
                        <th class="min-w">Pengelola</th>
                        <th class="text-end"></th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 fw-bold">
                    @foreach ($data_document as $document)
                    <tr>
                        <td>
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td>{{ $document->nomor_berkas }}</td>
                        <td>{{ $document->klasifikasi->name ?? '' }}</td>
                        <td>
                            {{ $document->title }} <br>
                            @if ($document->location_file == null)
                            <span class="text-gray-600 text-hover-primary mb-1 badge badge-warning">

                                tidak ada file.</span>
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($document->published_at)->format('Y') }}</td>
                        <td>{{ $document->author }}</td>
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
                                @if (auth()->user()->can('print-dokumen'))
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3">Cetak</a>
                                </div>
                                <!--end::Menu item-->
                                @endif
                                @if (auth()->user()->can('show-dokumen'))
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="{{ route('arsip.dokumen.show', $document->uuid) }}" class="menu-link px-3">Detail</a>
                                </div>
                                <!--end::Menu item-->
                                @endif
                                @if (auth()->user()->can('download-dokumen'))
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="{{ route('arsip.dokumen.download', ['uuid' => $document->uuid]) }}" class="menu-link px-3">Download</a>
                                </div>
                                <!--end::Menu item-->
                                @endif
                                @if (auth()->user()->can('delete-dokumen'))
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="{{route('arsip.dokumen.remove', $document->uuid)}}" class="menu-link px-3 text-danger">Hapus</a>
                                </div>
                                <!--end::Menu item-->
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!--end::Container-->

<div class="modal fade" tabindex="-1" id="kt_modal_import">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('arsip.dokumen.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="d-flex justify-content-between py-5 px-6">
                    <div>
                        <h2 class="fw-bold">Import Excel</h2>
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

                <div class="d-grid gap-5 pt-2 pb-5 px-6">
                    <div>
                        <h3>1. Download Contoh File</h3>
                        <div class="d-grid gap-1">
                            <label class="form-label gray-600">Tekan Tombol Download dibawah untuk mendapatakan contoh
                                file</label>
                            <a href="{{ route('arsip.download.sample.dokumen') }}" class="btn btn-light-primary">Download</a>
                        </div>
                    </div>
                    <div>
                        <h3>2. Upload File</h3>
                        <div class="">
                            <label class="form-label gray-600">File dalam format .xls, atau .xlsx. Maks. 2
                                MB</label>
                            <input type="file" class="form-control" name="document_file" required />
                        </div>
                    </div>
                </div>

                <div class="text-end py-5 px-6">
                    <button type="button" class="btn btn-sm btn-light me-1" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('add-js')
<script src="{{ asset('assets/plugins/datatables/datatables.bundle.js') }}"></script>
<script>
    "use strict";

    var KTkearsipanList = function() {
        // Define shared variables
        var table = document.getElementById('kt_table_kearsipan');
        var datatable;
        var toolbarBase;
        var toolbarSelected;
        var selectedCount;

        // Private functions
        var initkearsipanTable = function() {
            // Set date data order
            const tableRows = table.querySelectorAll('tbody tr');

            tableRows.forEach(row => {});

            // Init datatable --- more info on datatables: https://datatables.net/manual/
            datatable = $(table).DataTable({
                "info": false,
                'order': [],
                "pageLength": 10,
                "lengthChange": false,
                'columnDefs': [{
                        orderable: false,
                        targets: 0
                    }, // Disable ordering on column 0 (checkbox)
                    {
                        orderable: false,
                        targets: 6
                    }, // Disable ordering on column 3 (actions)
                ]
            });

            // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
            datatable.on('draw', function() {
                initToggleToolbar();
                toggleToolbars();
            });
        }

        // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
        var handleSearchDatatable = () => {
            const filterSearch = document.querySelector('[data-kt-kearsipan-table-filter="search"]');
            filterSearch.addEventListener('keyup', function(e) {
                datatable.search(e.target.value).draw();
            });
        }

        // Init toggle toolbar
        var initToggleToolbar = () => {
            // Toggle selected action toolbar
            // Select all checkboxes
            const checkboxes = table.querySelectorAll('[type="checkbox"]');

            // Select elements
            toolbarBase = document.querySelector('[data-kt-kearsipan-table-toolbar="base"]');
            toolbarSelected = document.querySelector('[data-kt-kearsipan-table-toolbar="selected"]');
            selectedCount = document.querySelector('[data-kt-kearsipan-table-select="selected_count"]');
            const deleteSelected = document.querySelector('[data-kt-kearsipan-table-select="delete_selected"]');

            // Toggle delete selected toolbar
            checkboxes.forEach(c => {
                // Checkbox on click event
                c.addEventListener('click', function() {
                    setTimeout(function() {
                        toggleToolbars();
                    }, 50);
                });
            });

            // Deleted selected rows
            deleteSelected.addEventListener('click', function() {
                // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
                Swal.fire({
                    text: "Are you sure you want to delete selected kearsipan?",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "Yes, delete!",
                    cancelButtonText: "No, cancel",
                    customClass: {
                        confirmButton: "btn fw-bold btn-danger",
                        cancelButton: "btn fw-bold btn-active-light-primary"
                    }
                }).then(function(result) {
                    if (result.value) {
                        Swal.fire({
                            text: "You have deleted all selected kearsipan!.",
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary",
                            }
                        }).then(function() {
                            // Remove all selected kearsipan
                            checkboxes.forEach(c => {
                                if (c.checked) {
                                    datatable.row($(c.closest('tbody tr')))
                                        .remove().draw();
                                }
                            });

                            // Remove header checked box
                            const headerCheckbox = table.querySelectorAll(
                                '[type="checkbox"]')[0];
                            headerCheckbox.checked = false;
                        }).then(function() {
                            toggleToolbars(); // Detect checked checkboxes
                            initToggleToolbar
                                (); // Re-init toolbar to recalculate checkboxes
                        });
                    } else if (result.dismiss === 'cancel') {
                        Swal.fire({
                            text: "Selected kearsipan was not deleted.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary",
                            }
                        });
                    }
                });
            });
        }

        // Toggle toolbars
        const toggleToolbars = () => {
            // Select refreshed checkbox DOM elements
            const allCheckboxes = table.querySelectorAll('tbody [type="checkbox"]');

            // Detect checkboxes state & count
            let checkedState = false;
            let count = 0;

            // Count checked boxes
            allCheckboxes.forEach(c => {
                if (c.checked) {
                    checkedState = true;
                    count++;
                }
            });

            // Toggle toolbars
            if (checkedState) {
                selectedCount.innerHTML = count;
                toolbarBase.classList.add('d-none');
                toolbarSelected.classList.remove('d-none');
            } else {
                toolbarBase.classList.remove('d-none');
                toolbarSelected.classList.add('d-none');
            }
        }

        return {
            // Public functions
            init: function() {
                if (!table) {
                    return;
                }

                initkearsipanTable();
                initToggleToolbar();
                handleSearchDatatable();
            }
        }
    }();

    // On document ready
    KTUtil.onDOMContentLoaded(function() {
        KTkearsipanList.init();
    });
</script>
@endsection