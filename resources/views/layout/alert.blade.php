@if (session('error'))
    <div class="alert alert-dismissible bg-light-danger d-flex flex-column flex-sm-row p-5">
        <!--begin::Icon-->
        <span class="svg-icon svg-icon-2hx svg-icon-danger me-4 mb-5 mb-sm-0">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10"
                    fill="currentColor" />
                <rect x="11" y="14" width="7" height="2" rx="1"
                    transform="rotate(-90 11 14)" fill="currentColor" />
                <rect x="11" y="17" width="2" height="2" rx="1"
                    transform="rotate(-90 11 17)" fill="currentColor" />
            </svg>
        </span>
        <!--end::Icon-->

        <div class="d-flex flex-column">
            <!--begin::Title-->
            <h4 class="mb-1 text-dark">Error</h4>
            <!--end::Title-->
            <!--begin::Content-->
            <span>{{ session('error') }}</span>
            <!--end::Content-->
        </div>
        <!--begin::Close-->
        <button type="button"
            class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto"
            data-bs-dismiss="alert">
            <span class="svg-icon svg-icon-2x svg-icon-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none">
                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                        transform="rotate(-45 6 17.3137)" fill="currentColor" />
                    <rect x="7.41422" y="6" width="16" height="2" rx="1"
                        transform="rotate(45 7.41422 6)" fill="currentColor" />
                </svg>
            </span>
        </button>
        <!--end::Close-->
    </div>
@endif

@if (session('success'))
    <div class="alert alert-dismissible bg-light-primary d-flex flex-column flex-sm-row p-5">
        <!--begin::Icon-->
        <span class="svg-icon svg-icon-2hx svg-icon-primary me-4 mb-5 mb-sm-0">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                class="text-primary">
                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10"
                    fill="currentColor" />
                <path
                    d="M10.4343 12.4343L8.75 10.75C8.33579 10.3358 7.66421 10.3358 7.25 10.75C6.83579 11.1642 6.83579 11.8358 7.25 12.25L10.2929 15.2929C10.6834 15.6834 11.3166 15.6834 11.7071 15.2929L17.25 9.75C17.6642 9.33579 17.6642 8.66421 17.25 8.25C16.8358 7.83579 16.1642 7.83579 15.75 8.25L11.5657 12.4343C11.2533 12.7467 10.7467 12.7467 10.4343 12.4343Z"
                    fill="currentColor" />
            </svg>
        </span>
        <!--end::Icon-->

        <div class="d-flex flex-column">
            <!--begin::Title-->
            <h4 class="mb-1 text-dark">Berhasil</h4>
            <!--end::Title-->
            <!--begin::Content-->
            <span>{{ session('success') }}</span>
            <!--end::Content-->
        </div>
        <!--begin::Close-->
        <button type="button"
            class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto"
            data-bs-dismiss="alert">
            <span class="svg-icon svg-icon-2x svg-icon-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none">
                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                        transform="rotate(-45 6 17.3137)" fill="currentColor" />
                    <rect x="7.41422" y="6" width="16" height="2" rx="1"
                        transform="rotate(45 7.41422 6)" fill="currentColor" />
                </svg>
            </span>
        </button>
        <!--end::Close-->
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        @foreach ($errors->all() as $val)
            <li>{{ $val }}</li>
        @endforeach
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
