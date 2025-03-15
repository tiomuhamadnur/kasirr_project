<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    @yield('title-head')
    <!-- CSS files -->
    <link href="{{ asset('dist/css/tabler.css') }}" rel="stylesheet" />
    <link href="{{ asset('dist/css/tabler-flags.min.css?1692870487') }}" rel="stylesheet" />
    <link href="{{ asset('dist/css/tabler-payments.min.css?1692870487') }}" rel="stylesheet" />
    <link href="{{ asset('dist/css/tabler-vendors.min.css?1692870487') }}" rel="stylesheet" />
    <link href="{{ asset('dist/css/demo.min.css?1692870487') }}" rel="stylesheet" />
    <link rel="shortcut icon" href="{{ asset('static/favicon.ico') }}">
    {{-- @vite('resources/css/app.css') --}}
    {{-- @vite('resources/sass/app.scss') --}}
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
    </style>
</head>

<body>
    {{-- <script src="{{ asset('dist/js/demo-theme.min.js?1692870487') }}"></script> --}}
    <div class="page">
        <!-- Navbar -->
        @include('layout.navbar')
        <div class="page-wrapper">
            <!-- Page header -->
            @yield('page-header')

            <!-- Page body -->
            <div class="page-body">
                <div class="container-xl">
                    @yield('content')
                </div>
            </div>
            @yield('modal')

            <!-- Page footer -->
            @include('layout.footer')
        </div>
    </div>

    <!-- Page Modal -->
    @include('layout.modal')

    <!-- Libs JS -->
    <script src="{{ asset('dist/libs/list.js/dist/list.min.js?1692870487') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Tabler Core -->
    {{-- <script src="{{ asset('dist/js/tabler.min.js?1692870487') }}" defer></script> --}}
    {{-- <script src="{{ asset('dist/js/demo.min.js?1692870487') }}" defer></script> --}}

    <script src="{{ asset('dist/libs/nouislider/dist/nouislider.min.js?1692870487') }}" defer></script>
    <script src="{{ asset('dist/libs/litepicker/dist/litepicker.js?1692870487') }}" defer></script>
    <script src="{{ asset('dist/libs/tom-select/dist/js/tom-select.base.min.js?1692870487') }}" defer></script>

    <!-- DataTables JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js"></script>
    {{-- <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script> --}}
    @vite('resources/js/app.js')

    @stack('scripts')
    @yield('javascript')

    @include('layout.script')
</body>

</html>
