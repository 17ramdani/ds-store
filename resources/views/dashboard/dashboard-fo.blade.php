<x-app-layout>
    <section id="pageContent" class="uk-section" uk-height-viewport>
        <div class="uk-container">
            <div class="uk-margin-large uk-grid-large" uk-grid>
                @include('layouts.inc.app-sidebar')
                
                <!-- Contains uk-width-1-4@s. Don't screw up! -->
                <div class="uk-width-3-4@s">
                   
                    <div class="rz-list-container" id="pesanan-index">
                        <div class="rz-panel">
                           <h3><i class="ph-light ph-basket rz-icon"></i>List Pesanan Fresh Order </h3>
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
                                        <div class="rz-cell-label">Tunggu Pembayaran</div>
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
                        
                        $customer_cat    = $dtf['customer']['customer_category_id'];
                        
                        // dd($dtf['details']);
                        @endphp
                        @foreach ($dtf['details'] as $i => $detail)
                        @php
                        $tipe_kain_id   = $detail['tipe_kain_id'];
                        $satuan         = $detail['satuan'];
                        $bagian         = $detail['bagian'];
                        $satuan_harga   = $satuan;
                        if($satuan != "ROLL"){
                            $satuan_harga = "ECER";
                        }

                        
                        if($bagian == "body"){
                            $data       = App\Models\Barang\TipeKain::with('lebar','gramasi','warna','satuan')
                            ->where('id',$tipe_kain_id)->firstOrFail(); 

                            $maxperiode = DB::table("tipe_kain_prices")->where([
                                    ['tipe_kain_id' ,$tipe_kain_id],
                                    ['tipe' ,$satuan_harga],
                                    ['customer_category_id', $customer_cat],
                            ])->MAX('periode');

                            $daharga = DB::table("tipe_kain_prices")->where([
                                    ['tipe_kain_id' ,$tipe_kain_id],
                                    ['tipe' ,$satuan_harga],
                                    ['customer_category_id', $customer_cat],
                                    ['periode', $maxperiode]
                            ])->first();
                            
                            $harga  = $daharga->harga;
                        }else{
                            $data       = App\Models\Barang\TipeKainAccessories::where('id', $tipe_kain_id)->first();
                            $idasc      = $data['tipe_kain_id'];
                            $maxperiode = DB::table("tipe_kain_prices")->where([
                                                ['tipe_kain_id' ,$idasc],
                                                ['tipe' ,$satuan_harga],
                                                ['customer_category_id', $customer_cat],
                                        ])->MAX('periode');

                            $data       = DB::table('tipe_kain_accessories as tka')
                                            ->leftJoin('accessories as acs', 'acs.id', '=', 'tka.accessories_id')
                                            ->leftJoin('tipe_kain_prices as tkp', 'tkp.tipe_kain_id', '=' ,'tka.tipe_kain_id')
                                            ->where([
                                                ['tka.id',$tipe_kain_id],
                                                ['tkp.tipe_kain_id',$idasc],
                                                ['tkp.tipe', $satuan_harga],
                                                ['tkp.customer_category_id',$customer_cat],
                                                ['tkp.periode',$maxperiode]
                                            ])
                                            ->selectRaw('tka.id,acs.harga_roll,acs.harga_ecer,tkp.harga')
                                            ->first();

                            $harga_roll  = $data->harga_roll;
                            $harga_ecer  = $data->harga_ecer;
                            $harga_bdy   = $data->harga;

                            $harga  = $harga_bdy + $harga_roll;
                            if($satuan != "ROLL"){
                                $harga  = $harga_bdy + $harga_ecer;
                            }
                        }

                        // $harga = 0;
                        if ($detail['satuan'] == 'KG') {
                            $subtotal = $detail['qty'] * $harga;
                        } elseif ($detail['satuan'] == 'ROLL') {
                            if($bagian == "body"){
                                $subtotal = $detail['qty'] * $detail['tipe_kain']['qty_roll'] * $harga;
                            }else{
                                $subtotal = $detail['qty'] * $harga;
                            }
                        } elseif ($detail['satuan'] == 'LOT') {
                            $subtotal = $detail['qty'] * (12 * 25) * $harga;
                        } else {
                            $subtotal = $detail['qty'] * $harga;
                        }

                        $total_harga += $subtotal;
                        $status_warna   = "danger";

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
                                @elseif($dtf->status_pesanan_id == 4)
                                    <a href="/detail-so/{{ $dtf->id }}" class="rz-button uk-button-small">Lacak Pengiriman</a>
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

                    </div>
                    
                </div>         
            </div>
        </div>
    </section>

    @if(session('success_pesan'))
    <div id="modalSukses" class="uk-flex-top" uk-modal>
        <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical uk-text-center">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <p>Terimakasih. Pesanan Anda sudah terkirim. Kami akan memeriksa ketersediaan barang tersebut, dan akan menyampaikan informasi kepada Anda.</p>
            <button class="uk-button uk-button-primary uk-modal-close" type="button">OK</button>
        </div>
    </div>
    @endif
    @include('modal-add-tocart')
    @push('script')
        @if (session('success_pesan'))
            <script>
                UIkit.modal('#modalSukses').show();
            </script>
        @endif
        <script>
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
                            var id_product      = data.datas.id;
                            var nama_kain       = data.datas.nama;
                            var gramasi         = data.datas.gramasi.nama;
                            var lebar           = data.datas.lebar.keterangan;
                            var warna           = data.datas.warna.nama;
                            var harga_product   = data.datas.harga_ecer;
                            var qty_roll        = data.datas.qty_roll;
                            var bagian          = data.datas.bagian;
                            var warna_id        = data.datas.warna_id;

                            let optvalue = "";
                            let optasc = "";
                            let info = "";

                            $('#satuan-body').empty();
                            $('#satuan-accessories').empty();
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
                            $('#val-asesoris').val('');
                            
                            $("#use-max-acs").prop("checked", false);
                            
                            optasc += `<option value="">--PILIH--</option>`;
                            $.each(data.asc, function(i, item) {
                                info = item.nama.substring(0, 3);
                                optasc += `<option value="${item.id}">${item.nama}</option>`;
                            });
                            if(info === "RIB"){
                                $('#info-asesoris').text("Pembelian rib min. 5% dari pembelian body")
                            }else if(info === "BUR"){
                                $('#info-asesoris').text("Pembelian bur min. 20% dari pembelian body")
                            }else if(info === "KER"){
                                $('#info-asesoris').text("Pembelian Kerah dan Manset min. 22% dari pembelian body")
                            }else{
                                $('#info-asesoris').text("")
                            }
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