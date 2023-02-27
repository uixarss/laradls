<div class="toolbar" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">

        <!--layout/page-title/_default.blade.php-->
        @include('layout.page-title._default')

        <div class="d-flex align-items-center gap-2 gap-lg-3">
            <a href="?page=" class="btn btn-sm btn-outline btn-outline-primary btn-active-light-primary"
                data-bs-toggle="modal" data-bs-target="#kt_modal_create_app">
                Pendataan Surat
            </a>
            <a href="?page=" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                data-bs-target="#kt_modal_create_app">
                Tulis Surat
            </a>
        </div>
    </div>
</div>
