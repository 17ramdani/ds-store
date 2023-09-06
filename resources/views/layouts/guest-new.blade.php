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
<style>
    .cart-icon-container {
        position: relative;
        display: inline-block;
    }

    .notification-badge {
        background-color: red;
        color: white;
        font-size: 10px;
        font-weight: bold;
        padding: 2px 6px;
        border-radius: 50%;
        position: absolute;
        top: 20px;
        right: 55px;
    }

    .custom-spin {
        : spin 1s infinite linear;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }

    #pageSidebarTop li > a {
        background-color: #FFF;
        border: 1px solid #FDF2E8;
        border-radius: 5px;
        display: block;
        padding: 10px;
        text-align: center;
    }

    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    .pagination .page-link {
        display: inline-block;
        padding: 8px 16px;
        background-color: #f2f2f2;
        border: 1px solid #ddd;
        color: #333;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .pagination .page-link:hover {
        background-color: #ddd;
    }

    .pagination .page-link.active {
        background-color: #007bff;
        border-color: #007bff;
        color: #fff;
    }

    .uk-margin nav svg {
        max-width: 3%;
    }

    .uk-margin .pagination li span:not(.sr-only) {
        display: none;
    }

    .uk-margin .pagination li a {
        padding: 0.25rem 0.5rem;
    }

