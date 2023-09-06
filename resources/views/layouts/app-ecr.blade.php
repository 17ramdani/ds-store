<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<!-- Global site tag (gtag.js) - Google Analytics -->


<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Dunia Sandang Web Store</title>
<link rel="shortcut icon" href="{{ asset('assets/img/guest/logo-temp-dark4.png')}}">
<meta name="description" content="Web Based Customer Portal for PT. Dunia Sandang Pratama. PT. Dunia Sandang adalah outlet yang memiliki misi menjadi One Stop Garment Supplier, yaitu outlet yang tidak hanya menyediakan bahan baku dan kelengkapan yang diperlukan oleh garmen dalam satu tempat, tapi juga dapat memberikan kenyamanan dan kemudahan bagi para pelanggan ketika berbelanja.">
<!-- <link rel="icon" href="assets/img/favicon.ico"> -->

<!-- OG -->
<meta property="og:title" content="Dunia Sandang Web Store" />
<meta property="og:description" content="Web Based Customer Portal for PT. Dunia Sandang Pratama. PT. Dunia Sandang adalah outlet yang memiliki misi menjadi One Stop Garment Supplier, yaitu outlet yang tidak hanya menyediakan bahan baku dan kelengkapan yang diperlukan oleh garmen dalam satu tempat, tapi juga dapat memberikan kenyamanan dan kemudahan bagi para pelanggan ketika berbelanja." />
<meta property="og:type" content="website" />
<meta property="og:image" content="https://static.coba.dev/duniasandang.03/user/screenshot.png" />
<meta property="og:image:secure_url" content="https://static.coba.dev/duniasandang.03/user/screenshot.png" />

<!-- FRAMEWORKS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.16.19/css/uikit-core.min.css" integrity="sha512-DxqvFTWo7OjB0b2D8NR8zf9VkX6uoeFCl6a1i1TfJGSAMiq+EEdSVzBYd3Igcszs0m1Q+oY9of4koU3zdYXq9g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://unpkg.com/@phosphor-icons/web"></script>
<!-- <link rel="stylesheet" href="dataTables.uikit.min.css"> -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Wix+Madefor+Display:wght@500;600;700&family=Wix+Madefor+Text:wght@400;600&display=swap" rel="stylesheet">
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>

@stack('css')
@stack('js')
@livewireStyles
</head>
<body>
    @include('layouts.inc.app-navbar')
    {{ $slot }}
    @include('layouts.inc.app-footer')

    <!-- UIkit JS -->
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.16.1/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.16.1/dist/js/uikit-icons.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
    <script>
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    </script>
    @stack('script')
    @livewireScripts
</body>
</html>