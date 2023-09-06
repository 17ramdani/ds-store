<x-guest-new-layout>
    <section id="pageContent" class="uk-section" uk-height-viewport="offset-bottom: 20">
        <div class="uk-container">
            <div class="uk-margin-large uk-grid-large" uk-grid>
                @include('layouts.inc.sidebar')
                
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
                                            <a href="/product" class="uk-flex uk-flex-middle"><span class="uk-margin-small-right" uk-icon="icon: plus; ratio: 0.75"></span> Item</a>    
                                        </div>
                                    </div>

                                    <form action="/checkout-new" method="POST">
                                        @csrf
                                        <article>
                                            @if($cartArray)
                                                @php
                                                    $total_smt = 0;
                                                    $bodyItems = [];
                                                    $accessoriesItems = [];
                                                @endphp
                                    
                                                @foreach ($cartArray as $i => $item)
                                                    @php
                                                        $tipekain_id = $item['tipekain_id'];
                                                        $jenis_kainid = $item['jenis_kain_id'];
                                                        $qty_ = $item['qty'];
                                                        // $qty_roll = $item['qty_roll'];
                                                        $harga_ = $item['harga'];
                                                        $bagian = $item['bagian'];
                                                        $satuan = $item['satuan'];
                                                        $warna_id = isset($item['warna_id']) ? $item['warna_id'] : '0';
                                                        $id = isset($item['tipekain_id']) ? $item['tipekain_id'] : '0';
                                                        $idx = isset($item['id_keranjang']) ? $item['id_keranjang'] : '0';
                                                        $source = $item['source'];
                                    
                                                        if ($bagian == "accessories") {
                                                            $harga_body = $item['harga_body'];
                                                            $harga_asc = $item['harga_asc'];
                                    
                                                            $hargax = $harga_body + $harga_asc;
                                                            $item['subtotal'] = $qty_ * $hargax;
                                                            $item['harga'] = $hargax;
                                                            $accessoriesItems[$tipekain_id][] = $item;
                                                        } else {
                                                            if($satuan == "ROLL"){
                                                                $hargax = $item['harga_body'];
                                                                $item['subtotal'] = $qty_ * $hargax * 25;
                                                                $item['harga'] = $hargax;
                                                                $bodyItems[$tipekain_id][] = $item;
                                                            }else{
                                                                $hargax = $item['harga_body'];
                                                                $item['subtotal'] = $qty_ * $hargax;
                                                                $item['harga'] = $hargax;
                                                                $bodyItems[$tipekain_id][] = $item;
                                                            }
                                                        }
                                                    @endphp
                                    
                                                    <input type="hidden" name="warna_id[]" value="{{ $warna_id }}" class="uk-input uk-form-small">
                                                    <input type="hidden" name="satuan[]" value="{{ $satuan }}" class="uk-input uk-form-small">
                                                    <input type="hidden" name="bagian[]" value="{{ $bagian }}" data-bagian-id="{{ $id }}" class="uk-input uk-form-small">
                                                    <input type="hidden" name="id[]" value="{{ $id }}" class="uk-input uk-form-small">
                                                    <input type="hidden" name="idx[]" value="{{ $idx }}" data-idx-id="{{ $id }}" class="uk-input uk-form-small">
                                                    <input type="hidden" name="source[]" value="{{ $source }}" data-source-id="{{ $id }}" class="uk-input uk-form-small">
                                                    <input type="hidden" value="{{ $item['harga'] }}" id="harga-{{ $item['tipekain_id'] }}{{ isset($item['tipekain_id']) ? $item['tipekain_id'] : '0' }}" class="uk-input uk-form-small">
                                                @endforeach
                                    
                                                @foreach ($bodyItems as $tipekain_id => $items)
                                                    @php
                                                        $dataTipeKain = \App\Models\Barang\TipeKain::with('jenis_kain','lebar', 'gramasi','warna')->where('id', $tipekain_id)->first();
                                                        $nama_kain = $items[0]['nama'];
                                                        $bagian = $items[0]['bagian'];
                                                    @endphp
                                    
                                                    <div class="rz-cart-item">
                                                        <dl>
                                                            <dt>{{ $dataTipeKain->jenis_kain->nama }}</dt>
                                                            <dd>{{ $nama_kain }} - {{ $dataTipeKain->warna->keterangan }}</dd>
                                                        </dl>
                                                        @foreach ($items as $item)
                                                            @php
                                                                $satuan = $item['satuan'];
                                                            @endphp
                                                            <div class="uk-grid-small" uk-grid>
                                                                <div class="uk-width-1-5">
                                                                    <input type="number" name="qty[]" value="{{ $item['qty'] }}" id="qty-{{ $item['tipekain_id'] }}{{ $id }}" onkeyup="hitungTotal({{ $item['tipekain_id'] }}{{ $id }})" class="uk-input uk-form-small" placeholder="30">
                                                                </div>
                                                                <div class="uk-width-auto">
                                                                    {{ $satuan }}
                                                                </div>
                                                                <div class="uk-width-expand">
                                                                    <ul>
                                                                        <li>
                                                                            <a href="" id="delete-{{ $item['tipekain_id'] }}" style="text-decoration: none;font-size:20px;color:#808080;">
                                                                                <i class="ph ph-trash"></i>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="" style="text-decoration: none;font-size:20px;color:#808080;">
                                                                                <i class="ph-light ph-lg ph-heart add-to-wishlist" data-item-id="{{ $item['tipekain_id'] }}"></i>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <div class="uk-width-2-5 uk-text-right uk-text-bold">
                                                                    Rp. {{ number_format($item['subtotal']) }}
                                                                </div>
                                                            </div>
                                                            @php
                                                                $total_smt += $item['subtotal'];
                                                            @endphp
                                                        @endforeach
                                                    </div>
                                                @endforeach
                                    
                                                @foreach ($accessoriesItems as $tipekain_id => $items)
                                                    @php
                                                        $dataTipeKain = \App\Models\Barang\TipeKain::with('jenis_kain','lebar', 'gramasi','warna')->where('id', $tipekain_id)->first();
                                                        $nama_kain = $items[0]['nama'];
                                                        $bagian = $items[0]['bagian'];
                                                    @endphp
                                    
                                                    <div class="rz-cart-item">
                                                        <dl>
                                                            <dt>{{ $dataTipeKain->jenis_kain->nama }}</dt>
                                                            <dd>{{ $nama_kain }} - {{ $dataTipeKain->warna->keterangan }}</dd>
                                                        </dl>
                                                        @foreach ($items as $item)
                                                            @php
                                                                $satuan = $item['satuan'];
                                                            @endphp
                                                            <div class="uk-grid-small" uk-grid>
                                                                <div class="uk-width-1-5">
                                                                    <input type="number" name="qty[]" value="{{ $item['qty'] }}" id="qty-{{ $item['tipekain_id'] }}{{ $id }}" onkeyup="hitungTotal({{ $item['tipekain_id'] }}{{ $id }})" class="uk-input uk-form-small" placeholder="30">
                                                                </div>
                                                                <div class="uk-width-auto">
                                                                    {{ $satuan }}
                                                                </div>
                                                                <div class="uk-width-expand">
                                                                    <ul>
                                                                        <li>
                                                                            <a href="" id="delete-{{ $item['tipekain_id'] }}" style="text-decoration: none;font-size:20px;color:#808080;">
                                                                                <i class="ph ph-trash"></i>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="" style="text-decoration: none;font-size:20px;color:#808080;">
                                                                                <i class="ph-light ph-lg ph-heart add-to-wishlist" data-item-id="{{ $item['tipekain_id'] }}"></i>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <div class="uk-width-2-5 uk-text-right uk-text-bold">
                                                                    Rp. {{ number_format($item['subtotal']) }}
                                                                </div>
                                                            </div>
                                                            @php
                                                                $total_smt += $item['subtotal'];
                                                            @endphp
                                                        @endforeach
                                                    </div>
                                                @endforeach
                                    
                                                <article class="rz-values-horizontal uk-text-small">
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
                                                </article>
                                    
                                                <div class="uk-margin-top uk-align-right@s">
                                                    <a href="/product" class="uk-button uk-button-default">Tambah Item</a>
                                                    <button type="submit" class="uk-button uk-button-primary">Checkout</button>
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
        
                    <div id="card-container">
                        @include('cards')
                    </div>
                    
                </div>          
            </div>
        </div>
    </section>
    @include('modal-cart')
    

    @if(session('success'))
    @push('script')
        <script>
            notif('success', 'Barang siap dicheckout.');
        </script>
    @endpush
    @endif
    @if(session('error'))
    @push('script')
        <script>
            notif('error', '{{ session('error') }}');
        </script>
    @endpush
    @endif
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
                                    alert(1)
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
            $(document).on('click', '.add-modal-cart', function() {
                var id              = $(this).attr('data-idx');
                var jenis_kain_id   = $(this).attr('data-id-kain');
                var nama_kain       = $(this).attr('data-kain');
                var nama_lebar      = $(this).attr('data-lebar');
                var nama_gramasi    = $(this).attr('data-gramasi');
                var nama_warna      = $(this).attr('data-warna');
                var warna_id        = $(this).attr('data-warna-id');
                var lebar_id        = $(this).attr('data-lebar-id');
                var gramasi_id      = $(this).attr('data-gramasi-id');
                var bagian          = $(this).attr('data-bagian');
                var harga_produk    = $(this).attr('data-harga');
                // console.log(id + ' - ' + jenis_kain_id + ' - ' + nama_kain);

                $('#judulmodal-fo').text(nama_kain)
                $('#judullebar-fo').text(nama_lebar)
                $('#judulgramasi-fo').text(nama_gramasi)
                $('#judulwarna-fo').text(nama_warna)
                $('#warnaModal').val(warna_id);
                $('#bagian').val(bagian);
                $('#hargModal').val(harga_produk);
                $('#lebarModal').val(nama_lebar);
                $('#gramasiModal').val(nama_gramasi);
                $('#namaWarna').val(nama_warna);

                $.ajax({
                    url: '/fetch-product-modal',
                    type: 'GET',
                    data: {
                        id_prd: id, 
                        jenis_kain_id: jenis_kain_id,
                        nama_produk:nama_kain
                    },
                    success: function(data) {
                        console.log()
                        $('#qtyBodyModal').val('');
                        $('#qtyAscModal').val('');
                        $('#bodySelect').empty();
                        $('#aksesorisSelect').empty(); 
                        $('#total_bodyQty').text('').empty();
                        $('#total_hargabody').text('').empty();
                        $('#total_ascQty').text('').empty();
                        $('#total_hargaasc').text('').empty();
                        $('#total_hargasm').text('').empty();

                        let optvalue = "";
                        let optasc = "";
                        $.each(data.asc, function(i, item) {
                            optasc += `<option value="${item.id}">${item.nama}</option>`;
                        });
                        $.each(data.satuan, function(i2, item2) {
                            optvalue +=
                                `<option value="${item2.satuan.keterangan}">${item2.satuan.keterangan}</option>`;
                        });
                        $('#bodySelect').append(optvalue);

                        var rollExists = false;
                        $.each(data.satuan, function(i2, item2) {
                            if (item2.satuan.keterangan === "ROLL") {
                                rollExists = true;
                                return false; // Menghentikan iterasi
                            }
                        });

                        if (!rollExists) {
                            $('#bodySelect').append('<option value="ROLL">ROLL</option>');
                        }

                        // $('#bodySelect').append('<option value="ROLL">ROLL</option>');
                        $('#aksesorisSelect').append(optasc);
                        $('#jenis_kainidBodyModal').val(jenis_kain_id);
                        $('#id_produkBodyModal').val(id);
                        $('#nama_produkBodyModal').val(nama_kain);
                        // $('#modalAddToCart .uk-modal-body').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });

        function hitungTotal(tipekain_id, id) {
        var qty = parseFloat(document.getElementById('qty-' + tipekain_id + id).value);
        var harga = parseFloat(document.getElementById('harga-' + tipekain_id + id).value);
        var subtotal = qty * harga;
        document.getElementById('subtotal-' + tipekain_id + id).innerText = 'Rp. ' + formatNumber(subtotal);

        var total_smt = 0;
        var subtotals = document.getElementsByClassName('subtotal');
        for (var i = 0; i < subtotals.length; i++) {
            total_smt += parseFloat(subtotals[i].innerText.replace(/[^\d.]/g, ''));
        }
        document.getElementById('total-harga-sub-all').innerText = 'Rp. ' + formatNumber(total_smt);
        document.getElementById('total-harga-all').innerText = 'Rp. ' + formatNumber(total_smt);
    }

    function formatNumber(number) {
        return number.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    $(document).ready(function() {
        $('a[id^="delete-"]').on('click', function(e) {
            e.preventDefault();
            var itemId = $(this).attr('id').replace('delete-', '');
            var sourceValue = $('input[name="source[]"][data-source-id="' + itemId + '"]').val();
            var bagianValue = $('input[name="bagian[]"][data-bagian-id="' + itemId + '"]').val();
            var idxidx      = $('input[name="idx[]"][data-idx-id="' + itemId + '"]').val();
            deleteItem(itemId,sourceValue,bagianValue,idxidx);
            // alert(sourceValue);
        });

        function deleteItem(itemId,sourceValue,bagian,idxidx) {
            // console.log(itemId + ' = ' +sourceValue + ' = ' + bagian)
            $.ajax({
                url: '/delete-item', 
                type: 'POST',
                data: {
                    item_id: itemId,
                    source: sourceValue,
                    bagian: bagian,
                    idxidx:idxidx,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // console.log(response);
                    notif('success', response.message);
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error('Error deleting item:', error);
                }
            });
        }
    });

    </script>
    @endpush
</x-guest-new-layout>