</style>
@stack('js')
</head>
<body>
    @include('layouts.inc.navbar-new-public')
    {{ $slot }}
    @include('layouts.inc.footer-new')

    
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

    // =========== PAGIN AJAX =============
    document.addEventListener("DOMContentLoaded", function() {
        const paginationLinks = document.querySelectorAll(".uk-pagination-previous, .uk-pagination-next");
        
        paginationLinks.forEach(link => {
            if (link.href === window.location.href) {
                link.classList.add("uk-active");
            }
        });
    });

    $(document).on('click', '#pag-produk-active nav a', function(event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        // alert(page)
        fetch_data_pagin(page);
    });

    function fetch_data_pagin(page){
        $.ajax({
            url:"/fetch_data_pagin?page="+page,
            success:function(data)
            {
                // console.log(data)
                $('#produk-active').html(data);
            }
        });
    }

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

    $('.tab-link').click(function() {
            $('.tab-link').removeClass('active');
            $(this).addClass('active');
    
            var tipeKainId = $(this).data('id');
            var pecah = tipeKainId.split("-");
            var id = pecah[0];
            var jenis = pecah[1];

            $.ajax({
                url: '/fetch-cards',
                type: 'GET',
                data: { 
                    id: id,
                    jenis: jenis
                },
                success: function(produk) {
                    // console.log(produk)
                    $('#produk-active').hide();
                    $('#pag-produk-active').hide();
                    $('#page-detail-produk').hide();
                    $('#pesanan-index').hide();
                    $('#rekomendasi-produk').hide();
                    $('#page-add-fo').hide(); // PAGE FO
                    $('#page-detail-so').hide();
                    $('#page-cart').hide(); // PAGE CART
                    $('#page-checkout').hide();
                    $('#page-whitelist').hide();
                    $("#produk-container").hide();
                    $('#card-container').html(produk);
                    $('#produk-active').html(produk);
                    
                    // $('#card-container').append(produk);
                    checkActiveTabLink();
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });
        // ============ END DEKTOP  ==================
    
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
                            subKategoriSelect.append('<option value="' + subKategori.nama + '">' + subKategori.nama + '</option>');
                        });
                    }
                });
            }
        });
    
        $('#sub_kategori').on('change', function() {
            let kategori = $("#kategori").val();
            var subKategoriId = $(this).val();
            if (subKategoriId) {
                $.ajax({
                    url: '/get-produk/' + kategori,
                    type: 'GET',
                    data: {
                        subKategoriId: subKategoriId
                    },
                    dataType: 'json',
                    success: function(response) {
                        $('#card-active').hide();
                        $('#pesanan-index').hide();
                        $('#rekomendasi-produk').hide();
                        $('#produk-active').hide();
                        $('#pag-produk-active').hide();
                        var produkContainer = $("#produk-container");
                        // console.log(response)
                        produkContainer.empty();
                        $.each(response, function(index, d) {
                            var randomNumber = Math.floor(Math.random() * (24 - 7 + 1)) + 7;
                            var produkHTML = `
                                <div style="margin-top:15px;">
                                    <div class="rz-card-product">
                                        <div class="uk-inline">
                                            <img src="/tipe-kain/${randomNumber}.jpg" alt="">
                                            <a href="#modalAddToCart" uk-toggle
                                            data-idx="${d.id}" 
                                            data-id-kain="${d.jenis_kain_id}" 
                                            data-kain="${d.nama}"
                                            data-lebar="${d.lebar.keterangan}" 
                                            data-gramasi="${d.gramasi.nama}" 
                                            data-warna="${d.warna.keterangan}" 
                                            data-warna-id="${d.warna.id}" 
                                            data-lebar-id="${d.barang_lebar_id}" 
                                            data-gramasi-id="${d.barang_gramasi_id}" 
                                            data-bagian="${d.bagian}" 
                                            data-harga="${d.harga_ecer}"
                                            class="uk-icon-button add-modal-cart" uk-icon="cart"></a>    
                                        </div>
                                        
                                        <div class="rz-card-product-detail">
                                            <h5><a href="/product-detail/${d.id}">${d.nama}</a></h5>
                                            <dl>
                                                <dt>${d.lebar.keterangan} / ${d.gramasi.nama}</dt>
                                                <dd>${d.warna.keterangan}</dd>
                                            </dl>
                                            <div class="rz-card-product-price">
                                                Rp. ${d.harga_roll}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                            produkContainer.append(produkHTML);
                            console.log(produkHTML)
                        });
                    }
                });
            }
        });
        //  =========== END MOBILE ===================
    });

    $('#qtyBodyModal').on('keyup', function() {
        var satuaBodyModal  = $('#bodySelect').val();
        var jenis_kain_id   = $('#jenis_kainidBodyModal').val();
        var id_prd          = $('#id_produkBodyModal').val();
        var nama_produk     = $('#nama_produkBodyModal').val();
        var qtyBodyModal    = $('#qtyBodyModal').val();
        var total_asc       = $('#total_hargavalueasc').val();
        $.ajax({
            url: '/fetch-product-harga-body',
            type: 'GET',
            data: { 
                satuaBodyModal: satuaBodyModal,
                jenis_kain_id:jenis_kain_id,
                id_prd:id_prd,
                nama_produk:nama_produk,
                qtyBodyModal:qtyBodyModal
            },
            success: function(response) {
                var harga_kg    = response.datas.harga_ecer
                var harga_roll  = response.datas.harga_roll
                if (satuaBodyModal === "KG") {
                    harga = harga_kg
                }else if(satuaBodyModal == "ROLL"){
                    harga = harga_roll * 25
                }else{
                    harga = harga_kg
                }

                var total_body  = harga * qtyBodyModal;
                var total_smt   = parseInt(total_body) + parseInt(total_asc);
                if (!isNaN(total_smt)) {
                    $('#total_hargasm').text('Rp.' + total_smt.toLocaleString())
                    $('#total_harga').val(total_smt)
                }

                $('#total_bodyQty').text(qtyBodyModal + satuaBodyModal);
                $('#total_hargabody').text('Rp '+total_body.toLocaleString());
                $('#total_hargavaluebody').val(total_body);
                $('#harga-pil').val(harga)
            },
            // error: function() {
            //     $('#hargaDisplay').text('Rp. ' + harga);
            // }
        });
    })

    
    $('#qtyAscModal').on('keyup', function() {
        var jenis_kain_id   = $('#jenis_kainidBodyModal').val();
        var id_prdasc       = $('#aksesorisSelect').val();
        var qtyAscModal     = $('#qtyAscModal').val();
        var harga_body      = $('#hargModal').val();
        var total_body      = $('#total_hargavaluebody').val();
        $.ajax({
            url: '/fetch-product-harga-asc',
            type: 'GET',
            data: { 
                jenis_kain_id:jenis_kain_id,
                id_prdasc:id_prdasc,
                qtyAscModal:qtyAscModal
            },
            success: function(response) {
                console.log(harga_body)
                var harga_kg    = response.datas.harga_ecer
                var harga_roll  = response.datas.harga_roll
        //         if (satuaBodyModal === "KG") {
        //             harga = harga_kg
        //         }else if(satuaBodyModal == "ROLL"){
        //             harga = harga_roll
        //         }else{
        //             harga = harga_kg
        //         }
                var total_asc = parseInt(harga_body) + parseInt(harga_kg) * qtyAscModal;
                var total_smt = parseInt(total_asc) + parseInt(total_body);
                // console.log(total_smt)

                if (!isNaN(total_smt)) {
                    $('#total_hargasm').text('Rp' +total_smt.toLocaleString());
                    $('#total_harga').val(total_smt)
                }

                $('#total_ascQty').text(qtyAscModal + 'KG');
                $('#total_hargaasc').text('Rp '+total_asc.toLocaleString());
                $('#total_hargavalueasc').val(total_asc);
                $('#harga-asc').val(harga_kg);
                
            },
        });
    })


    function addToCart() {
        var id_prd          = $('#id_produkBodyModal').val();
        var jenis_kain_id   = $('#jenis_kainidBodyModal').val();
        var satuaBodyModal  = $('#bodySelect').val();
        var nama_produk     = $('#nama_produkBodyModal').val();
        var id_prdasc       = $('#aksesorisSelect').val();
        var qtyBodyModal    = $('#qtyBodyModal').val();
        var qtyAscModal     = $('#qtyAscModal').val();
        var totalHarga      = $('#total_harga').val();
        var warnaModal      = $('#warnaModal').val();
        var namaWarna       = $('#namaWarna').val();
        var lebarModal      = $('#lebarModal').val();
        var gramasiModal    = $('#gramasiModal').val();
        var bagian          = $('#bagian').val();
        var harga           = $('#hargModal').val();
        var harga_pil       = $('#harga-pil').val();
        var harga_asc       = $('#harga-asc').val();
        var addToCartButton = document.getElementById("addToCartButton");
        // addToCartButton.disabled = true;
        // document.getElementById("addToCartText").style.display = "none";
        // document.getElementById("addToCartLoading").style.display = "inline-block";

        if (!qtyBodyModal) {
            notif('error', 'Qty Body tidak boleh kosong!');
        } else{
            $.ajax({
                url: '/add-to-cart-smt',
                type: 'GET',
                data: { 
                    id_produk : id_prd,
                    jenis_kain_id : jenis_kain_id,
                    nama_produk : nama_produk,
                    id_prdasc : id_prdasc,
                    qtyBodyModal : qtyBodyModal,
                    qtyAscModal : qtyAscModal,
                    totalHarga : totalHarga,
                    satuaBodyModal: satuaBodyModal,
                    namaWarna : namaWarna,
                    warnaModal : warnaModal,
                    lebarModal : lebarModal,
                    gramasiModal : gramasiModal,
                    bagian : bagian,
                    harga : harga,
                    harga_pil : harga_pil,
                    harga_asc : harga_asc
                },
                dataType:'json',
                success: function(response) {
                    // console.log(response)
                    // addToCartButton.disabled = false;
                    // document.getElementById("addToCartText").style.display = "inline-block";
                    // document.getElementById("addToCartLoading").style.display = "none";
                        notif('success', 'Barang ditambahkan ke keranjang.');
                        UIkit.modal('#modalAddToCart').hide();
                        updateNotificationBadge();
                        getDataForCartMobile();
                    
                },
                error: function() {
                    // addToCartButton.disabled = false;
                    // document.getElementById("addToCartText").style.display = "inline-block";
                    // document.getElementById("addToCartLoading").style.display = "none";
                    // $('#hargaDisplay').text('Rp. ' + harga);
                    // console.log('error ,' + error)
                    notif('error', 'Server Error!');
                }
            });
        }
    }

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