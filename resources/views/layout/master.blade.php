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
    <meta name="msapplication-TileColor" content="4E9F4F">
    <meta name="theme-color" content="4E9F4F">
    <!--end::Favicon-->

    <script src="{{ mix('js/app.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" />

    {{-- <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js" integrity="sha256-w8CvhFs7iHNVUtnSP0YKEg00p9Ih13rlL9zGqvLdePA=" crossorigin="anonymous"></script>
    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script> --}}
    @stack('scripts')

    <!--begin::Plugins Stylesheets(used by this page)-->
    @yield('add-css')
    <!--end::Plugins Stylesheets-->

    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href={{ asset('/assets/css/plugins.bundle.css') }} rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
</head>


<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed @yield('toolbar') aside-enabled aside-fixed"
    style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
            <!--layout/aside/_base.blade.php-->
            @include('layout.aside._base')
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <!--layout/header/_base.blade.php-->
                @include('layout.header._base')
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--layout/toolbars/_toolbar-1.blade.php-->
                    @yield('toolbars')
                    <div class="post d-flex flex-column-fluid" id="kt_post">
                        <!--layout/_content.blade.php-->
                        @yield('content')
                    </div>
                </div>
                <!--layout/_footer.blade.php-->
                @include('layout._footer')
            </div>
        </div>
    </div>


    <!--partials/_scrolltop.blade.php-->
    @include('partials._scrolltop')

    <script src="{{ asset('assets/js/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    

    <!--begin::Plugins Javascript-->
    @yield('add-js')
    <!--end::Plugins Javascript-->
</body>

</html>
