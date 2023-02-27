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
                    <input type="text" data-kt-kearsipan-table-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Cari Template" />
                </div>
            </div>

            <div class="card-toolbar">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-kearsipan-table-toolbar="base">
                    @if (auth()->user()->can('create-template'))
                    <!--begin::Add Lokasi-->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_tambah">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                        <span class="svg-icon svg-icon-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="black" />
                                <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        Tambah Template Surat
                    </button>
                    <!--end::Add Lokasi-->
                    @endif
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
            <table class="table align-middle border rounded table-row-dashed fs-6 g-5" id="kt_table_kearsipan">
                <thead>
                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase table-light gs-0">
                        <th class="w-10px pe-2">
                            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_table_kearsipan .form-check-input" value="1" />
                            </div>
                        </th>
                        <th class="min-w-125px">Kode</th>
                        <th class="min-w-125px">Nama</th>
                        @if ((auth()->user()->can('edit-template') || (auth()->user()->can('delete-template'))))
                        <th class="text-end"></th>
                        @endif
                    </tr>
                </thead>
                <tbody class="text-gray-600 fw-bold">
                    @foreach ($data_template as $template)
                    <tr>
                        <td>
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td>{{ $template->kode ?? '' }}</td>
                        <td>{{ $template->name ?? '' }}</td>
                        @if ((auth()->user()->can('edit-template') || (auth()->user()->can('delete-template'))))
                        <td class="text-end">
                            @if (auth()->user()->can('update-template'))
                            <a href="#" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_edit_confirm_{{ $template->id }}">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                                <span class="svg-icon svg-icon-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="black"></path>
                                        <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="black"></path>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </a>
                            @endif
                            @if (auth()->user()->can('delete-template'))
                            <!--begin::Menu item-->
                            <a href="#" class="btn btn-sm btn-icon btn-bg-light btn-active-color-danger" data-bs-toggle="modal" data-bs-target="#kt_modal_delete_confirm_{{ $template->id }}">
                                <span class="svg-icon svg-icon-5 m-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor" />
                                        <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor" />
                                        <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor" />
                                    </svg>
                                </span>
                            </a>
                            <!--end::Menu item-->
                            @endif
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!--end::Container-->

<div class="modal fade" tabindex="-1" id="kt_modal_tambah">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('data-master.template.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="d-flex justify-content-between py-5 px-6">
                    <div>
                        <h2 class="fw-bold">Tambah Template</h2>
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
                        <label class="required form-label">Kode Template</label>
                        <input type="text" name="kode" class="form-control form-control" placeholder="SKK" required />
                    </div>

                    <div class="">
                        <label class="required form-label">Nama Template</label>
                        <input type="text" name="name" class="form-control form-control" placeholder="Surat Keterangan Kerja" required />
                    </div>
                    <div class="">
                        <input type="file" name="file_template" class="form-control" required />
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

@foreach($data_template as $template)
@if (auth()->user()->can('update-template'))
<!-- begin::ModalEdit -->
<div class="modal fade" tabindex="-1" id="kt_modal_edit_confirm_{{ $template->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('data-master.template.update', $template->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="d-flex justify-content-between py-5 px-6">
                    <div>
                        <h2 class="fw-bold">Ubah Template</h2>
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
                        <label class="required form-label">Kode Kearsipan</label>
                        <input type="text" name="kode" class="form-control" value="{{ $template->kode }}" required>
                    </div>
                    <div class="">
                        <label class="required form-label">Nama Kearsipan</label>
                        <input type="text" name="name" class="form-control" value="{{ $template->name }}" required>
                    </div>
                </div>

                <div class="text-end py-5 px-6">
                    <button type="button" class="btn btn-sm btn-light me-1" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end::ModalEdit -->
@endif

@if (auth()->user()->can('delete-template'))
<!-- begin::ModalDelete -->
<div class="modal fade" tabindex="-1" id="kt_modal_delete_confirm_{{ $template->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('data-master.template.destroy', $template->id) }}" method="POST">
                @csrf
                @method('delete')
                <div class="d-flex justify-content-between py-5 px-6">
                    <div>
                        <h2 class="fw-bold">Hapus {{ $template->name }}</h2>
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
                        <b>[{{ $template->kode }}] {{ $template->name }} ?</b>
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
@endif
@endforeach

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
                        targets: 3
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