<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <title>{{ config('app.name', 'Laravel') }}</title> --}}

    <title>Dunia Sandang Web Store</title>
    <meta name="description"
        content="Web Based Customer Portal for PT. Dunia Sandang Pratama. PT. Dunia Sandang adalah outlet yang memiliki misi menjadi One Stop Garment Supplier, yaitu outlet yang tidak hanya menyediakan bahan baku dan kelengkapan yang diperlukan oleh garmen dalam satu tempat, tapi juga dapat memberikan kenyamanan dan kemudahan bagi para pelanggan ketika berbelanja.">
    <!-- <link rel="icon" href="assets/img/favicon.ico"> -->

    <!-- OG -->
    <meta property="og:title" content="Dunia Sandang Web Store" />
    <meta property="og:description"
        content="Web Based Customer Portal for PT. Dunia Sandang Pratama. PT. Dunia Sandang adalah outlet yang memiliki misi menjadi One Stop Garment Supplier, yaitu outlet yang tidak hanya menyediakan bahan baku dan kelengkapan yang diperlukan oleh garmen dalam satu tempat, tapi juga dapat memberikan kenyamanan dan kemudahan bagi para pelanggan ketika berbelanja." />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="https://static.coba.dev/duniasandang.03/user/screenshot.png" />
    <meta property="og:image:secure_url" content="https://static.coba.dev/duniasandang.03/user/screenshot.png" />

    <!-- FRAMEWORKS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/uikit@latest/dist/css/uikit.min.css">
    <script src="https://unpkg.com/phosphor-icons"></script>
    <!-- <link rel="stylesheet" href="dataTables.uikit.min.css"> -->
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@200;300;400;600;700&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/guest/style.css') }}">
    <!-- Scripts -->
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
</head>

<body>
    @include('layouts.inc.navbar-public')
    {{ $slot }}

    @include('layouts.inc.footer')

    <script src="https://cdn.jsdelivr.net/npm/uikit@3.16.1/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.16.1/dist/js/uikit-icons.min.js"></script>

</body>

</html>
