<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->


    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dunia Sandang Web Store</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/guest/logo-temp-dark4.png') }}">
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.16.19/css/uikit-core.min.css"
        integrity="sha512-DxqvFTWo7OjB0b2D8NR8zf9VkX6uoeFCl6a1i1TfJGSAMiq+EEdSVzBYd3Igcszs0m1Q+oY9of4koU3zdYXq9g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <!-- <link rel="stylesheet" href="dataTables.uikit.min.css"> -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') . '?v=' . date('Hs') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Wix+Madefor+Display:wght@500;600;700&family=Wix+Madefor+Text:wght@400;600&display=swap"
        rel="stylesheet">
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>

    @stack('css')
    @stack('js')
</head>

<body>
    @include('layouts.inc.app-navbar')
    {{ $slot }}
    {{-- @include('layouts.inc.app-footer') --}}
    <x-footer />

    <!-- UIkit JS -->
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.16.1/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.16.1/dist/js/uikit-icons.min.js"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
            },
        });

        $(document).ready(function() {
            // ============ START DEKSTOP ================

            checkActiveTabLink();

            function checkActiveTabLink() {
                var activeTabLink = $('.tab-link.active');

                if (activeTabLink.length > 0) {
                    $('#card-container').show();
                } else {
                    $('#card-container').hide();
                }
            }

            // ============ START MOBILE =================
            $('#kategori').on('change', function() {
                var kategoriId = $(this).val();
                var subKategoriSelect = $('#sub_kategori');
                subKategoriSelect.html('<option value="">--Sub Kategori--</option>');
                if (kategoriId) {
                    $.ajax({
                        url: '/get-subkategori/' + kategoriId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $.each(data, function(index, subKategori) {
                                subKategoriSelect.append('<option value="' + subKategori
                                    .nama + '">' + subKategori.nama + '</option>');
                            });
                        }
                    });
                }
            });

            $('#sub_kategori').on('change', function() {
                var subKategoriId = $(this).val();
                let kategori = $("#kategori").val(),
                    url = "{{ url('shop/') }}/" + kategori +
                    "?category-kain=" + generateSlug(subKategoriId);
                window.location = url;
                // console.log(url);
            });
            //  =========== END MOBILE ===================
        });

        function generateSlug(text) {
            return text.toString().toLowerCase()
                .replace(/^-+/, '')
                .replace(/-+$/, '')
                .replace(/\s+/g, '-')
                .replace(/\-\-+/g, '-')
                .replace(/[^\w\-]+/g, '');
        }
        $(document).on('change', '#satuan-body', function() {
            var satuan_body = $(this).val();
            var id_product = $('#id-product').val();

            var qty_roll = $('#qty-roll').val();
            var selectAsc = document.getElementById("id-accessories");
            var total_bayar = 0;
            $('#qty-body').val('');
            $('#qty-accessories').val('');
            $('#total-qty-body').empty();
            $('#total-qty-asc').empty();
            $('#total-body').empty();
            $('#total-harga-asc').empty();
            $('#total-bayar').empty();
            $('#tot-harga-body').val('');
            $('#tot-harga-asc').val('');
            $('#total-bayar-value').val('');
            $('#satuan-db').val('');
            $('#harga-product').val('')
            $("#use-max-acs").prop("checked", false);
            selectAsc.selectedIndex = 0;
            $('#harga-accessories').val('')
            if (satuan_body.trim() === '') {
                // console.log('Satuan kosong.');
            } else {
                $.ajax({
                    url: '/get-harga-body',
                    type: 'GET',
                    data: {
                        id_product: id_product,
                        satuan_body: satuan_body
                    },
                    success: function(data) {
                        var harga_na = data.prices.harga;
                        var satuan = data.tipe_kain.satuan.keterangan;
                        $('#harga-product').val(harga_na);
                        $('#satuan-db').val(satuan);

                    }

                });
            }
        });

        $(document).on('change', '#id-accessories', function() {
            var id_asc = $(this).val();
            var harga_product = $('#harga-product').val();
            var qty_accessories = $('#qty-accessories').val();
            var satuan_body = $('#satuan-body').val();
            var satuan_db = $('#satuan-db').val();

            var total_hbody = $('#tot-harga-asc').val();

            $.ajax({
                url: '/get-harga-accessories',
                type: 'GET',
                data: {
                    id_asc: id_asc
                },
                success: function(data) {
                    if (satuan_body == "ROLL") {
                        var satuan = satuan_body;
                        var harga_accessories = data.datas.accessories.harga_roll;
                    } else {
                        var satuan = satuan_db;
                        var harga_accessories = data.datas.accessories.harga_ecer;
                    }

                    var total_asc = parseInt(harga_product) + parseInt(harga_accessories);
                    $('#total-harga-asc').text('0')
                    if (qty_accessories) {
                        $('#total-harga-asc').text('Rp ' + total_asc.toLocaleString())
                        var result = total_asc * qty_accessories
                        $('#total-harga-asc').text('Rp ' + result.toLocaleString())
                        $('#tot-harga-asc').val(result)
                        $('#total-qty-asc').text(qty_accessories + satuan);
                    }

                    $('#harga-accessories').val(harga_accessories)


                    // var total_bayar = parseInt(total_hbody) + parseInt(total_asc);
                    // if (!isNaN(total_bayar)) {
                    //     $('#total-bayar').text('Rp. ' + total_bayar.toLocaleString());
                    //     $('#total-bayar-value').val(total_bayar)
                    // }
                }
            });
        });

        $('#qty-body').on('keyup', function() {
            var qty_body = $(this).val();
            var qty_asc = $('#qty-accessories').val();
            var satuan_body = $('#satuan-body').val();
            var satuan_db = $('#satuan-db').val();
            var harga_product = $('#harga-product').val();
            var qty_roll = $('#qty-roll').val();
            var total_hasc = $('#tot-harga-asc').val();
            var checkmax = $('#use-max-acs').prop("checked");
            var harga_accessories = $('#harga-accessories').val();

            var selectElement = document.getElementById("id-accessories");
            var selectedIndex = selectElement.selectedIndex;
            var selectedOption = selectElement.options[selectedIndex];
            var selectedText = selectedOption.text;
            var ambil3karaawal = selectedText.substring(0, 3);

            if (checkmax) {
                var id_bdy = $('#id-product').val();
                var satuan_bdy = $('#satuan-body').val();
                var id_acs = $('#id-accessories').val();
                var harga_bdy = $('#harga-product').val();
                var harga_acs = $('#harga-accessories').val();
                var total_hbody = $('#tot-harga-body').val();
                var qty_bdy = $('#qty-body').val();
                var satuan_db = $('#satuan-db').val();

                var selectElement = document.getElementById("id-accessories");
                var selectedIndex = selectElement.selectedIndex;
                var selectedOption = selectElement.options[selectedIndex];
                var selectedText = selectedOption.text;
                var ambil3karaawal = selectedText.substring(0, 3);

                if (satuan_bdy == "ROLL") {
                    var satuan = satuan_bdy;
                } else {
                    var satuan = satuan_db;
                }

                $.ajax({
                    url: '/use-max-acs',
                    type: "GET",
                    data: {
                        id_bdy: id_bdy,
                        satuan_bdy: satuan_bdy,
                        id_acs: id_acs,
                        qty_bdy: qty_bdy,
                        useMaxAcs: true
                    },
                    success: function(response) {
                        // console.log(response);
                        var result = response.callback
                        var total_asc = parseInt(harga_bdy) + parseInt(harga_acs);
                        var subtotal = total_asc * result

                        if (!isNaN(subtotal)) {
                            $('#total-qty-asc').text(result + satuan);
                            $('#total-harga-asc').text('Rp ' + subtotal.toLocaleString())
                            $('#tot-harga-asc').val(subtotal);
                        }

                        if (satuan_body === "ROLL") {
                            var total_body = qty_body * harga_product * qty_roll
                        } else {
                            var total_body = qty_body * harga_product;
                        }

                        $('#total-qty-body').text(qty_body + satuan);
                        $('#total-body').text('Rp ' + total_body.toLocaleString())
                        $('#tot-harga-body').val(total_body);

                        $('#qty-accessories').val(result)

                        var total_bayar = parseInt(total_body) + parseInt(subtotal);
                        if (!isNaN(total_bayar)) {
                            $('#total-bayar').text('Rp ' + total_bayar.toLocaleString());
                            $('#total-bayar-value').val(total_bayar)
                        }
                    },
                    error: function(xhr) {
                        notif('error', 'Server Error!');
                        console.log(xhr.responseText);
                    }
                });

            } else {
                var qty_max;
                if (ambil3karaawal === "KER") {
                    qty_max = 0
                } else if (ambil3karaawal == "MAN") {
                    qty_max = 0
                } else if (ambil3karaawal == "RIB") {
                    if (satuan_body == "ROLL") {
                        qty_body = qty_body * 25;
                    }
                    var percent = 5 / 100;
                    var divisionResult = qty_asc / qty_body;
                    if (percent < divisionResult) {
                        qty_max = qty_body * percent;
                    } else {
                        qty_max = qty_body * divisionResult;
                    }
                    qty_max = qty_max.toFixed(2)
                } else if (ambil3karaawal == "BUR") {
                    if (satuan_body == "ROLL") {
                        qty_body = qty_body * 25;
                    }
                    var percent = 20 / 100;
                    var divisionResult = qty_asc / qty_body;
                    var qty_max;
                    if (percent < divisionResult) {
                        qty_max = qty_body * percent;
                    } else {
                        qty_max = qty_body * divisionResult;
                    }
                    qty_max = qty_max.toFixed(2)
                }

                if (satuan_body === "ROLL") {
                    var satuan = satuan_body;
                    var total_body = qty_body * harga_product * qty_roll
                } else {
                    var satuan = satuan_db;
                    var total_body = qty_body * harga_product;
                }

                $('#total-qty-body').text(qty_body + ' ' + satuan);
                $('#total-body').text('Rp ' + total_body.toLocaleString())
                $('#tot-harga-body').val(total_body);

                var total_asc = parseInt(harga_product) + parseInt(harga_accessories);
                var result = total_asc * qty_max;

                if (!isNaN(result)) {
                    $('#total-qty-asc').text(qty_asc + ' ' + satuan);
                    $('#total-harga-asc').text('Rp ' + result.toLocaleString())
                    $('#tot-harga-asc').val(result);
                }

                var total_bayar = parseInt(total_body) + parseInt(total_hasc);
                if (!isNaN(total_bayar)) {
                    $('#total-bayar').text('Rp ' + total_bayar.toLocaleString());
                    $('#total-bayar-value').val(total_bayar)
                }
            }
        });

        $('#qty-accessories').on('keyup', function() {
            var qty_asc = $(this).val();
            var qty_bdy = $('#qty-body').val();
            var qty_roll = $('#qty-roll').val();
            var harga_product = $('#harga-product').val();
            var harga_accessories = $('#harga-accessories').val();
            var total_hbody = $('#tot-harga-body').val();
            var satuan_body = $('#satuan-body').val();
            var satuan_db = $('#satuan-db').val();

            var selectElement = document.getElementById("id-accessories");
            var selectedIndex = selectElement.selectedIndex;
            var selectedOption = selectElement.options[selectedIndex];
            var selectedText = selectedOption.text;
            var ambil3karaawal = selectedText.substring(0, 3);

            var qty_max;
            if (ambil3karaawal === "KER") {
                qty_max = 0
            } else if (ambil3karaawal == "MAN") {
                qty_max = 0
            } else if (ambil3karaawal == "RIB") {

                if (satuan_body == "ROLL") {
                    qty_bdy = qty_bdy * 25;
                }
                var percent = 5 / 100;
                var divisionResult = qty_asc / qty_bdy;
                if (percent < divisionResult) {
                    qty_max = qty_bdy * percent;
                } else {
                    qty_max = qty_bdy * divisionResult;
                }
                qty_max = qty_max.toFixed(2)
            } else if (ambil3karaawal == "BUR") {
                if (satuan_body == "ROLL") {
                    qty_bdy = qty_bdy * 25;
                }
                var percent = 20 / 100;
                var divisionResult = qty_asc / qty_bdy;
                var qty_max;
                if (percent < divisionResult) {
                    qty_max = qty_bdy * percent;
                } else {
                    qty_max = qty_bdy * divisionResult;
                }
                qty_max = qty_max.toFixed(2)
            }

            if (satuan_body == "ROLL") {
                var satuan = satuan_body;
            } else {
                var satuan = satuan_db;
            }
            var total_asc = parseInt(harga_product) + parseInt(harga_accessories);
            var result = total_asc * qty_max;

            if (!isNaN(result)) {
                $('#total-qty-asc').text(qty_asc + ' ' + satuan);
                $('#total-harga-asc').text('Rp ' + result.toLocaleString())
                $('#tot-harga-asc').val(result);
            }

            var total_bayar = parseInt(total_hbody) + parseInt(result);
            if (!isNaN(total_bayar)) {
                $('#total-bayar').text('Rp ' + total_bayar.toLocaleString());
                $('#total-bayar-value').val(total_bayar)
            }
        });

        // BTN MAKSIMAL

        $("#use-max-acs-lacoste").on("change", function() {
            let onePcs = 4;
            let max1 = 13.20;
            let max2 = 8.80;
            let accKg = 0;
            let accKg1 = 1 * max1 / onePcs;
            let accKg2 = 1 * max2 / onePcs;
            let stnBody = $('#satuan-body-lacoste').val();
            if (stnBody == "") {
                notif('warning', 'Satuan body belum dipilih!');
                return;
            }
            let qty_roll = parseInt($('#qty-roll-lacoste').val());
            let qtyBody = parseFloat($('#qty-body-lacoste').val());
            let accs = $('input[name="qty_acs[]"]').length;
            let pcs = 0,
                kg = 0;
            if (stnBody == "ROLL") {
                let newQtyBody = qtyBody * qty_roll;
                for (let index = 0; index < accs; index++) {
                    onePcs = 110;
                    let max = parseFloat($('#max-acc-' + index).val());
                    kg = newQtyBody * max / 100;
                    pcs = newQtyBody / qty_roll * onePcs;
                    $('#qty-acc-' + index).val(Math.round(pcs));
                    $('#qty-acc-' + index).attr("max", Math.round(pcs));
                    $('#kg-acc-' + index).val(kg.toFixed(2));
                    $('#qty-acc-' + index).trigger('change');
                }
            } else {
                for (let index = 0; index < accs; index++) {
                    let jenis = $('#qty-acc-' + index).data('jenis');
                    if (jenis == "KER") {
                        accKg = accKg1;
                    } else {
                        accKg = accKg2;
                    }
                    if (qtyBody >= qty_roll) {
                        pcs = qtyBody * onePcs + (Math.floor(qtyBody / qty_roll) * 10);
                    } else {
                        pcs = qtyBody * onePcs;
                    }
                    kg = pcs * accKg;
                    $('#qty-acc-' + index).val(Math.round(pcs));
                    $('#qty-acc-' + index).attr("max", Math.round(pcs));
                    $('#kg-acc-' + index).val(kg.toFixed(2));
                    $('#qty-acc-' + index).trigger('change');
                }
            }
        });

        $("#use-max-acs").on("change", function() {
            var useMaxAcs = $(this).prop("checked");
            if (useMaxAcs) {
                var id_bdy = $('#id-product').val();
                var satuan_bdy = $('#satuan-body').val();
                var id_acs = $('#id-accessories').val();
                var harga_bdy = $('#harga-product').val();
                var harga_acs = $('#harga-accessories').val();
                var total_hbody = $('#tot-harga-body').val();
                var qty_bdy = $('#qty-body').val();
                var satuan_db = $('#satuan-db').val();

                // if(id_bdy)


                var selectElement = document.getElementById("id-accessories");
                var selectedIndex = selectElement.selectedIndex;
                var selectedOption = selectElement.options[selectedIndex];
                var selectedText = selectedOption.text;
                var ambil3karaawal = selectedText.substring(0, 3);

                if (satuan_bdy == "ROLL") {
                    var satuan = satuan_bdy;
                } else {
                    var satuan = satuan_db;
                }

                if (!satuan_bdy || satuan_bdy === "") {
                    notif('warning', 'Pilih satuan body terlebih dahulu!');
                    $(this).prop("checked", false);
                    return;
                }
                if (!qty_bdy || qty_bdy <= 0) {
                    notif('warning', 'Masukkan jumlah qty yang valid!');
                    $(this).prop("checked", false);
                    return;
                }
                if (!id_acs || id_acs <= 0) {
                    notif('warning', 'Pilih accessories terlebih dahulu!');
                    $(this).prop("checked", false);
                    return;
                }
                $.ajax({
                    url: '/use-max-acs',
                    type: "GET",
                    data: {
                        id_bdy: id_bdy,
                        satuan_bdy: satuan_bdy,
                        id_acs: id_acs,
                        qty_bdy: qty_bdy,
                        useMaxAcs: true
                    },
                    success: function(response) {
                        var result = response.callback
                        var total_asc = parseInt(harga_bdy) + parseInt(harga_acs);
                        var subtotal = total_asc * result

                        if (!isNaN(subtotal)) {
                            $('#total-qty-asc').text(result + satuan);
                            $('#total-harga-asc').text('Rp ' + subtotal.toLocaleString())
                            $('#tot-harga-asc').val(subtotal);
                        }

                        $('#qty-accessories').val(result)

                        var total_bayar = parseInt(total_hbody) + parseInt(subtotal);
                        if (!isNaN(total_bayar)) {
                            $('#total-bayar').text('Rp ' + total_bayar.toLocaleString());
                            $('#total-bayar-value').val(total_bayar)
                        }
                    },
                    error: function(xhr) {
                        notif('error', 'Server Error!');
                        console.log(xhr.responseText);
                    }
                });
            }
        });

        // ===================== ADD TO CART ========================
        function storeToCart() {
            var id_product = $('#id-product').val();
            var harga_product = $('#harga-product').val();
            var qty_body = $('#qty-body').val();
            var harga_accessories = $('#harga-accessories').val();
            var qty_roll = $('#qty-roll').val();
            var satuan_body = $('#satuan-body').val();
            var id_accessories = $('#id-accessories').val();
            var qty_accessories = $('#qty-accessories').val();
            var tot_harga_body = $('#tot-harga-body').val();
            var tot_harga_asc = $('#tot-harga-asc').val();
            var total_bayar = $('#total-bayar-value').val();
            var bagian = $('#bagian').val();
            var warna_id = $('#warna_id').val();
            var paket = $('#paket').val();

            if (!satuan_body && !qty_body) {
                notif('error', 'Satuan dan Qty Body tidak boleh kosong!');
            } else if (!satuan_body) {
                notif('error', 'Satuan tidak boleh kosong!');
            } else if (!qty_body) {
                notif('error', 'Qty Body tidak boleh kosong!');
            } else {
                $.ajax({
                    url: '/store-to-cart',
                    type: 'POST',
                    data: {
                        id_body: id_product,
                        harga_body: harga_product,
                        qty_body: qty_body,
                        satuan_body: satuan_body,
                        id_accessories: id_accessories,
                        harga_accessories: harga_accessories,
                        qty_accessories: qty_accessories,
                        qty_roll: qty_roll,
                        bagian: bagian,
                        warna_id: warna_id,
                        paket: paket
                    },
                    dataType: 'json',
                    success: function(response) {
                        // console.log(response)
                        var message = response.message;
                        if (message == "error_max") {
                            notif('warning', 'Qty Accessories melebihi batas maksmial!');
                        } else if (message == "error_paket") {
                            notif('warning', 'Qty Accessories wajin disi!');
                        } else {
                            notif('success', 'Item di berhasil ditambahkan!');
                            UIkit.modal('#modalAddToCart').hide();
                            updateNotificationBadge();
                            // getDataForCartMobile();
                        }

                    },
                    error: function() {
                        notif('error', 'Server Error!');
                    }
                });
            }


        }

        $(document).on('click', '.add-modal-cart-lacoste', function() {
            var id = $(this).attr('data-idx');
            $.ajax({
                url: '/get-product-modal',
                type: 'GET',
                data: {
                    id: id
                },
                success: function(data) {
                    var jenis_kain_id = data.datas.jenis_kain.id;
                    var id_product = data.datas.id;
                    var nama_kain = data.datas.nama;
                    var gramasi = data.datas.gramasi.nama;
                    var lebar = data.datas.lebar.keterangan;
                    var warna = data.datas.warna.nama;
                    var harga_product = data.datas.harga_ecer;
                    var qty_roll = data.datas.qty_roll;
                    var bagian = data.datas.bagian
                    var warna_id = data.datas.warna_id;
                    var satuan_db = data.datas.satuan.keterangan;
                    var paket = data.asc[0].paket;

                    let optvalue = "";
                    $('#satuan-body-lacoste').empty();
                    $('#id-accessories').empty();
                    $('#qty-body').val('');
                    $('#qty-accessories').val('');
                    $('#total-qty-body').empty();
                    $('#total-qty-asc').empty();
                    $('#total-body').empty();
                    $('#total-harga-asc').empty();
                    $('#total-bayar').empty();

                    optvalue += `<option value="">--PILIH--</option>`;
                    $.each(data.satuan, function(i2, item2) {
                        optvalue +=
                            `<option value="ECER">${item2.satuan.keterangan}</option>`;
                    });
                    optvalue += `<option value="ROLL">ROLL</option>`;
                    $('#satuan-body-lacoste').append(optvalue);
                    // alert(paket)
                    let template = ``;
                    let template_acc = ``;
                    $.each(data.asc, function(i, item) {
                        let name_asc = item.accessories.name.substring(0, 3);
                        let harga_ecer = item.accessories.harga_ecer ?? 0;
                        let harga_roll = item.accessories.harga_roll ?? 0;
                        let id_asc = item.id;
                        let wajib = item.paket;
                        template += `<div class="uk-width-1-2">
                                <strong>${item.accessories.name} (pcs)</strong><br>
                                <input type="number" id="qty-acc-${i}" name="qty_acs[]" class="uk-input uk-form-small"
                                    placeholder="pcs" data-jenis="${name_asc}" onchange="hitungKerahManset(this,${i})" max="4">
                                <input type="hidden" id="max-acc-${i}" name="max_acs[]" value="${item.accessories.maks}">
                                <input type="hidden" id="id-acc${i}" name="id_acs[]" value="${item.id}">
                                <input type="hidden" id="harga-acc-${i}" name="harga_acs[]" value="${item.accessories.harga_ecer}">
                                <input type="hidden" id="kg-acc-${i}" name="kg_acs[]" value="0">
                                <input type="hidden" id="subtotal-acc-${i}" name="subtotal_acs[]" value="0">
                            </div>`;
                        template_acc += `<tr>
                                <td>${item.accessories.name}</td>
                                <td class="uk-text-right uk-text-small" id="qty-acc-kg-${i}">0 KG</td>
                                <td class="uk-text-right" id="total-harga-asc-${i}">Rp 0</td>
                            </tr>`;
                        $('#acc-lacoste').html(template);
                        $('#tbody-acc').html(template_acc);
                        if (wajib == 1) {
                            $(`#qty-acc-${i}`).prop('readonly', true);
                        } else {
                            $(`#qty-acc-${i}`).prop('readonly', false);
                        }
                    });

                    $('#judulmodal-fo-lacoste').text(nama_kain)
                    $('#judullebar-fo-lacoste').text(lebar)
                    $('#judulgramasi-fo-lacoste').text(gramasi)
                    $('#judulwarna-fo-lacoste').text(warna)

                    $('#id-product-lacoste').val(id_product)
                    $('#qty-roll-lacoste').val(qty_roll)
                    $('#bagian-lacoste').val(bagian)
                    $('#warna_id-lacoste').val(warna_id)
                    $('#satuan_db-lacoste').val(satuan_db)
                    $('#paket-lacoste').val(paket)
                },
                error: function(xhr, status, error) {
                    notif('error', 'Tidak dapat diproses!. Coba beberapa saat lagi.');
                }
            });
            $('#tot-harga-body-lacoste').val(0);
            $('#total-body-lacoste').text('Rp 0');
            grandTotalCartLacoste();
        });

        function storeToCarLacoste() {
            var id_product = $('#id-product-lacoste').val();
            var harga_product = $('#harga-product-lacoste').val();
            var qty_body = $('#qty-body-lacoste').val();
            var harga_accessories = $('#harga-accessories-lacoste').val();
            var qty_roll = $('#qty-roll-lacoste').val();
            var satuan_body = $('#satuan-body-lacoste').val();
            var id_accessories = $('#id-accessories-lacoste').val();
            var qty_accessories = $('#qty-accessories-lacoste').val();
            var tot_harga_body = $('#tot-harga-body-lacoste').val();
            var tot_harga_asc = $('#tot-harga-asc-lacoste').val();
            var total_bayar = $('#total-bayar-value-lacoste').val();
            var bagian = $('#bagian-lacoste').val();
            var warna_id = $('#warna_id-lacoste').val();
            var paket = $('#paket-lacoste').val();
            var qtyAcs = $('input[name="qty_acs[]"]').map(function() {
                return this.value;
            }).get();
            var idAcs = $('input[name="id_acs[]"]').map(function() {
                return this.value;
            }).get();
            var hargaAcs = $('input[name="harga_acs[]"]').map(function() {
                return this.value;
            }).get();
            var kgAccs = $('input[name="kg_acs[]"]').map(function() {
                return this.value;
            }).get();

            if (!satuan_body && !qty_body) {
                notif('error', 'Satuan dan Qty Body tidak boleh kosong!');
            } else if (!satuan_body) {
                notif('error', 'Satuan tidak boleh kosong!');
            } else if (!qty_body) {
                notif('error', 'Qty Body tidak boleh kosong!');
            } else {
                $.ajax({
                    url: '/store-to-cart-lacoste',
                    type: 'POST',
                    data: {
                        id_body: id_product,
                        harga_body: harga_product,
                        qty_body: qty_body,
                        satuan_body: satuan_body,
                        id_accessories: id_accessories,
                        harga_accessories: harga_accessories,
                        qty_accessories: qty_accessories,
                        qty_roll: qty_roll,
                        bagian: bagian,
                        warna_id: warna_id,
                        paket: paket,
                        'qtyacs[]': qtyAcs,
                        'idacs[]': idAcs,
                        'hargaacs[]': hargaAcs,
                        'kgaccs[]': kgAccs,
                    },
                    dataType: 'json',
                    success: function(response) {
                        // console.log(response)
                        var message = response.message;
                        if (message == "error_max") {
                            notif('warning', 'Qty Accessories melebihi batas maksmial!');
                        } else if (message == "error_paket") {
                            notif('warning', 'Qty Accessories wajin disi!');
                        } else {
                            notif('success', 'Item di berhasil ditambahkan!');
                            UIkit.modal('#modalAddToCartLacoste').hide();
                            updateNotificationBadge();
                            // getDataForCartMobile();
                        }

                    },
                    error: function() {
                        notif('error', 'Server Error!');
                    }
                });
            }
        }
        $(document).on('click', '.add-modal-cart', function() {
            var id = $(this).attr('data-idx');
            // alert(id)

            $.ajax({
                url: '/get-product-modal',
                type: 'GET',
                data: {
                    id: id
                },
                success: function(data) {
                    console.log(data.asc)
                    var jenis_kain_id = data.datas.jenis_kain.id;
                    var id_product = data.datas.id;
                    var nama_kain = data.datas.nama;
                    var gramasi = data.datas.gramasi.nama;
                    var lebar = data.datas.lebar.keterangan;
                    var warna = data.datas.warna.nama;
                    var harga_product = data.datas.harga_ecer;
                    var qty_roll = data.datas.qty_roll;
                    var bagian = data.datas.bagian
                    var warna_id = data.datas.warna_id;
                    var satuan_db = data.datas.satuan.keterangan;
                    // var paket = data.asc[0].paket;
                    var paket = 0;

                    let optvalue = "";
                    let optasc = "";
                    let idlacoste = "";
                    var info;
                    $('#satuan-body').empty();
                    $('#id-accessories').empty();
                    $('#qty-body').val('');
                    $('#qty-accessories').val('');
                    $('#total-qty-body').empty();
                    $('#total-qty-asc').empty();
                    $('#total-body').empty();
                    $('#total-harga-asc').empty();
                    $('#total-bayar').empty();

                    optvalue += `<option value="">--PILIH--</option>`;
                    $.each(data.satuan, function(i2, item2) {
                        if (item2.satuan.keterangan != "ROLL") {
                            optvalue +=
                                `<option value="ECER">${item2.satuan.keterangan}</option>`;
                        }
                    });
                    optvalue += `<option value="ROLL">ROLL</option>`;
                    $('#satuan-body').append(optvalue);


                    if (!data.asc || data.asc.length === 0) {
                        $('.jenis-kain-nolacoste').hide();
                    } else {
                        $('.jenis-kain-nolacoste').show();
                    }

                    optasc += `<option value="">--PILIH--</option>`;
                    $.each(data.asc, function(i, item) {
                        info = item.accessories.name.substring(0, 3);
                        // paket   = item.accessories.paket;
                        optasc +=
                            `<option value="${item.id}">${item.accessories.name}</option>`;
                        idlacoste += item.id
                    });
                    $('#id-accessories').append(optasc);
                    // alert(paket)

                    if (info) {
                        if (info === "RIB") {
                            $('#info-asesoris').text("Pembelian rib 5% dari pembelian body")
                        } else if (info === "BUR") {
                            $('#info-asesoris').text("Pembelian bur 20% dari pembelian body")
                        } else {
                            $('#info-asesoris').text(
                                "Pembelian Kerah dan Manset 22% dari pembelian body")
                        }
                    } else {
                        $('#info-asesoris').text("Pembelian Kerah dan Manset");
                    }
                    if (jenis_kain_id === 3) {
                        $('#jenis-kain-nolacoste').hide();
                        $('#jenis-kain-lacoste').show();
                        var kerah = data.asc[0].id;
                        var manset = data.asc[1].id;
                        // alert(kerah + '=' + manset)
                        $('#pcs_kerah').val(kerah)
                        $('#pcs_manset').val(manset)
                        $('#info-asesoris-lacoste').text(
                            "Pembelian Kerah 13.2% dan Manset 8.8% dari pembelian body")
                    } else {
                        $('#jenis-kain-nolacoste').show();
                        $('#jenis-kain-lacoste').hide();
                    }

                    $('#judulmodal-fo').text(nama_kain)
                    $('#judullebar-fo').text(lebar)
                    $('#judulgramasi-fo').text(gramasi)
                    $('#judulwarna-fo').text(warna)

                    $('#id-product').val(id_product)
                    $('#qty-roll').val(qty_roll)
                    $('#bagian').val(bagian)
                    $('#warna_id').val(warna_id)
                    $('#satuan_db').val(satuan_db)
                    $('#paket').val(paket)
                },
                error: function(xhr, status, error) {
                    notif('error', 'Server Error!');
                }
            })
        });

        function hitungKerahManset(ele, index) {
            let jenis = $(ele).data('jenis');
            let qtyPcs = parseInt($(ele).val());
            let onePcsKerah = 0.033;
            let onePcsManset = 0.022;
            let hargaBody = parseInt($('#harga-product-lacoste').val());
            let hargaAcc = parseInt($('#harga-acc-' + index).val());
            let hargaBodyAcc = hargaBody + hargaAcc;
            let totalHargaBodyAcc = 0;
            let totalHargaBody = parseInt($('#tot-harga-body-lacoste').val());
            let totalhargaBodyAcc = 0;
            let grandTotal = 0;
            let beratKg = 0;
            let attrMax = parseInt($(ele).attr("max"));
            $('#storeToCartButtonLacoste').prop('disabled', false);
            if (qtyPcs > attrMax) {
                notif('warning', 'Jumlah pcs tidak boleh lebih dari ' + attrMax);
                $('#storeToCartButtonLacoste').prop('disabled', true);
                return;
            }
            if (jenis == "KER") {
                beratKg = onePcsKerah * qtyPcs;
                totalHargaBodyAcc = hargaBodyAcc * beratKg;
            }
            if (jenis == "MAN") {
                beratKg = onePcsManset * qtyPcs;
                totalHargaBodyAcc = hargaBodyAcc * beratKg;
            }
            $('#qty-acc-kg-' + index).text(beratKg.toFixed(2) + 'KG');
            $('#kg-acc-' + index).val(beratKg.toFixed(2));
            $('#total-harga-asc-' + index).text('Rp ' + totalHargaBodyAcc.toLocaleString());
            $('#subtotal-acc-' + index).val(totalHargaBodyAcc);
            grandTotalCartLacoste();
        }

        function grandTotalCartLacoste() {
            let subTotalBody = parseInt($('#tot-harga-body-lacoste').val());
            let subTotalAccs = $('input[name="subtotal_acs[]"]');
            let x = 0;
            $('input[name="subtotal_acs[]"]').each(function() {
                x += parseInt($(this).val());
            });
            let total = subTotalBody + x;
            // console.log(x);
            $('#total-bayar-lacoste').text('Rp ' + total.toLocaleString());
        }

        $(document).on('change', '#satuan-body-lacoste', function() {
            var satuan_body = $(this).val();
            var id_product = $('#id-product-lacoste').val();
            var qty_roll = $('#qty-roll').val();
            var selectAsc = document.getElementById("id-accessories");
            var total_bayar = 0;
            $('#qty-body-lacoste').val(0);
            $('#qty-body').val('');
            $('#qty-accessories').val('');
            $('#total-qty-body').empty();
            $('#total-qty-asc').empty();
            $('#total-body').empty();
            $('#total-harga-asc').empty();
            $('#total-bayar').empty();
            $('#tot-harga-body').val('');
            $('#tot-harga-asc').val('');
            $('#total-bayar-value').val('');
            $('#satuan-db').val('');
            $('#harga-product').val('')
            $("#use-max-acs-lacoste").prop("checked", false);
            selectAsc.selectedIndex = 0;
            $('#harga-accessories').val('')
            if (satuan_body.trim() != '') {
                $.ajax({
                    url: '/get-harga-body',
                    type: 'GET',
                    data: {
                        id_product: id_product,
                        satuan_body: satuan_body
                    },
                    success: function(data) {
                        let qtyBody = $('#qty-body-lacoste').val();
                        var harga_na = data.prices.harga;
                        var satuan = data.tipe_kain.satuan.keterangan;
                        let qtyAct = data.tipe_kain.qty_roll;
                        $('#harga-product-lacoste').val(harga_na);
                        $('#satuan-lacoste').val(satuan);
                        $('#satuan-db-lacoste').val(satuan);
                        countingPrice(qtyBody, satuan_body, harga_na, qtyAct, satuan);
                    }
                });
            }
            $('#qty-body-lacoste').trigger('change');
        });

        $('#qty-body-lacoste').on('change keyup', function() {
            var qty_body = $(this).val();
            // var qty_asc         = $('#qty-accessories').val();
            var satuan_body = $('#satuan-body-lacoste').val();
            var satuan_db = $('#satuan-db-lacoste').val();
            var harga_product = $('#harga-product-lacoste').val();
            var qty_roll = $('#qty-roll-lacoste').val();
            var total_hasc = $('#tot-harga-asc').val();
            var checkmax = $('#use-max-acs').prop("checked");
            var harga_accessories = $('#harga-accessories').val();

            if (satuan_body == "ROLL") {
                var satuan = satuan_body;
                var total_body = qty_body * harga_product * qty_roll;
                // $('#storeToCartButtonLacoste').prop('disabled', false);
            } else {
                var satuan = satuan_db;
                var total_body = qty_body * harga_product;
                if (parseFloat(qty_body) >= parseFloat(qty_roll)) {
                    notif('warning', 'Pembelian lebih dari ' + qty_roll + ' kg dianjurkan memilih satuan ROLL');
                    // $('#storeToCartButtonLacoste').prop('disabled', true);
                } else {
                    // $('#storeToCartButtonLacoste').prop('disabled', false);
                }
            }
            // console.log(qty_body)
            $('#total-qty-body-lacoste').text(qty_body + ' ' + satuan);
            $('#total-body-lacoste').text('Rp ' + total_body.toLocaleString())
            $('#tot-harga-body-lacoste').val(total_body);
            $('#use-max-acs-lacoste').trigger('change');
            hitungKerahManset();
        });

        function notif(type, message) {
            Command: toastr[type](message);
            toastr.options = {
                closeButton: true,
                debug: false,
                newestOnTop: false,
                progressBar: true,
                positionClass: "toast-top-right",
                preventDuplicates: false,
                onclick: null,
                showDuration: "300",
                hideDuration: "1000",
                timeOut: "5000",
                extendedTimeOut: "1000",
                showEasing: "swing",
                hideEasing: "linear",
                showMethod: "fadeIn",
                hideMethod: "fadeOut",
            };
        }
    </script>
    @stack('script')
</body>

</html>
