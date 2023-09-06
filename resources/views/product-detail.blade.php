<x-guest-new-layout>
    <section id="pageContent" class="uk-section" uk-height-viewport="offset-bottom: 20">
        <div class="uk-container">
            <div class="uk-margin-large uk-grid-large" uk-grid>
                @include('layouts.inc.sidebar')
                
                <div class="uk-width-3-4@s">
                    <div class="rz-detail-product" id="page-detail-produk">
                        <div uk-grid>
                            <div class="uk-width-2-5@s">
                                {{-- <img src="{{ asset('assets/tipe-kain/' . $detail->gambar) }}" alt=""> nanti set pake ini --}}
                                @if($detail->gambar)
                                    <img src="{{ $detail->gambar }}" alt="" class="uk-border-rounded uk-margin">
                                @else
                                    <img src="{{ asset('tipe-kain/' . rand(7, 24) . '.jpg') }}" alt="" class="uk-border-rounded uk-margin">
                                @endif
                                <div class="uk-child-width-1-3 uk-grid-small" uk-grid uk-lightbox="animation: slide">
                                    <div>
                                        <a class="uk-inline" href="{{ $detail->gambar }}" data-caption="Caption 1">
                                            @if($detail->gambar)
                                                <img src="{{ $detail->gambar }}" alt="" class="uk-border-rounded">
                                            @else
                                                <img src="{{ asset('tipe-kain/' . rand(7, 24) . '.jpg') }}" alt="" class="uk-border-rounded">
                                            @endif
                                        </a>
                                    </div>
                                    <div>
                                        <a class="uk-inline" href="{{ $detail->gambar_2 }}" data-caption="Caption 2">
                                            @if($detail->gambar_2)
                                                <img src="{{ $detail->gambar_2 }}" alt="" class="uk-border-rounded">
                                            @else
                                                <img src="{{ asset('tipe-kain/' . rand(7, 24) . '.jpg') }}" alt="" class="uk-border-rounded">
                                            @endif
                                        </a>
                                    </div>
                                    <div>
                                        <a class="uk-inline" href="{{ $detail->gambar_3 }}" data-caption="Caption 3">
                                            @if($detail->gambar_3)
                                                <img src="{{ $detail->gambar_3 }}" alt="" class="uk-border-rounded">
                                            @else
                                                <img src="{{ asset('tipe-kain/' . rand(7, 24) . '.jpg') }}" alt="" class="uk-border-rounded">
                                            @endif
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
                                            <label><input class="uk-radio" id="satuan1" value="{{ $detail->satuan->keterangan }}" type="radio" name="radio2" checked onclick="showEcerPrice()"> {{ $detail->satuan->keterangan }}</label>
                                            <label><input class="uk-radio" id="satuan2" value="ROLL" type="radio" name="radio2" onclick="showRollPrice()"> ROLL</label>
                                            <input type="hidden" id="id_produk" value="{{ $detail->id }}" class="uk-input uk-form-small">
                                            <input type="hidden" id="jenis_kain_id" value="{{ $detail->jenis_kain_id }}" class="uk-input uk-form-small">
                                            <input type="hidden" id="nama_produk" value="{{ $detail->nama }}" class="uk-input uk-form-small">
                                            <input type="hidden" id="harga_produk" value="{{ $detail->harga_ecer }}" class="uk-input uk-form-small">
                                            <input type="hidden" id="warna_id" value="{{ $detail->warna_id }}" class="uk-input uk-form-small">
                                            <input type="hidden" id="lebar_id" value="{{ $detail->lebar->keterangan }}" class="uk-input uk-form-small">
                                            <input type="hidden" id="gramasi" value="{{ $detail->gramasi->nama }}" class="uk-input uk-form-small">
                                            <input type="hidden" id="bagian_" value="{{ $detail->bagian }}" class="uk-input uk-form-small">
                                            <input type="hidden" id="warna" value="{{ $detail->warna->nama }}" class="uk-input uk-form-small">
                                        </div>
                                        <div class="rz-detail-product-price">
                                            Rp. {{ number_format($detail->harga_ecer) }}
                                        </div>
                                    </div>
                                    <div class="uk-text-right">
                                        <a href="#" style="text-decoration: none;" >
                                            <i class="ph-light ph-lg ph-heart add-to-wishlist" style="font-size: 1.3rem;vertical-align: bottom;margin-right: 10px;" data-item-id="{{ $detail->id }}"></i>
                                            <!-- ganti class jadi "ph-fill" ketika wishlist aktif -->
                                        </a>
                                        <a href="#modalAddToCartDetail" class="rz-button tambahCart" uk-toggle><i class="ph-fill ph-lg ph-shopping-cart"></i> Tambah</a>
                                    </div>
                                </div>
                                <div class="uk-text-meta">
                                    Harga yang tertera masih bersifat estimasi, harga yang sudah fixed akan diinformasikan pada halaman konfirmasi pesanan
                                </div>
                                
                                <hr>
    
                                </div>
                                <div class="uk-margin-medium">
                                    <h5>Deskripsi</h5>
                                    <p>Cotton Carded adalah jenis kain yang menggunakan benang kualitas carded, dengan komposisi 100% cotton. Diolah melalui proses carding (garuk) dan diberi pelembut saat proses finishing sehingga handfeel-nya halus menyerupai Cotton Combed. Cotton Carded memiliki daya serap dan sirkulasi udara yang baik, sehingga tetap menjadi bahan andalan untuk produksi kaos. Cotton Carded sangat terjangkau.</p>
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
                                                    <td class="uk-text-right">2.00</td>
                                                </tr>
                                                <tr>
                                                    <th>Karakteristik</th>
                                                    <td class="uk-text-right">Bertekstur</td>
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
                            @foreach($rekomendasi_produk as $rp)
                                <div>
                                    <div class="rz-card-product">
                                        <div class="uk-inline">
                                        {{-- <img src="{{ asset('assets/tipe-kain/' . $rp->gambar) }}" alt=""> nanti set pake ini --}}
                                        <img src="{{ asset('tipe-kain/' . rand(7, 24) . '.jpg') }}" alt="">
                                            <a href="#modalAddToCart"
                                            data-idx="{{ $rp->id }}" 
                                            data-id-kain="{{ $rp->jenis_kain_id }}" 
                                            data-kain="{{ $rp->nama }}"
                                            data-lebar="{{ $rp->lebar->keterangan }}" 
                                            data-gramasi="{{ $rp->gramasi->nama }}" 
                                            data-warna="{{ $rp->warna->keterangan }}" 
                                            data-warna-id="{{ $rp->warna->id }}" 
                                            data-lebar-id="{{ $rp->barang_lebar_id }}" 
                                            data-gramasi-id="{{ $rp->barang_gramasi_id }}" 
                                            data-bagian="{{ $rp->bagian }}" 
                                            data-harga="{{ $rp->harga_ecer }}"
                                            uk-toggle class="uk-icon-button add-modal-cart" uk-icon="cart"></a>    
                                        </div>
                                        
                                        <div class="rz-card-product-detail">
                                            <h5><a href="/product-detail/{{ $rp->id }}">{{ $rp->nama }}</a></h5>
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
        
                    <div id="card-container">
                        @include('cards')
                    </div>
                    
                </div>             
            </div>
        </div>
    </section>

    @include('modal-cart')

    <div id="modalAddToCartDetail" uk-modal>
        <div class="uk-modal-dialog">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header">
                <h4>{{ $detail->nama }}</h4>
                <dl>
                    <dt>{{ $detail->lebar->keterangan }}" /{{ $detail->gramasi->nama }}</dt>
                    <dd>{{ $detail->warna->keterangan }}</dd>
                </dl>
            </div>
            <div class="uk-modal-body" uk-overflow-auto>
                <div class="uk-child-width-1-2@s" uk-grid>
                    <div>
                        <div class="uk-margin">
                            <strong>Body</strong>
                            <form class="uk-grid-small" uk-grid>
                                <div class="uk-width-1-2">
                                   <select id="bodySelect_Detail" class="uk-select uk-form-small" required>
                                   </select>
                                </div>
                                <div class="uk-width-1-2">
                                    <input type="hidden" id="jenis_kainidBodyModal_Detail" class="uk-input uk-form-small" placeholder="">
                                    <input type="hidden" id="id_produkBodyModal_Detail" class="uk-input uk-form-small" placeholder="">
                                    <input type="hidden" id="nama_produkBodyModal_Detail" class="uk-input uk-form-small" placeholder="">
                                    <input type="hidden" id="hargModal_Detail" class="uk-input uk-form-small" placeholder="">
                                    <input type="hidden" id="harga-pil_Detail" class="uk-input uk-form-small" placeholder="">
                                    <input type="hidden" id="warnaModal_Detail" class="uk-input uk-form-small" placeholder="">
                                    <input type="hidden" id="lebarModal_Detail" class="uk-input uk-form-small" placeholder="">
                                    <input type="hidden" id="gramasiModal_Detail" class="uk-input uk-form-small" placeholder="">
                                    <input type="number" id="qtyBodyModal_Detail" class="uk-input uk-form-small" placeholder="Masukkan qty" required>
                                    <input type="hidden" id="bagian_Detail" class="uk-input uk-form-small" placeholder="Masukkan qty">
                                    <input type="hidden" id="harga-asc_Detail" class="uk-input uk-form-small" placeholder="">
                                    <input type="hidden" id="namaWarna_Detail" class="uk-input uk-form-small" placeholder="">
                                </div>
                            </form>
                        </div>
                        <div class="uk-margin" id="form-accessories">
                            <strong>Aksesoris</strong>
                            <form class="uk-grid-small" uk-grid>
                                <div class="uk-width-1-2">
                                   <select id="aksesorisSelect_Detail" class="uk-select uk-form-small" required>
                                   </select>
                                </div>
                                <div class="uk-width-1-2">
                                   <input type="number" id="qtyAscModal_Detail" required class="uk-input uk-form-small" placeholder="Masukkan qty">
                                </div>
                            </form>
                            <span class="uk-text-meta"><span class="uk-margin-small-right" uk-icon="icon: info; ratio: 0.75"></span>Pembelian rib min. 5% dari pembelian body</span>
                        </div>
                    </div>
                    <div>
                        <table class="rz-table-vertical">
                            <tr>
                                <th>Total Body</th>
                                <td class="uk-text-right" id="total_bodyQty_Detail"></td>
                                <td class="uk-text-right" id="total_hargabody_Detail"></td>
                                <input type="hidden" id="total_hargavaluebody_Detail" class="uk-input uk-form-small">
                            </tr>
                            <tr>
                                <th>Total Aksesoris</th>
                                <td class="uk-text-right" id="total_ascQty_Detail"></td>
                                <td class="uk-text-right" id="total_hargaasc_Detail"></td>
                                <input type="hidden" id="total_hargavalueasc_Detail" class="uk-input uk-form-small">
                            </tr>
                            <tr>
                                <th>Total Bayar <span uk-icon="icon: info; ratio: 0.75" uk-tooltip="Harga yang tertera masih bersifat estimasi, harga dan berat yang sudah fixed akan diinformasikan pada halaman konfirmasi pesanan"></span></th>
                                <td></td>
                                <td class="uk-text-right uk-text-bold" id="total_hargasm_Detail"></td>
                                <input type="hidden" id="total_harga_Detail" class="uk-input uk-form-small">
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="uk-modal-footer uk-text-right">
                <button class="uk-button uk-button-default uk-modal-close" type="button">Batal</button>
                <button type="button" onclick="addToCartDetail()" class="uk-button uk-button-primary" id="addToCartButtonDetail">
                    <span id="addToCartTextDetail">Tambah</span>
                    <i id="addToCartLoadingDetail" class="ph ph-spinner ph-spin ph-lg custom-spin" style="display: none;"></i>
                </button>
            </div>
    
        </div>
    </div>

    @push('script')
        <script>
            $(document).ready(function() {
                $(document).on('click', 'a[data-idx]', function() {
                    var id = $(this).attr('data-idx');
                    console.log(id);

                    // Lakukan permintaan Ajax atau tindakan lain sesuai kebutuhan
                });
            });

            updateIconWhitelist();

            function updateIconWhitelist(){
                var itemId = $('.add-to-wishlist').data('item-id');
                var icon = $('.add-to-wishlist');
                $.ajax({
                    url: '/get-icon-whitelist',
                    type: 'GET',
                    data :{
                        itemId : itemId
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
                            if (icon == 'ph-light ph-lg ph-heart add-to-wishlist' ) {
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
                        url: '/whitelist-new',
                        type: 'POST',
                        data: {
                            itemId: itemId,
                            icon: icon.attr('class'),
                            iconStatus:iconStatus
                        },
                        success: function(response) {
                            // console.log(response.success)
                            if (response.success) {
                                if (iconStatus === 'add') {
                                    icon.removeClass('ph-light').addClass('ph-fill');
                                } else {
                                    icon.removeClass('ph-fill').addClass('ph-light');
                                }
                            } else {
                                // Tanggapan tidak berhasil dari server
                                // alert(response.message);
                                notif('warning','Whitelist sudah mencapai batas')
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        }
                    });
                });
            });
        </script>
    @endpush
    @push('script')
    <script>
    $(document).ready(function() {    
        $('.tambahCart').on('click', function() {
            var id_prd          = $('#id_produk').val();
            var jenis_kain_id   = $('#jenis_kain_id').val();
            var nama_produk     = $('#nama_produk').val();
            var harga_produk    = $('#harga_produk').val();
            var warna_id        = $('#warna_id').val();
            var lebar           = $('#lebar_id').val();
            var gramasi         = $('#gramasi').val();
            var bagian          = $('#bagian_').val();
            var warna           = $('#warna').val();

            $('#warnaModal_Detail').val(warna_id)
            $('#lebarModal_Detail').val(lebar)
            $('#gramasiModal_Detail').val(gramasi)
            $('#bagian_Detail').val(bagian)
            $('#namaWarna_Detail').val(warna)
            
            // if ($('#satuan1').is(':checked')) {
            //     satuan = $('#satuan1').val();
            // } else if ($('#satuan2').is(':checked')) {
            //     satuan = $('#satuan2').val();
            // }

            $('#bodySelect_Detail').empty(); 
            $('#aksesorisSelect_Detail').empty();
            
            $.ajax({
                url: '/fetch-product-modal',
                type: 'GET',
                data: { 
                    id_prd: id_prd, 
                    jenis_kain_id: jenis_kain_id,
                    nama_produk:nama_produk,
                },
                dataType: 'json',
                success: function(data) {
                    let optvalue = "";
                    let optasc = "";

                    // $('#bodySelect').append('<option value="">--PILIH--</option>');
                    // $('#aksesorisSelect_Detail').append('<option value="">--PILIH--</option>');
                    $.each(data.asc, function(i, item) {
                        // 
                        if(item.id == "899"){
                         $('#form-accessories').hide();
                        }
                        console.log(item.id)
                        optasc += `<option value="${item.id}">${item.nama}</option>`;
                    });

                    $.each(data.satuan, function(i2, item2) {
                        optvalue +=
                            `<option value="${item2.satuan.keterangan}">${item2.satuan.keterangan}</option>`;
                    });
                    $('#bodySelect_Detail').append(optvalue);
                    $('#bodySelect_Detail').append('<option value="ROLL">ROLL</option>');
                    $('#aksesorisSelect_Detail').append(optasc);
                    $('#jenis_kainidBodyModal_Detail').val(jenis_kain_id);
                    $('#id_produkBodyModal_Detail').val(id_prd);
                    $('#nama_produkBodyModal_Detail').val(nama_produk);
                    $('#hargModal_Detail').val(harga_produk);
                }
            });
        })
    });

    function showEcerPrice() {
        var ecerPrice = {{ $detail->harga_ecer }};
        var priceElement = document.querySelector(".rz-detail-product-price");
        priceElement.innerHTML = "Rp. " + ecerPrice.toLocaleString();
        $('#harga_produk').val(ecerPrice);
    }

    function showRollPrice() {
        var rollPrice = {{ $detail->harga_roll }};
        var priceElement = document.querySelector(".rz-detail-product-price");
        priceElement.innerHTML = "Rp. " + rollPrice.toLocaleString();
        $('#harga_produk').val(rollPrice);
    }

    $('#qtyBodyModal_Detail').on('keyup', function() {
        var satuaBodyModal  = $('#bodySelect_Detail').val();
        var jenis_kain_id   = $('#jenis_kainidBodyModal_Detail').val();
        var id_prd          = $('#id_produkBodyModal_Detail').val();
        var nama_produk     = $('#nama_produkBodyModal_Detail').val();
        var qtyBodyModal    = $('#qtyBodyModal_Detail').val();
        var total_asc       = $('#total_hargavalueasc_Detail').val();
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
                var qty_roll    = response.datas.qty_roll
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
                    $('#total_hargasm_Detail').text('Rp.' + total_smt.toLocaleString())
                    $('#total_harga_Detail').val(total_smt)
                }

                $('#total_bodyQty_Detail').text(qtyBodyModal + satuaBodyModal);
                $('#total_hargabody_Detail').text('Rp '+total_body.toLocaleString());
                $('#total_hargavaluebody_Detail').val(total_body);
                $('#harga-pil_Detail').val(harga)
            },
            // error: function() {
            //     $('#hargaDisplay').text('Rp. ' + harga);
            // }
        });
    })

    
    $('#qtyAscModal_Detail').on('keyup', function() {
        var jenis_kain_id   = $('#jenis_kainidBodyModal_Detail').val();
        var id_prdasc       = $('#aksesorisSelect_Detail').val();
        var qtyAscModal     = $('#qtyAscModal_Detail').val();
        var harga_body      = $('#hargModal_Detail').val();
        var total_body      = $('#total_hargavaluebody_Detail').val();
        $.ajax({
            url: '/fetch-product-harga-asc',
            type: 'GET',
            data: { 
                jenis_kain_id:jenis_kain_id,
                id_prdasc:id_prdasc,
                qtyAscModal:qtyAscModal
            },
            success: function(response) {
                // console.log(total_body)
                var harga_kg    = response.datas.harga_ecer
                var harga_roll  = response.datas.harga_roll
        //         if (satuaBodyModal === "KG") {
        //             harga = harga_kg
        //         }else if(satuaBodyModal == "ROLL"){
        //             harga = harga_roll
        //         }else{
        //             harga = harga_kg
        //         }
                // var total_asc = harga_kg * qtyAscModal;
                // var total_smt = parseInt(total_asc) + parseInt(total_body);
                
                var total_asc = parseInt(harga_body) + parseInt(harga_kg) * qtyAscModal;
                var total_smt = parseInt(total_asc) + parseInt(total_body);
                console.log(harga_body)

                if (!isNaN(total_smt)) {
                    $('#total_hargasm_Detail').text('Rp' +total_smt.toLocaleString());
                    $('#total_harga_Detail').val(total_smt)
                }

                $('#total_ascQty_Detail').text(qtyAscModal + 'KG');
                $('#total_hargaasc_Detail').text('Rp '+total_asc.toLocaleString());
                $('#total_hargavalueasc_Detail').val(total_asc);
                $('#harga-asc_Detail').val(harga_kg);
                
            },
        });
    })


    function addToCartDetail() {
        var id_prd          = $('#id_produkBodyModal_Detail').val();
        var jenis_kain_id   = $('#jenis_kainidBodyModal_Detail').val();
        var satuaBodyModal  = $('#bodySelect_Detail').val();
        var nama_produk     = $('#nama_produkBodyModal_Detail').val();
        var id_prdasc       = $('#aksesorisSelect_Detail').val();
        var qtyBodyModal    = $('#qtyBodyModal_Detail').val();
        var qtyAscModal     = $('#qtyAscModal_Detail').val();
        var totalHarga      = $('#total_harga_Detail').val();
        var warnaModal      = $('#warnaModal_Detail').val();
        var namaWarna       = $('#namaWarna_Detail').val();
        var lebarModal      = $('#lebarModal_Detail').val();
        var gramasiModal    = $('#gramasiModal_Detail').val();
        var bagian          = $('#bagian_Detail').val();
        var harga           = $('#hargModal_Detail').val();
        var harga_pil       = $('#harga-pil_Detail').val();
        var harga_asc       = $('#harga-asc_Detail').val();
        var addToCartButton = document.getElementById("addToCartButtonDetail");

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
                        notif('success', 'Barang ditambahkan ke keranjang.');
                        UIkit.modal('#modalAddToCartDetail').hide();
                        updateNotificationBadge();
                        getDataForCartMobile();
                    
                },
                error: function() {
                    notif('error', 'Server Error!');
                }
            });
        }
    }

    
    </script>
    @endpush

    @push('script')
    <script>
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
                        console.log(id + ' + ' + jenis_kain_id + ' + ' + nama_kain)
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
    </script>
@endpush
    </x-guest-new-layout>