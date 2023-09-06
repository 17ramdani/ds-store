<x-guest-new-layout>
    <section id="pageContent" class="uk-section" uk-height-viewport>
        <div class="uk-container">
            <div class="uk-margin-large uk-grid-large" uk-grid>
                @include('layouts.inc.sidebar')
                
                <!-- Contains uk-width-1-4@s. Don't screw up! -->
                <div class="uk-width-3-4@s">
                   
                    <div class="rz-list-container" id="pesanan-index">
                        <div class="rz-panel">
                           <h3><i class="ph-light ph-basket rz-icon"></i>List Pesanan </h3>
                            <div class="uk-child-width-1-6@l uk-child-width-1-3 uk-grid-small uk-grid-match uk-margin-medium" uk-grid>
                                <div>
                                    <div class="rz-cell-alt">
                                        <div class="rz-cell-value">{{ $count->sts_0 }}</div>
                                        <div class="rz-cell-label">Total Pesanan</div>
                                    </div>
                                </div>
                                <div>
                                    <div class="rz-cell-alt">
                                        <div class="rz-cell-value">{{ $count->sts_1 }}</div>
                                        <div class="rz-cell-label">Tunggu Konfirmasi</div>
                                    </div>
                                </div>
                                <div>
                                    <div class="rz-cell-alt">
                                        <div class="rz-cell-value">{{ $count->sts_2 }}</div>
                                        <div class="rz-cell-label"><a href="pesanan-so-index.php">Tunggu Pembayaran</a></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="rz-cell-alt">
                                        <div class="rz-cell-value">{{ $count->sts_3 }}</div>
                                        <div class="rz-cell-label">Pesanan Diproses</div>
                                    </div>
                                </div>
                                <div>
                                    <div class="rz-cell-alt">
                                        <div class="rz-cell-value">{{ $count->sts_4 }}</div>
                                        <div class="rz-cell-label">Pesanan Diantar</div>
                                    </div>
                                </div>
                                <div>
                                    <div class="rz-cell-alt">
                                        <div class="rz-cell-value">{{ $count->sts_5 }}</div>
                                        <div class="rz-cell-label">Pesanan Selesai</div>
                                    </div>
                                </div>
                            </div>                        
                        </div>
                        
                        @if($pesanan)
                        @foreach($pesanan as $dtf)
                        @php
                        $total_harga = 0;
                        
                        @endphp
                        @foreach ($dtf['details'] as $i => $detail)
                        @php
                        if ($detail['satuan'] == 'ROLL') {
                            $dharga = $detail['tipe_kain']['harga_roll'];
                            if ($detail['bagian'] == 'accessories') {
                                $dharga = $dtf['details'][$i - 1]['tipe_kain']['harga_roll'] + $detail['tipe_kain']['harga_roll'];
                            }
                        } else {
                            $dharga = $detail['tipe_kain']['harga_ecer'];
                            if ($detail['bagian'] == 'accessories') {
                                $dharga = $dtf['details'][$i - 1]['tipe_kain']['harga_ecer'] + $detail['tipe_kain']['harga_ecer'];
                            }
                        }

                        if ($detail['satuan'] == 'KG') {
                            $subtotal = $detail['qty'] * $dharga;
                        } elseif ($detail['satuan'] == 'ROLL') {
                            $subtotal = $detail['qty'] * 25 * $dharga;
                        } elseif ($detail['satuan'] == 'LOT') {
                            $subtotal = $detail['qty'] * (12 * 25) * $dharga;
                        } else {
                            $subtotal = $detail['qty'] * $dharga;
                        }

                        $total_harga += $subtotal;

                        $status_pesananid = $dtf->status_pesanan_id;
                        if($status_pesananid == "1"){
                            $text_status_pesanan = "Tunggu Konfirmasi";
                            $status_warna = "warning";
                        }elseif($status_pesananid == "2"){
                            $text_status_pesanan = "Tunggu Pembayaran";
                            $status_warna = "warning";
                        }elseif($status_pesananid == "3"){
                            $text_status_pesanan = "Pesanan Diproses";
                            $status_warna = "info";
                        }elseif($status_pesananid == "4"){
                            $text_status_pesanan = "Pesanan Diantar";
                            $status_warna = "info";
                        }elseif($status_pesananid == "5"){
                            $text_status_pesanan = "Pesanan Selesai";
                            $status_warna = "success";
                        }elseif($status_pesananid == "6"){
                            $text_status_pesanan = "Pesanan Batal";
                            $status_warna = "danger";
                        }else{
                            $text_status_pesanan = "N/A";
                            $status_warna = "warning";
                        }

                        @endphp
                        @endforeach
                        @php
                        // $status_warna = 'default';
                        // $text_status_pesanan = "";
                        @endphp
                        <article>
                            <header class="uk-flex uk-flex-between">
                                <span class="rz-text-primary">{{ $dtf->target_pesanan }}</span>
                                <span class="uk-label uk-label-{{ $status_warna }}">{{ $text_status_pesanan }}</span>
                            </header>
                            <main class="uk-grid-small" uk-grid>
                                <div class="uk-width-1-5@s">
                                    @if ($dtf->status_pesanan_id == 1 || $dtf->status_pesanan_id == 2)
                                        <a href="/draft-so/{{ $dtf->id }}">{{ $dtf->nomor }}</a>
                                    @else
                                        <a href="/detail-so/{{ $dtf->id }}">{{ $dtf->nomor }}</a>
                                    @endif
                                    {{-- <span class="uk-label uk-label-warning">Tunggu Konfirmasi</span> --}}
                                </div>
                                <div class="uk-width-1-5@s uk-width-1-2">
                                    <dl>
                                        <dt>Total Item</dt>
                                        <dd>{{ count($dtf['details']) }}</dd>
                                    </dl>
                                </div>
                                <div class="uk-width-1-5@s uk-width-1-2">
                                    <dl>
                                        <dt>Target Pesanan</dt>
                                        <dd>
                                            @if($dtf->customer->customer_category_id == 3)
                                            {{ $dtf->target_pesanan }}
                                            @else
                                            {{ $dtf->tanggal_pesanan }}
                                            @endif
                                        </dd>
                                    </dl>
                                </div>
                                <div class="uk-width-1-5@s uk-width-1-2">
                                    <dl>
                                        <dt>Harga Estimasi</dt>
                                        <dd>Rp. {{ number_format($total_harga) }}</dd>
                                    </dl>
                                </div>
                                <div class="uk-width-1-5@s uk-width-1-2">
                                    <dl>
                                        <dt>Harga Aktual</dt>
                                        <dd>Rp. {{ number_format($dtf->total) }}</dd>
                                    </dl>
                                </div>
                                <div class="uk-width-2-5@s">
                                    <dl>
                                        <dt>Catatan</dt>
                                        <dd>{{ $dtf->catatan_cs }} - Andi</dd>
                                    </dl>
                                </div>
                            </main>
                            <footer class="uk-text-right">
                                @if ($dtf->status_pesanan_id == 1 || $dtf->status_pesanan_id == 2)
                                    <a href="/draft-so/{{ $dtf->id }}">View<i class="ph-light ph-caret-circle-right"></i></a>
                                @else
                                    <a href="/detail-so/{{ $dtf->id }}">View<i class="ph-light ph-caret-circle-right"></i></a>
                                @endif
                            </footer>
                        </article>
                        @endforeach
                        @endif

                        </div>

                        <div class="uk-child-width-1-4@s uk-child-width-1-2 uk-grid-small" uk-grid id="produk-container">
                        </div>
            
                        <div id="card-container">
                            @include('cards')
                        </div>
    
                    </div>
                    
                </div>         
            </div>
        </div>
    </section>

    <div id="modalAddToCart" uk-modal>
        <div class="uk-modal-dialog">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header">
                <h4 id="judulmodal-fo"></h4>
                <dl>
                    <dt><span id="judullebar-fo"></span>  / <span id="judulgramasi-fo"></span></dt>
                    <dd><span id="judulwarna-fo"></span></dd>
                </dl>
            </div>
            <div class="uk-modal-body" uk-overflow-auto>
                <div class="uk-child-width-1-2@s" uk-grid>
                    <div>
                        <div class="uk-margin">
                            <strong>Body</strong>
                            <form class="uk-grid-small" uk-grid>
                                <div class="uk-width-1-2">
                                   <select id="bodySelect" class="uk-select uk-form-small" required>
                                   </select>
                                </div>
                                <div class="uk-width-1-2">
                                   <input type="hidden" id="jenis_kainidBodyModal" class="uk-input uk-form-small" placeholder="">
                                   <input type="hidden" id="id_produkBodyModal" class="uk-input uk-form-small" placeholder="">
                                   <input type="hidden" id="nama_produkBodyModal" class="uk-input uk-form-small" placeholder="">
                                   <input type="hidden" id="hargModal" class="uk-input uk-form-small" placeholder="">
                                   <input type="hidden" id="warnaModal" class="uk-input uk-form-small" placeholder="">
                                   <input type="number" id="qtyBodyModal" class="uk-input uk-form-small" placeholder="Masukkan qty" required>
                                </div>
                            </form>
                        </div>
                        <div class="uk-margin">
                            <strong>Aksesoris</strong>
                            <form class="uk-grid-small" uk-grid>
                                <div class="uk-width-1-2">
                                   <select id="aksesorisSelect" class="uk-select uk-form-small" required>
                                   </select>
                                </div>
                                <div class="uk-width-1-2">
                                   <input type="number" id="qtyAscModal" class="uk-input uk-form-small" placeholder="Masukkan qty">
                                </div>
                            </form>
                            <span class="uk-text-meta"><span class="uk-margin-small-right" uk-icon="icon: info; ratio: 0.75"></span>Pembelian rib min. 5% dari pembelian body</span>
                        </div>
                    </div>
                    <div>
                        <table class="rz-table-vertical">
                            <tr>
                                <th>Total Body</th>
                                <td class="uk-text-right" id="total_bodyQty"></td>
                                <td class="uk-text-right" id="total_hargabody"></td>
                                <input type="hidden" id="total_hargavaluebody" class="uk-input uk-form-small">
                            </tr>
                            <tr>
                                <th>Total Aksesoris</th>
                                <td class="uk-text-right" id="total_ascQty"></td>
                                <td class="uk-text-right" id="total_hargaasc"></td>
                                <input type="hidden" id="total_hargavalueasc" class="uk-input uk-form-small">
                            </tr>
                            <tr>
                                <th>Total Bayar <span uk-icon="icon: info; ratio: 0.75" uk-tooltip="Harga yang tertera masih bersifat estimasi, harga dan berat yang sudah fixed akan diinformasikan pada halaman konfirmasi pesanan"></span></th>
                                <td></td>
                                <td class="uk-text-right uk-text-bold" id="total_hargasm"></td>
                                <input type="hidden" id="total_harga" class="uk-input uk-form-small">
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="uk-modal-footer uk-text-right">
                <button class="uk-button uk-button-default uk-modal-close" type="button">Batal</button>
                <button type="button" onclick="addToCart()" class="uk-button uk-button-primary" id="addToCartButton">
                    <span id="addToCartText">Tambah</span>
                    <i id="addToCartLoading" class="ph ph-spinner ph-spin ph-lg custom-spin" style="display: none;"></i>
                </button>
            </div>
    
        </div>
    </div>

    <div id="modalPaymentOK" class="uk-flex-top" uk-modal>
        <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical uk-text-center">

            <button class="uk-modal-close-default" type="button" uk-close></button>
            <p>Terimakasih atas pesanan Anda</p>
            <a href="{{ route('pesanan.index') }}" class="uk-button uk-button-primary">OK</a>
        </div>
    </div>
    @if(session('success'))
    @push('script')
        <script>
            notif('success', 'Terimakasih. Pesanan Anda sudah terkirim. Kami akan memeriksa ketersediaan barang tersebut, dan akan menyampaikan informasi kepada Anda.');
        </script>
    @endpush
    @endif

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
                // console.log(id + ' - ' + jenis_kain_id + ' - ' + nama_kain);

                $('#judulmodal-fo').text(nama_kain)
                $('#judullebar-fo').text(nama_lebar)
                $('#judulgramasi-fo').text(nama_gramasi)
                $('#judulwarna-fo').text(nama_warna)
                $('#warnaModal').val(warna_id);

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
                        // $('#hargModal').val(harga_produk);
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