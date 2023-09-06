<x-app-layout>
    <section id="pageContent" class="uk-section" uk-height-viewport="offset-bottom: 20">
        <div class="uk-container">
            <div class="uk-margin-large uk-grid-large" uk-grid>
                {{-- @include('layouts.inc.app-sidebar') --}}
                <x-side-menu />

                <div class="uk-width-3-4@s">
                    <div class="rz-detail-product" id="page-detail-produk">
                        <div uk-grid>
                            <div class="uk-width-2-5@s">
                                <img src="{{ $detail->gambar ?? asset('/storage/tipe-kain/0.jpeg') }}" alt=""
                                    class="uk-border-rounded uk-margin">

                                <div class="uk-child-width-1-3 uk-grid-small" uk-grid uk-lightbox="animation: slide">
                                    <div>
                                        <a class="uk-inline"
                                            href="{{ $detail->gambar ?? url('/storage/tipe-kain/0.jpeg') }}"
                                            data-caption="Caption 1">
                                            <img src="{{ $detail->gambar ?? url('/storage/tipe-kain/0.jpeg') }}"
                                                alt="" class="uk-border-rounded">
                                        </a>
                                    </div>
                                    <div>
                                        <a class="uk-inline"
                                            href="{{ $detail->gambar_2 ?? url('/storage/tipe-kain/0.jpeg') }}"
                                            data-caption="Caption 2">
                                            <img src="{{ $detail->gambar_2 ?? url('/storage/tipe-kain/0.jpeg') }}"
                                                alt="" class="uk-border-rounded">
                                        </a>
                                    </div>
                                    <div>
                                        <a class="uk-inline"
                                            href="{{ $detail->gambar_3 ?? url('/storage/tipe-kain/0.jpeg') }}"
                                            data-caption="Caption 3">
                                            <img src="{{ $detail->gambar_3 ?? url('/storage/tipe-kain/0.jpeg') }}"
                                                alt="" class="uk-border-rounded">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-width-3-5@s">
                                <h3>{{ $detail->nama }}</h3>
                                <ul class="rz-stars">
                                    <li><i class="ph-fill ph-star"></i></li>
                                    <li><i class="ph-fill ph-star"></i></li>
                                    <li><i class="ph-fill ph-star"></i></li>
                                    <li><i class="ph-fill ph-star"></i></li>
                                    <li><i class="ph-fill ph-star"></i></li>
                                </ul>
                                <dl class="rz-detail-product-info">
                                    <dt>{{ $detail->lebar->keterangan }}" / {{ $detail->gramasi->nama }}</dt>
                                    <dd>{{ $detail->warna->keterangan }}</dd>
                                </dl>
                                <div>

                                    <div class="uk-child-width-1-2 uk-grid-collapse uk-flex-middle" uk-grid>
                                        <div>
                                            <div class="uk-grid-small uk-child-width-auto uk-grid">
                                                <input type="hidden" id="idx" value="{{ $detail->id }}">
                                                <label><input class="uk-radio show-price" id="satuan1" value="ECER"
                                                        type="radio" name="radio2" checked>
                                                    {{ $detail->satuan->keterangan }}</label>
                                                <label><input class="uk-radio show-price" id="satuan2" value="ROLL"
                                                        type="radio" name="radio2"> ROLL</label>
                                            </div>
                                            <div class="rz-detail-product-price">
                                                @if (isset($detail->prices[0]))
                                                    Rp. {{ number_format($detail->prices[0]->harga) }}
                                                @else
                                                @endif
                                            </div>
                                        </div>
                                        <div class="uk-text-right">
                                            <a href="#" style="text-decoration: none;">
                                                <i class="ph-light ph-lg ph-heart add-to-wishlist"
                                                    style="font-size: 1.3rem;vertical-align: bottom;margin-right: 10px;"
                                                    data-item-id="{{ $detail->id }}"></i>
                                                <!-- ganti class jadi "ph-fill" ketika wishlist aktif -->
                                            </a>
                                            @if ($detail->jenis_kain_id == 3)
                                                <a href="#modalAddToCartLacoste" data-idx="{{ $detail->id }}"
                                                    class="rz-button add-modal-cart-lacoste" uk-toggle><i
                                                        class="ph-fill ph-lg ph-shopping-cart"></i> Tambah</a>
                                            @else
                                                <a href="#modalAddToCart" data-idx="{{ $detail->id }}"
                                                    class="rz-button add-modal-cart" uk-toggle><i
                                                        class="ph-fill ph-lg ph-shopping-cart"></i> Tambah</a>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="uk-text-meta">
                                        Harga yang tertera masih bersifat estimasi, harga yang sudah fixed akan
                                        diinformasikan pada halaman konfirmasi pesanan
                                    </div>

                                    <hr>

                                </div>
                                <div class="uk-margin-medium">
                                    <h5>Deskripsi</h5>
                                    <p>{{ $detail->deskripsi }}</p>
                                </div>
                                <div class="uk-margin-medium">
                                    <h5>Spesifikasi</h5>
                                    <div class="uk-child-width-1-2@s uk-grid-collapse" uk-grid>
                                        <div>
                                            <table class="rz-table-vertical">
                                                <tr>
                                                    <th>Komposisi</th>
                                                    <td class="uk-text-right">{{ $detail->jenis_kain->nama }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Lebar</th>
                                                    <td class="uk-text-right">{{ $detail->lebar->keterangan }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Gramasi</th>
                                                    <td class="uk-text-right">{{ $detail->gramasi->nama }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Panjang</th>
                                                    <td class="uk-text-right">{{ $detail->panjang }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Karakteristik</th>
                                                    <td class="uk-text-right">{{ $detail->karakteristik }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="rz-product-detail rz-panel uk-margin-medium-top" id="rekomendasi-produk">
                        <h5>Rekomendasi Produk</h5>
                        <div class="uk-child-width-1-4@s uk-child-width-1-2 uk-grid-small" uk-grid>
                            @foreach ($rekom as $rp)
                                <div>
                                    <div class="rz-card-product">
                                        <div class="uk-inline">
                                            <img src="{{ $rp->gambar ?? url('storage/tipe-kain/0.jpeg') }}"
                                                alt="" class="uk-border-rounded">
                                            @if ($detail->jenis_kain_id == 3)
                                                <a href="#modalAddToCartLacoste" data-idx="{{ $rp->id }}"
                                                    uk-toggle class="uk-icon-button add-modal-cart-lacoste"
                                                    uk-icon="cart"></a>
                                            @else
                                                <a href="#modalAddToCart" data-idx="{{ $rp->id }}" uk-toggle
                                                    class="uk-icon-button add-modal-cart" uk-icon="cart"></a>
                                            @endif

                                        </div>

                                        <div class="rz-card-product-detail">
                                            <h5><a
                                                    href="{{ route('shop.detail', [$rp->id, 'category-kain' => Str::slug($rp->nama)]) }}">{{ $rp->nama }}</a>
                                            </h5>
                                            <dl>
                                                <dt>{{ $rp->lebar->keterangan }}" / {{ $rp->gramasi->nama }}</dt>
                                                <dd>{{ $rp->warna->nama }}</dd>
                                            </dl>
                                            <div class="rz-card-product-price">
                                                Rp. {{ number_format($rp->harga_ecer) }}"
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- <div class="uk-child-width-1-4@s uk-child-width-1-2 uk-grid-small" uk-grid id="produk-container">
                    </div> --}}

                </div>
            </div>
        </div>
    </section>

    @include('modal-add-tocart')
    @include('modal-add-tocart-lacoste')

    @push('script')
        <script>
            updateIconWhitelist();

            function updateIconWhitelist() {
                var itemId = $('.add-to-wishlist').data('item-id');
                var icon = $('.add-to-wishlist');
                $.ajax({
                    url: '/get-icon-whitelist',
                    type: 'GET',
                    data: {
                        itemId: itemId
                    },
                    dataType: 'json',
                    success: function(response) {
                        // console.log(response)
                        if (response && response.datas && Array.isArray(response.datas)) {
                            var found = false;
                            for (var i = 0; i < response.datas.length; i++) {
                                var item = response.datas[i];
                                if (item.id == itemId) {
                                    found = true;
                                    if (item.icon === 'ph-light ph-lg ph-heart add-to-wishlist') {
                                        icon.removeClass('ph-light').addClass('ph-fill');
                                    } else {
                                        icon.removeClass('ph-fill').addClass('ph-light');
                                    }
                                    break;
                                }
                            }
                            if (!found) {
                                if (icon == 'ph-light ph-lg ph-heart add-to-wishlist') {
                                    icon.removeClass('ph-light').addClass('ph-fill');
                                } else {
                                    icon.removeClass('ph-fill').addClass('ph-light');
                                }
                            }
                        } else {
                            console.log('Invalid response or missing data array');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }

            $(document).ready(function() {
                $('.show-price').on('click', function() {
                    var selectedValue = $(this).val();
                    var id = $('#idx').val();
                    $.ajax({
                        url: '/get-price',
                        method: 'GET',
                        data: {
                            id: id,
                            satuan: selectedValue
                        },
                        dataType: 'json',
                        success: function(response) {
                            var price = response.price;
                            var priceElement = document.querySelector(".rz-detail-product-price");
                            priceElement.innerHTML = "Rp. " + response.price.toLocaleString();
                            $('#harga_produk').val(response.price);
                        },
                        error: function(error) {
                            // console.log(error);
                        }
                    });

                    // alert(id)
                });

                // add to wishlist
                $(document).ready(function() {
                    $('.add-to-wishlist').click(function(e) {
                        e.preventDefault();
                        var itemId = $(this).data('item-id');
                        var icon = $(this);

                        var iconStatus;
                        if (icon.hasClass('ph-fill')) {
                            iconStatus = 'remove';
                        } else {
                            iconStatus = 'add';
                        }

                        $.ajax({
                            url: '/wishlist',
                            type: 'POST',
                            data: {
                                itemId: itemId,
                                icon: icon.attr('class'),
                                iconStatus: iconStatus
                            },
                            success: function(response) {
                                if (response.success) {
                                    if (iconStatus === 'add') {
                                        icon.removeClass('ph-light').addClass('ph-fill');
                                    } else {
                                        icon.removeClass('ph-fill').addClass('ph-light');
                                    }
                                } else {
                                    notif('warning', 'Whitelist sudah mencapai batas')
                                }
                            },
                            error: function(xhr, status, error) {
                                console.log(error);
                            }
                        });
                    });
                });

                // $(document).on('click', '.add-modal-cart', function() {
                //     var id = $(this).attr('data-idx');
                //     $.ajax({
                //         url: '/get-product-modal',
                //         type: 'GET',
                //         data: {
                //             id: id
                //         },
                //         success: function(data) {
                //             // console.log(data.datas.jenis_kain.id)
                //             var jenis_kain_id = data.datas.jenis_kain.id;
                //             var id_product = data.datas.id;
                //             var nama_kain = data.datas.nama;
                //             var gramasi = data.datas.gramasi.nama;
                //             var lebar = data.datas.lebar.keterangan;
                //             var warna = data.datas.warna.nama;
                //             var harga_product = data.datas.harga_ecer;
                //             var qty_roll = data.datas.qty_roll;
                //             var bagian = data.datas.bagian
                //             var warna_id = data.datas.warna_id;
                //             var satuan_db = data.datas.satuan.keterangan;

                //             let optvalue = "";
                //             let optasc = "";
                //             var info;
                //             $('#satuan-body').empty();
                //             $('#id-accessories').empty();
                //             $('#qty-body').val('');
                //             $('#qty-accessories').val('');
                //             $('#total-qty-body').empty();
                //             $('#total-qty-asc').empty();
                //             $('#total-body').empty();
                //             $('#total-harga-asc').empty();
                //             $('#total-bayar').empty();

                //             optvalue += `<option value="">--PILIH--</option>`;
                //             $.each(data.satuan, function(i2, item2) {
                //                 optvalue +=
                //                     `<option value="ECER">${item2.satuan.keterangan}</option>`;
                //             });
                //             optvalue += `<option value="ROLL">ROLL</option>`;
                //             $('#satuan-body').append(optvalue);


                //             if (!data.asc || data.asc.length === 0) {
                //                 $('.accessories').hide();
                //             } else {
                //                 $('.accessories').show();
                //             }

                //             optasc += `<option value="">--PILIH--</option>`;
                //             $.each(data.asc, function(i, item) {
                //                 info = item.accessories.name.substring(0, 3);
                //                 optasc +=
                //                     `<option value="${item.id}">${item.accessories.name}</option>`;
                //             });
                //             $('#id-accessories').append(optasc);

                //             if (info) {
                //                 if (info === "RIB") {
                //                     $('#info-asesoris').text("Pembelian rib 5% dari pembelian body")
                //                 } else if (info === "BUR") {
                //                     $('#info-asesoris').text(
                //                         "Pembelian bur 20% dari pembelian body")
                //                 } else {
                //                     $('#info-asesoris').text(
                //                         "Pembelian Kerah dan Manset 22% dari pembelian body")
                //                 }
                //             } else {
                //                 $('#info-asesoris').text("Pembelian Kerah dan Manset");
                //             }
                //             if (jenis_kain_id === 3) {
                //                 $('#jenis-kain-nolacoste').hide();
                //                 $('#jenis-kain-lacoste').show();
                //                 $('#info-asesoris-lacoste').text(
                //                     "Pembelian Kerah dan Manset 22% dari pembelian body")
                //             } else {
                //                 $('#jenis-kain-nolacoste').show();
                //                 $('#jenis-kain-lacoste').hide();
                //             }

                //             $('#judulmodal-fo').text(nama_kain)
                //             $('#judullebar-fo').text(lebar)
                //             $('#judulgramasi-fo').text(gramasi)
                //             $('#judulwarna-fo').text(warna)

                //             $('#id-product').val(id_product)
                //             $('#qty-roll').val(qty_roll)
                //             $('#bagian').val(bagian)
                //             $('#warna_id').val(warna_id)
                //             $('#satuan_db').val(satuan_db)
                //         },
                //         error: function(xhr, status, error) {
                //             notif('error', 'Server Error!');
                //         }
                //     })
                // });


            });
        </script>
    @endpush
</x-app-layout>
