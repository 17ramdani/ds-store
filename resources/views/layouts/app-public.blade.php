<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <title>{{ config('app.name', 'Laravel') }}</title> --}}

    <title>Dashboard - Kopkar Indo Liberty</title>
    <meta name="description"
        content="Sistem Informasi Koperasi Karyawan PT Indo Liberty Textiles. JL. RAYA TELUK JAMBE, DESA TELUK JAMBE ,KARAWANG 41361">
    <!-- <link rel="icon" href="assets/img/favicon.ico"> -->

    <!-- OG -->
    <meta property="og:title" content="Dashboard - Kopkar Indo Liberty" />
    <meta property="og:description"
        content="Sistem Informasi Koperasi Karyawan PT Indo Liberty Textiles. JL. RAYA TELUK JAMBE, DESA TELUK JAMBE ,KARAWANG 41361" />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="" />
    <meta property="og:image:secure_url" content="" />

    <!-- STYLES -->
    <script src="https://unpkg.com/phosphor-icons"></script>
    <link rel="stylesheet" href="{{ asset('plugins/uikit/css/uikit.min.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/guest/style.css') }}">
    <!-- Scripts -->
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
</head>

<body>
    @include('layouts.inc.navbar-public')

    <form method="POST" action="{{ route('logout') }}" id="form-logout">
        @csrf
    </form>

    <script src="{{ asset('plugins/uikit/js/uikit.min.js') }}"></script>
    <script src="{{ asset('plugins/uikit/js/uikit-icons.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

    <script>
        function logout() {
            $("#form-logout").submit();
            // console.log('logout');
        }
    </script>
    @stack('js')
    @stack('script')
</body>

</html>
