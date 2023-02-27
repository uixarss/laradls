<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <base href="">
    <title>{{ env('APP_NAME') }}</title>
    <meta charset="utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!--begin::Favicon-->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('/site.webmanifest') }}">
    <meta name="msapplication-config" content="{{ asset('/browserconfig.xml') }}" />
    <meta name="msapplication-TileColor" content="#fff">
    <meta name="theme-color" content="#fff">
    <!--end::Favicon-->

    <!--begin::Plugins Stylesheets(used by this page)-->
    @yield('add-css')
    <!--end::Plugins Stylesheets-->

    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href={{ asset('/assets/css/plugins.bundle.css') }} rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
</head>

<body id="kt_body" class="bg-body">
    <div class="d-flex flex-column flex-root">
        <div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed"
            style="background-image: url({{ asset('assets/media/illustrations/background.png') }})">

            @yield('content')
            <div class="d-flex flex-center flex-column-auto p-10">
                <div class="text-dark order-2 order-md-1 fw-bold">
                    <span class="text-gray-800">
                        Dibuat Oleh
                        <a href="https://aksesdigital.co.id" target="_blank" class="text-gray-800 text-hover-primary">
                            CV Akses Digital
                        </a>
                        © {{ now()->year }}</span>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>

    <!--begin::Plugins Javascript-->
    @yield('add-js')
    <!--end::Plugins Javascript-->
</body>

</html>
