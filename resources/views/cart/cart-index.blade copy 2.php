<x-app-layout>
    <section id="pageContent" class="uk-section" uk-height-viewport="offset-bottom: 20">
        <div class="uk-container">
            <div class="uk-margin-large uk-grid-large" uk-grid>
                @include('layouts.inc.app-sidebar')
                <!-- Contains uk-width-1-4@s. Don't screw up! -->
                <div class="uk-width-3-4@s">
            
                    <div class="rz-detail-product" id="page-cart">
                        <div uk-grid>
                            <div class="uk-width-2-5@s">
                                <h3><i class="ph-light ph-shopping-cart rz-icon"></i>Cart</h3>
                            </div>
                            <div class="uk-width-3-5@s">
                                <div class="rz-cart-container">
                                    <div class="uk-flex uk-flex-between">
                                        <div>
                                            <h5>Rincian Pembelian</h5>
                                        </div>
                                        <div>
                                            <a href="/shop" class="uk-flex uk-flex-middle"><span class="uk-margin-small-right" uk-icon="icon: plus; ratio: 0.75"></span> Item</a>    
                                        </div>
                                    </div>

                                    <form action="/checkout-cart" method="POST">
                                        @csrf
                                        <article>
                                            @if($cartdata && count($cartdata) != 0)
                                                @php
                                                    $total_smt = 0;
                                                @endphp
                                                @foreach ($cartdata as $i => $item)
                                                @php
                                                    $tipekain_id  = $item['tipe_kain_id'];
                                                    $bagian       = $item['bagian'];
                                                    $satuan       = $item['satuan'];
                                                    $qty          = $item['qty'];
                                                    $id_keranjang = isset($item['id']) ? $item['id'] : '0';
                                                    
                                                    $warnKain           = '';
                                                    $harga_acs          = 0;
                                                    $namaAccessories    = '';
                                                    $stnKain            = '';
                                                    $harga_body         = 0;
                                                    $jenisKain          = '';
                                                    $namaKain           = '';

                                                    if(isset($tipekain)){
                                                        foreach ($tipekain as $data) {
                                                            $namaKain   = $data['nama'] ?? '';
                                                            $jenisKain  = $data['jenis_kain']['nama'] ?? '';
                                                            $warnKain   = $data['warna']['nama'] ?? '';
                                                            $stnKain    = $data['satuan']['keterangan'] ?? '';
                                                            $qtyRoll    = $data['qty_roll'] ?? 0;
                                                        }
                                                    }

                                                    if(isset($data['tipekainacs'])){
                                                        foreach ($data['tipekainacs'] as $acs) {
                                                                $namaAccessories = $acs['accessories']['name'] ?? '';
                                                                if($satuan == "ROLL"){
                                                                    $harga_acs  = $acs['accessories']['harga_roll'] ?? 0;
                                                                }else{
                                                                    $harga_acs  = $acs['accessories']['harga_ecer'] ?? 0;
                                                                }
                                                        }
                                                    }
                                                    
                                                    if(isset($data['prices'])){
                                                        foreach ($data['prices'] as $hrg) {
                                                            $harga_body  = $hrg['harga'] ?? 0;
                                                        }
                                                    }

                                                    if (isset($item['qty_roll'])){
                                                        $qty_roll = $item['qty_roll'];
                                                    }else{
                                                        $qty_roll = $qtyRoll;
                                                    }
                                                    if($satuan == "ROLL"){
                                                        $satuanKain        = $satuan;
                                                        $harga_na           = $harga_body * $qty * $qty_roll;
                                                    }else{
                                                        $satuanKain        = $stnKain;
                                                        $harga_na          = $harga_body * $qty;
                                                    }
                                                    
                                                    if($bagian == "accessories"){
                                                        $totalasc = $harga_body + $harga_acs;
                                                        $subtotal = $totalasc * $qty;
                                                    }else{
                                                        $subtotal = $harga_na;
                                                    }
                                                    @endphp
                                                    {{-- <input type="text" name="id[]" value="{{ $tipekain_id }}" class="uk-input uk-form-small"> --}}
                                                            
                                                    @if($bagian == "body")
                                                    <div class="rz-cart-item">
                                                        <dl>
                                                            <dt>{{ $jenisKain }}</dt>
                                                            <dd>{{ $namaKain }} - {{ $warnKain }}</dd>
                                                        </dl>
                                                        <div class="uk-grid-small" uk-grid>
                                                            <div class="uk-width-1-5">
                                                                <input type="number" name="qty[]" value="{{ $item['qty'] }}" id="qty-{{ $tipekain_id }}" onkeyup="hitungTotal({{ $tipekain_id }})" class="uk-input uk-form-small" placeholder="30">
                                                                <input type="hidden" name="id_keranjang[]" value="{{ $id_keranjang }}" class="uk-input uk-form-small" placeholder="">
                                                                <input type="hidden" name="satuan[]" value="{{ $satuan }}" class="uk-input uk-form-small">
                                                                <input type="hidden" name="bagian[]" value="{{ $bagian }}" class="uk-input uk-form-small">
                                                                <input type="hidden" name="id[]" value="{{ $tipekain_id }}" class="uk-input uk-form-small">
                                                            </div>
                                                            <div class="uk-width-auto">
                                                                {{ $satuanKain }}
                                                            </div>
                                                            <div class="uk-width-expand">
                                                                <ul>
                                                                    <li>
                                                                        <a href="" id="delete-{{ $tipekain_id }}" class="delete-item" data-id="{{ $tipekain_id }}" style="text-decoration: none;font-size:20px;color:#808080;">
                                                                            <i class="ph ph-trash"></i>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="" style="text-decoration: none;font-size:20px;color:#808080;">
                                                                            <i class="ph-light ph-lg ph-heart add-to-wishlist" data-item-id="{{ $tipekain_id }}"></i>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="uk-width-2-5 uk-text-right uk-text-bold">
                                                                {{-- Rp. {{ number_format($item['subtotal']) }} --}}
                                                                Rp. {{ number_format($subtotal) }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @else
                                                    <div class="rz-cart-item">
                                                        <dl>
                                                            <dt>{{ $namaAccessories }}</dt>
                                                            <dd>{{ $warnKain }}</dd>
                                                        </dl>
                                                        <div class="uk-grid-small" uk-grid>
                                                            <div class="uk-width-1-5">
                                                                <input type="hidden" name="qty1[]" value="{{ $item['qty'] }}" id="qty-{{ $tipekain_id }}" onkeyup="hitungTotal({{ $tipekain_id }})" class="uk-input uk-form-small" placeholder="30">
                                                                <input type="number" name="qty[]" value="{{ $qty }}" id="qty-{{ $tipekain_id }}" onkeyup="hitungTotal({{ $tipekain_id }})" class="uk-input uk-form-small" placeholder="30">
                                                                <input type="hidden" name="id_keranjang[]" value="{{ $id_keranjang }}" class="uk-input uk-form-small" placeholder="">
                                                                <input type="hidden" name="id[]" value="{{ $tipekain_id }}" class="uk-input uk-form-small">
                                                            </div>
                                                            <div class="uk-width-auto">
                                                                {{ $satuanKain }}
                                                            </div>
                                                            <div class="uk-width-expand">
                                                                <ul>
                                                                    <li>
                                                                        <a href="" id="delete-{{ $tipekain_id }}" class="delete-item" data-id="{{ $tipekain_id }}" style="text-decoration: none;font-size:20px;color:#808080;">
                                                                            <i class="ph ph-trash"></i>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="" style="text-decoration: none;font-size:20px;color:#808080;">
                                                                            <i class="ph-light ph-lg ph-heart add-to-wishlist" data-item-id="{{ $tipekain_id }}"></i>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="uk-width-2-5 uk-text-right uk-text-bold">
                                                                {{-- Rp. {{ number_format($item['subtotal']) }} --}}
                                                                Rp. {{ number_format($subtotal) }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                
                                                @endforeach

                                                    {{-- <article class="rz-values-horizontal uk-text-small">
                                                        <dl>
                                                            <dt>Subtotal</dt>
                                                            <dd id="total-harga-sub-all">Rp. {{ number_format($total_smt) }}</dd>
                                                        </dl>
                                                        <dl>
                                                            <dt>Diskon</dt>
                                                            <dd>Rp. 0</dd>
                                                        </dl>
                                                        <dl>
                                                            <dt>Ongkos Kirim</dt>
                                                            <dd>Rp. 0</dd>
                                                        </dl>
                                                        <hr>
                                                        <dl>
                                                            <dt>TOTAL</dt>
                                                            <dd class="uk-text-bold" id="total-harga-all">Rp. {{ number_format($total_smt) }}</dd>
                                                        </dl>
                                                    </article> --}}
                                    
                                                    <div class="uk-margin-top uk-align-right@s">
                                                        <a href="/shop" class="uk-button uk-button-default">Tambah Item</a>
                                                        <button type="submit" class="uk-button uk-button-primary">Checkout</button>
                                                    </div>
                                            @else
                                            
                                                {{-- <img class="uk-height-medium uk-flex uk-flex-center" src="{{ asset('assets/img/empty.png') }}" alt="" uk-img> --}}
                                                <div class="uk-alert-warning" uk-alert>
                                                    {{-- <a class="uk-alert-close" uk-close></a> --}}
                                                    <p class="uk-text-center">Keranjang masih kosong.</p>
                                                </div>
                                            @endif
                                        </article>

                                    </form>
                                    
                                    
                                </div>
    
                            </div>
                        </div>
    
                    </div>

                    <div class="uk-child-width-1-4@s uk-child-width-1-2 uk-grid-small" uk-grid id="produk-container">
                
                    </div>
                    
                </div>          
            </div>
        </div>
    </section>
    @include('modal-add-tocart')
    @push('script')
    <script>
        updateIconWhitelistCart();
        function updateIconWhitelistCart() {
            var icons = $('.add-to-wishlist');
            icons.each(function(index, element) {
                var itemId  = $(element).data('item-id');
                var icon    = $(element);

                $.ajax({
                    url: '/get-icon-whitelist-cart',
                    type: 'GET',
                    data: {
                        itemId: itemId
                    },
                dataType: 'json',
                success: function(response) {
                    if (response && response.datas && Array.isArray(response.datas)) {
                    response.datas.forEach(function(item) {
                        if (item.id == itemId) {
                        if (item.icon === 'ph-light ph-lg ph-heart add-to-wishlist') {
                            icon.removeClass('ph-light').addClass('ph-fill');
                        } else {
                            icon.removeClass('ph-fill').addClass('ph-light');
                        }
                        }
                    });
                    } else {
                    console.log('Invalid response or missing data array');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
                });
            });
        }


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
                // console.log(iconStatus)
                $.ajax({
                        url: '/whitelist-cart-new',
                        type: 'POST',
                        data: {
                            itemId: itemId,
                            icon: icon.attr('class'),
                            iconStatus:iconStatus
                        },
                        success: function(response) {
                            console.log(response.message)
                            if (response.success) {
                                if (iconStatus === 'add') {
                                    icon.removeClass('ph-light').addClass('ph-fill');
                                    // alert(1)
                                } else {
                                    icon.removeClass('ph-fill').addClass('ph-light');
                                }
                            } else {
                                notif('warning',response.message)
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        }
                    });
                })
            })

        $(document).ready(function() {
            $('.delete-item').on('click', function(event) {
                event.preventDefault();

                const tipekainId = $(this).data('id');
                $.ajax({
                    url: '/delete-item', 
                    type: 'POST',
                    data: {
                        item_id: tipekainId,
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        // console.log(response)
                        notif('success', 'Item berhasil di hapus!');
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });

            })
        });

        $(document).ready(function() {
            $(document).on('click', '.add-modal-cart', function() {
                var id  = $(this).attr('data-idx');
                $.ajax({
                    url: '/get-product-modal',
                    type: 'GET',
                    data: {
                        id: id
                    },
                    success: function(data) {
                        // console.log(data.asc);
                        var id_product      = data.datas.id;
                        var nama_kain       = data.datas.nama;
                        var gramasi         = data.datas.gramasi.nama;
                        var lebar           = data.datas.lebar.keterangan;
                        var warna           = data.datas.warna.nama;
                        var harga_product   = data.datas.harga_ecer;
                        var qty_roll        = data.datas.qty_roll;
                        var bagian          = data.datas.bagian
                        var warna_id        = data.datas.warna_id;

                        let optvalue = "";
                        let optasc = "";

                        $('#satuan-body').empty();
                        $('#satuan-accessories').empty();
                        $('#qty-body').val('');
                        $('#qty-accessories').val('');
                        $('#total-qty-body').empty();
                        $('#total-qty-asc').empty();
                        $('#total-body').empty();
                        $('#total-harga-asc').empty();
                        $('#total-bayar').empty();
                        $("#use-max-acs").prop("checked", false);
                        
                        optasc += `<option value="">--PILIH--</option>`;
                        $.each(data.asc, function(i, item) {
                            optasc += `<option value="${item.id}">${item.nama}</option>`;
                        });
                        $('#satuan-accessories').append(optasc);
                        
                        optvalue += `<option value="">--PILIH--</option>`;
                        $.each(data.satuan, function(i2, item2) {
                            optvalue +=
                                `<option value="${item2.satuan.keterangan}">${item2.satuan.keterangan}</option>`;
                        });
                        optvalue += `<option value="ROLL">ROLL</option>`;
                        $('#satuan-body').append(optvalue);

                        $('#judulmodal-fo').text(nama_kain)
                        $('#judullebar-fo').text(lebar)
                        $('#judulgramasi-fo').text(gramasi)
                        $('#judulwarna-fo').text(warna)

                        $('#id-product').val(id_product)
                        $('#harga-product').val(harga_product)
                        $('#qty-roll').val(qty_roll)
                        $('#bagian').val(bagian)
                        $('#warna_id').val(warna_id)
                    },
                    error: function(xhr, status, error) {
                        notif('error', 'Server Error!');
                    }
                })
            });
        });
    </script>
    @endpush

</x-app-layout>