<div class="card mb-5 mb-lg-10">
    <div class="card-header">
        <div class="card-title">
            <h3>Riwayat</h3>
        </div>
        <div class="card-toolbar">
            {{-- <div class="my-1 me-4">
                <select class="form-select form-select-sm form-select-solid w-125px select2-hidden-accessible"
                    data-control="select2" data-placeholder="Select Hours" data-hide-search="true"
                    data-select2-id="select2-data-10-w419" tabindex="-1" aria-hidden="true">
                    <option value="1" selected="selected" data-select2-id="select2-data-12-701w">1 Hours</option>
                    <option value="2" data-select2-id="select2-data-128-08pg">6 Hours</option>
                    <option value="3" data-select2-id="select2-data-129-oe4u">12 Hours</option>
                    <option value="4" data-select2-id="select2-data-130-2wwl">24 Hours</option>
                </select>
            </div> --}}
            {{-- <a href="#" class="btn btn-sm btn-primary my-1">Lihat Semua</a> --}}
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-flush align-middle table-row-bordered table-row-solid gy-4 gs-9">
                <thead class="border-gray-200 fs-5 fw-bold bg-lighten">
                    <tr>
                        <th class="min-w-250px">Dari</th>
                        <th class="min-w-100px">Kepada</th>
                        <th class="min-w-150px">Catatan</th>
                        <th class="min-w-150px">Tanggal</th>
                        <th class="min-w-150px">Status</th>
                    </tr>
                </thead>
                <tbody class="fw-6 fw-bold text-gray-600">
                    @foreach ($data_riwayat as $disposisi)
                        <tr>
                            <td>
                                <div class="d-flex flex-column">
                                    <a href="#"" class="text-gray-800 text-hover-primary mb-1">
                                        {{ $disposisi->creator->name ?? ''}}
                                    </a>
                                    <span>{{ $disposisi->creator->divisi->kode ?? '' }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <a href="#" class="text-gray-800 text-hover-primary mb-1">
                                        {{ $disposisi->by->name }}
                                    </a>
                                    <span>{{ $disposisi->by->kode_divisi ?? '' }}</span>
                                </div>
                            </td>
                            <td>
                                {{ $disposisi->catatan }}
                            </td>
                            <td>{{ \Carbon\Carbon::parse($disposisi->created_at)->format('d M Y H:i A') }}
                            </td>
                            <td>
                                @switch($disposisi->status)
                                    @case('DITERIMA')
                                        {!! RiwayatSuratKeluar::DITERIMA !!}
                                    @break
                                    @case('REVISI')
                                        {!! RiwayatSuratKeluar::REVISI !!}
                                    @break
                                    @case('PENDING')
                                        {!! RiwayatSuratKeluar::PENDING !!}
                                    @break
                                    @case('PROSES')
                                        {!! RiwayatSuratKeluar::PROSES !!}
                                    @break
                                    @default
                                        {!! RiwayatSuratKeluar::TERKIRIM !!}
                                @endswitch
                            </td>
                            <td>
                                @if ($disposisi->diteruskan_kepada == auth()->user()->id && $disposisi->status != 'DITERIMA')
                                    <!--begin::Disposisi-->
                                    <button type="button" class="btn btn-sm btn-icon btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_disposisi{{ $disposisi->id }}">
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->

                                        <span class="svg-icon svg-icon-primary svg-icon-2">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M6.39955 13.4982L4.29885 11.2651C3.77365 10.7068 2.88649 10.7068 2.36129 11.2651C1.87957 11.7772 1.87957 12.5757 2.36129 13.0878L6.25387 17.2257C6.64878 17.6455 7.31578 17.6455 7.71058 17.2257L14.6467 9.85249C15.1284 9.34041 15.1284 8.54188 14.6467 8.02981C14.1215 7.47151 13.2343 7.47151 12.7091 8.02981L7.56498 13.4982C7.24908 13.834 6.71548 13.834 6.39955 13.4982Z"
                                                    fill="black" />
                                                <path
                                                    d="M13.3995 13.4982L11.2989 11.2651C10.7737 10.7068 9.88649 10.7068 9.36129 11.2651C8.87957 11.7772 8.87957 12.5757 9.36129 13.0878L13.2539 17.2257C13.6488 17.6455 14.3158 17.6455 14.7106 17.2257L21.6467 9.85249C22.1284 9.34041 22.1284 8.54188 21.6467 8.02981C21.1215 7.47151 20.2343 7.47151 19.7091 8.02981L14.565 13.4982C14.2491 13.834 13.7155 13.834 13.3995 13.4982Z"
                                                    fill="black" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </button>
                                    <!--end::Disposisi-->
                                    <!--begin::Disposisi-->
                                    <button type="button" class="btn btn-sm btn-icon btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_disposisi">
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->

                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M2.5 9.16663L18.3333 1.66663L10.8333 17.5L9.16667 10.8333L2.5 9.16663Z"
                                                stroke="black" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        <!--end::Svg Icon-->
                                    </button>
                                    <!--end::Disposisi-->
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @foreach ($data_riwayat as $disposisi)
        @if ($disposisi->diteruskan_kepada == auth()->user()->id)
            <div class="modal fade" tabindex="-1" id="kt_modal_disposisi{{ $disposisi->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('suratkeluar.update.riwayat', $disposisi->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="d-flex justify-content-between py-5 px-6">
                                <div>
                                    <h2 class="fw-bold">Update Disposisi </h2>
                                </div>

                                <!--begin::Close-->
                                <div class="btn btn-icon btn-sm btn-active-light-dark ms-2" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    <span class="svg-icon svg-icon-1x">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <path opacity="0.3"
                                                d="M6 19.7C5.7 19.7 5.5 19.6 5.3 19.4C4.9 19 4.9 18.4 5.3 18L18 5.3C18.4 4.9 19 4.9 19.4 5.3C19.8 5.7 19.8 6.29999 19.4 6.69999L6.7 19.4C6.5 19.6 6.3 19.7 6 19.7Z"
                                                fill="black" />
                                            <path
                                                d="M18.8 19.7C18.5 19.7 18.3 19.6 18.1 19.4L5.40001 6.69999C5.00001 6.29999 5.00001 5.7 5.40001 5.3C5.80001 4.9 6.40001 4.9 6.80001 5.3L19.5 18C19.9 18.4 19.9 19 19.5 19.4C19.3 19.6 19 19.7 18.8 19.7Z"
                                                fill="black" />
                                        </svg>
                                    </span>
                                </div>
                                <!--end::Close-->
                            </div>

                            <div class="d-grid gap-3 pt-2 pb-5 px-6">
                                <div class="">
                                    <label class="required form-label">Status</label>
                                    <select name="status" class="form-select form-select-solid" data-control="select2"
                                        data-close-on-select="false" data-placeholder="Pilih Status"
                                        data-allow-clear="true">
                                        <option value="DITERIMA">
                                            DITERIMA
                                        </option>
                                        {{-- <option value="REVISI">
                                            REVISI
                                        </option> --}}
                                    </select>
                                </div>
                                {{-- <div class="">
                            <label class="required form-label">Status</label>
                            <input type="text" name="status" class="form-control form-control" required />
                        </div> --}}
                                {{-- <div class="">
                                    <label class="required form-label">Catatan</label>
                                    <input type="text" name="isi_disposisi" class="form-control form-control"
                                        value="{{ $disposisi->isi_disposisi }}" required />
                                </div> --}}
                            </div>

                            <div class="text-end py-5 px-6">
                                <button type="button" class="btn btn-sm btn-light me-1"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-sm btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</div>
