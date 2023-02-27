@extends('layout.master')

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
                    <input type="text" data-kt-user-table-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Cari Pengguna" />
                </div>
            </div>
            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_user">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                        <span class="svg-icon svg-icon-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="black" />
                                <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        Tambah Pengguna
                    </button>
                </div>
                <div class="d-flex justify-content-end align-items-center d-none" data-kt-user-table-toolbar="selected">
                    <div class="fw-bolder me-5">
                        <span class="me-2" data-kt-user-table-select="selected_count"></span>Terpilih
                    </div>
                    <button type="button" class="btn btn-danger" data-kt-user-table-select="delete_selected">
                        Hapus Terpilih
                    </button>
                </div>
            </div>
        </div>

        <div class="card-body pt-0">
            <!--begin::Table-->
            <table class="table align-middle border rounded table-row-dashed fs-6 g-5" id="kt_table_users">
                <thead>
                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase table-light gs-0">
                        <th class="w-10px pe-2">
                            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_table_users .form-check-input" value="1" />
                            </div>
                        </th>
                        <th class="min-w-125px">Pengguna</th>
                        <th class="min-w-125px">NIP</th>
                        <th class="min-w-125px">Divisi</th>
                        <th class="min-w-125px">Joined Date</th>
                        <th class="text-end min-w"></th>
                    </tr>
                </thead>
                <!--begin::Table body-->
                <tbody class="text-gray-600 fw-bold">
                    @foreach ($data_user as $user)
                    <tr>
                        <td>
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td class="d-flex align-items-center">
                            <!--begin:: Avatar -->
                            <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                <a href="{{ url('/') }}">
                                    <div class="symbol-label">
                                        <img src="{{ asset('assets/media/avatars/blank.png') }}" alt="{{ $user->name }}" class="w-100" />
                                    </div>
                                </a>
                            </div>
                            <div class="d-flex flex-column">
                                <a href="{{ url('/') }}" class="text-gray-800 text-hover-primary mb-1">
                                    {{ $user->name }}
                                </a>
                                <span>{{ $user->email }}</span>
                            </div>
                        </td>
                        <td>{{ $user->nip ?? 'Tidak ada NIP' }}</td>
                        <td>{{$user->divisi->name ?? 'N/A'}}</td>
                        <td> {{ \Carbon\Carbon::parse($user->created_at)->format('d M, Y H:i A') }}</td>
                        <td class="text-end">
                            @if ((auth()->user()->can('update-user')) || (auth()->user()->can('delete-user')))
                            <a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
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
                                @if (auth()->user()->can('update-user'))
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#kt_modal_edit_user_{{$user->id}}">Edit</a>
                                </div>
                                <!--end::Menu item-->
                                @endif
                                @if (auth()->user()->can('delete-user'))
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="{{ route('data-master.user-management.pengguna.destroy', $user->id) }}" class="menu-link px-3" {{-- data-kt-users-table-filter="delete_row" --}}>Delete</a>
                                </div>
                                <!--end::Menu item -->
                                @endif
                            </div>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <!--end::Table body-->
            </table>
            <!--end::Table-->
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="kt_modal_add_user">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('data-master.user-management.pengguna.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="d-flex justify-content-between py-5 px-6">
                    <div>
                        <h2 class="fw-bold">Menambah Pengguna </h2>
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
                        <label class="required form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control form-control" required />
                    </div>
                    <div class="">
                        <label class="required form-label">Email</label>
                        <input type="text" name="email" class="form-control form-control" required />
                    </div>
                    <div class="">
                        <label class="required form-label">Divisi</label>
                        <select name="kode_divisi" class="form-select form-select-solid" data-control="select2" data-close-on-select="false" data-placeholder="Select an option" data-allow-clear="true">
                            @foreach ($data_divisi as $divisi)
                            <option value="{{ $divisi->kode }}">
                                {{ $divisi->kode }} | {{ $divisi->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="">
                        <label class="required form-label">Role</label>
                        <select name="role" class="form-select form-select-solid" data-control="select2" data-close-on-select="false" data-placeholder="Select an option" data-allow-clear="true">
                            @foreach ($data_role as $role)
                            <option value="{{ $role->name }}">
                                {{ $role->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="">
                        <label class="required form-label">NIP</label>
                        <input type="text" name="nip" class="form-control form-control" required />
                    </div>
                    <div class="">
                        <label class="required form-label">No HP</label>
                        <input type="text" name="no_hp" class="form-control phone" required />
                    </div>
                    <div class="">
                        <label class="required form-label">Alamat</label>
                        <input type="text" name="address" class="form-control address" />
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

@foreach ($data_user as $user)
@if (auth()->user()->can('update-user'))
<div class="modal fade" tabindex="-1" id="kt_modal_edit_user_{{$user->id}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('data-master.user-management.pengguna.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="d-flex justify-content-between py-5 px-6">
                    <div>
                        <h2 class="fw-bold">Update Profile Pengguna </h2>
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
                        <label class="required form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control form-control" value="{{$user->name}}" required />
                    </div>
                    <div class="">
                        <label class="required form-label">Email</label>
                        <input type="text" name="email" class="form-control form-control" value="{{$user->email}}" readonly />
                    </div>
                    <div class="">
                        <label class="required form-label">Divisi</label>
                        <select name="kode_divisi" class="form-select form-select-solid" data-control="select2" data-close-on-select="false" data-placeholder="Select an option" data-allow-clear="true">
                            @foreach ($data_divisi as $divisi)
                            <option value="{{ $divisi->kode }}" {{($user->kode_divisi == $divisi->kode) ? 'selected' : ''}}>
                                {{ $divisi->kode }} | {{ $divisi->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="">
                        <label class="required form-label">Role</label>
                        <select name="role" class="form-select form-select-solid" data-control="select2" data-close-on-select="false" data-placeholder="Select an option" data-allow-clear="true">
                            @foreach ($data_role as $role)
                            <option value="{{ $role->id }}" {{($user->hasRole($role->name)) ? 'selected' : ''}}>
                                {{ $role->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="">
                        <label class="required form-label">NIP</label>
                        <input type="text" name="nip" class="form-control form-control" value="{{$user->nip ?? ''}}" required />
                    </div>
                    <div class="">
                        <label class="required form-label">No HP</label>
                        <input type="text" name="no_hp" class="form-control phone" value="{{$user->no_hp ?? ''}}" required />
                    </div>
                    <div class="">
                        <label class="required form-label">Alamat</label>
                        <input type="text" name="address" class="form-control address" value="{{$user->address ?? ''}}" required />
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
@endif
@endforeach
<!--end::Container-->
@endsection

@section('add-js')
<script src="{{ asset('assets/plugins/datatables/datatables.bundle.js') }}"></script>
<script>
    "use strict";

    var KTUsersList = function() {
        // Define shared variables
        var table = document.getElementById('kt_table_users');
        var datatable;
        var toolbarBase;
        var toolbarSelected;
        var selectedCount;

        // Private functions
        var initUserTable = function() {
            // Set date data order
            const tableRows = table.querySelectorAll('tbody tr');

            // Init datatable --- more info on datatables: https://datatables.net/manual/
            datatable = $(table).DataTable({
                "info": false,
                'order': [],
                "pageLength": 10,
                "lengthChange": true,
                'columnDefs': [{
                        orderable: false,
                        targets: 0
                    }, // Disable ordering on column 0 (checkbox)
                    {
                        orderable: false,
                        targets: 4
                    }, // Disable ordering on column 6 (actions)
                ]
            });

            // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
            datatable.on('draw', function() {
                initToggleToolbar();
                handleDeleteRows();
                toggleToolbars();
            });
        }

        // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
        var handleSearchDatatable = () => {
            const filterSearch = document.querySelector('[data-kt-user-table-filter="search"]');
            filterSearch.addEventListener('keyup', function(e) {
                datatable.search(e.target.value).draw();
            });
        }

        // Delete subscirption
        var handleDeleteRows = () => {
            // Select all delete buttons
            const deleteButtons = table.querySelectorAll('[data-kt-users-table-filter="delete_row"]');

            deleteButtons.forEach(d => {
                // Delete button on click
                d.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Select parent row
                    const parent = e.target.closest('tr');

                    // Get user name
                    const userName = parent.querySelectorAll('td')[1].querySelectorAll('a')[1]
                        .innerText;

                    // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
                    Swal.fire({
                        text: "Are you sure you want to delete " + userName + "?",
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
                                text: "You have deleted " + userName + "!.",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary",
                                }
                            }).then(function() {
                                // Remove current row
                                datatable.row($(parent)).remove().draw();
                            }).then(function() {
                                // Detect checked checkboxes
                                toggleToolbars();
                            });
                        } else if (result.dismiss === 'cancel') {
                            Swal.fire({
                                text: customerName + " was not deleted.",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary",
                                }
                            });
                        }
                    });
                })
            });
        }

        // Init toggle toolbar
        var initToggleToolbar = () => {
            // Toggle selected action toolbar
            // Select all checkboxes
            const checkboxes = table.querySelectorAll('[type="checkbox"]');

            // Select elements
            toolbarBase = document.querySelector('[data-kt-user-table-toolbar="base"]');
            toolbarSelected = document.querySelector('[data-kt-user-table-toolbar="selected"]');
            selectedCount = document.querySelector('[data-kt-user-table-select="selected_count"]');
            const deleteSelected = document.querySelector('[data-kt-user-table-select="delete_selected"]');

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
                    text: "Are you sure you want to delete selected users?",
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
                            text: "You have deleted all selected users!.",
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary",
                            }
                        }).then(function() {
                            // Remove all selected users
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
                            text: "Selected users was not deleted.",
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

                initUserTable();
                initToggleToolbar();
                handleSearchDatatable();
                handleDeleteRows();
            }
        }
    }();

    // On document ready
    KTUtil.onDOMContentLoaded(function() {
        KTUsersList.init();
    });
</script>
@endsection