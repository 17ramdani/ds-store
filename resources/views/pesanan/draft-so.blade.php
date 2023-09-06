<x-app-layout>
    <section id="pageContent" class="uk-section" uk-height-viewport="offset-bottom: 20">
        <div class="uk-container">
            <div class="uk-margin-large uk-grid-large" uk-grid>
                @include('layouts.inc.app-sidebar')
                <!-- Contains uk-width-1-4@s. Don't screw up! -->
                <div class="uk-width-3-4@s">
                    @php
                        $status_pesananid = $pesanan['status_pesanan_id'];
                        
                        if ($status_pesananid == '1') {
                            $text_status_pesanan = 'Tunggu Konfirmasi';
                            $status_warna = 'warning';
                        } elseif ($status_pesananid == '2') {
                            $text_status_pesanan = 'Tunggu Pembayaran';
                            $status_warna = 'warning';
                        } elseif ($status_pesananid == '3') {
                            $text_status_pesanan = 'Pesanan Diproses';
                            $status_warna = 'info';
                        } elseif ($status_pesananid == '4') {
                            $text_status_pesanan = 'Pesanan Diantar';
                            $status_warna = 'info';
                        } elseif ($status_pesananid == '5') {
                            $text_status_pesanan = 'Pesanan Selesai';
                            $status_warna = 'success';
                        } elseif ($status_pesananid == '6') {
                            $text_status_pesanan = 'Pesanan Batal';
                            $status_warna = 'danger';
                        } else {
                            $text_status_pesanan = 'N/A';
                            $status_warna = 'warning';
                        }
                    @endphp

                    <div class="rz-detail-order">
                        <div class="" uk-grid>
                            <div class="uk-width-expand@s">
                                <h3><i class="ph-light ph-receipt rz-icon"></i>Sales Order</h3>
                            </div>
                            <div class="uk-width-auto@s">
                                <div>{{ $pesanan['nomor'] }}</div>
                                <span class="uk-label uk-label-{{ $status_warna }}">{{ $text_status_pesanan }}</span>
                            </div>
                        </div>

                        <div class="uk-margin-medium-top" uk-grid>
                            <div class="uk-width-1-2@s">
                                <div class="rz-order-container uk-margin-medium">
                                    <h5>Alamat Pengiriman</h5>
                                    <dl>
                                        <dt>{{ $pesanan['penerima'] }}</dt>
                                        <dd>{{ $pesanan['alamat_kirim'] }}</dd>
                                    </dl>
                                </div>

                            </div>
                            <div class="uk-width-1-2@s">
                                <div class="rz-order-container">
                                    <h5>Rincian Pembelian</h5>
                                    <article>
                                        {{-- body --}}
                                        {{-- @dd($pesanan); --}}
                                        @php
                                            $total = 0;
                                            $total_ongkir = $pesanan['ongkir'] ?? 0;
                                            $subtotal = 0;
                                            $subtotalAfterDisc = 0;
                                            $totalDisc = 0;
                                            // $groupedDetails = collect($pesanan['details'])->groupBy(function ($item) {
                                            //     return $item['tipe_kain_id'];
                                            // });
                                            $groupedDetails = collect($pesanan['details'])->groupBy('tipe_kain_id');
                                            // dd($groupedDetails);
                                            // $displayed_names = array();
                                        @endphp
                                        {{-- @foreach ($pesanan['details'] as $d) --}}
                                        @foreach ($groupedDetails as $tipe_kain_id => $d)
                                            @php
                                                $firstDetail = $d->first();
                                                
                                                $tipe_kain_id = $firstDetail['tipe_kain_id'];
                                                $pesanan_id = $firstDetail['pesanan_id'];
                                                
                                                $satuan = $firstDetail['satuan'];
                                                $bagian = $firstDetail['bagian'];
                                                // $satuan_harga   = $satuan;
                                                $qty = $firstDetail['qty'];
                                                $customer_cat = $pesanan['customer']['customer_category_id'];
                                                // if($satuan != "ROLL"){
                                                //     $satuan_harga = "ECER";
                                                // }
                                            @endphp
                                            @if ($bagian == 'body')
                                                @php
                                                    $data = App\Models\Barang\TipeKain::with('jenis_kain', 'lebar', 'gramasi', 'warna', 'satuan')
                                                        ->where('id', $tipe_kain_id)
                                                        ->firstOrFail();
                                                    $jenis_kain = $data['jenis_kain']['nama'];
                                                    $nama_kain = $data['nama'];
                                                    $gramasi = $data['gramasi']['nama'];
                                                    $warna_kain = $data['warna']['nama'];
                                                    $qty_roll = $data['qty_roll'];
                                                    
                                                @endphp
                                                <div class="rz-checkout-item">
                                                    <dl>
                                                        {{-- @if (!in_array($jenis_kain, $displayed_names)) --}}
                                                        @php
                                                            // $displayed_names[] = $jenis_kain;
                                                        @endphp
                                                        <dt>{{ $jenis_kain }}</dt>
                                                        <dd>{{ $nama_kain }} - {{ $gramasi }} -
                                                            {{ $warna_kain }}</dd>
                                                        {{-- @endif --}}
                                                    </dl>
                                                    @php
                                                        $qs = App\Models\Pesanan\DetailPesanan::with([
                                                            'tipe_kain' => ['satuan'],
                                                        ])
                                                            ->where([['pesanan_id', $pesanan_id], ['tipe_kain_id', $tipe_kain_id]])
                                                            // ->select('qty','satuan')
                                                            ->get();
                                                        // dd($qs);
                                                    @endphp
                                                    @foreach ($qs as $q)
                                                        @php
                                                            $satuan_harga = $q->satuan;
                                                            $tpkid = $q->tipe_kain_id;
                                                            $kty = $q->qty;
                                                            $disc = $q->total_disc ?? 0;
                                                            $jenis_disc = $q->jenis_disc;
                                                            if ($q->satuan == 'ROLL') {
                                                                $satuanpake = 'ROLL';
                                                            } else {
                                                                $satuanpake = $q->tipe_kain->satuan->keterangan;
                                                            }
                                                            
                                                            $maxperiode = DB::table('tipe_kain_prices')
                                                                ->where([['tipe_kain_id', $tpkid], ['tipe', $satuan_harga], ['customer_category_id', $customer_cat]])
                                                                ->MAX('periode');
                                                            
                                                            $daharga = DB::table('tipe_kain_prices')
                                                                ->where([['tipe_kain_id', $tpkid], ['tipe', $satuan_harga], ['customer_category_id', $customer_cat], ['periode', $maxperiode]])
                                                                ->first();
                                                            
                                                            $harga = $daharga->harga;
                                                            
                                                            if ($satuanpake == 'ROLL') {
                                                                $subtotal = $harga * $qty_roll * $kty;
                                                                $satuan_view = 'ROLL';
                                                                if ($jenis_disc == 'Persen') {
                                                                    $totalDisc = ($subtotal * $disc) / 100;
                                                                } else {
                                                                    $totalDisc = $disc;
                                                                }
                                                            } else {
                                                                $subtotal = $harga * $kty;
                                                                $satuan_view = $data['satuan']['keterangan'];
                                                                if ($jenis_disc == 'Persen') {
                                                                    $totalDisc = ($subtotal * $disc) / 100;
                                                                } else {
                                                                    $totalDisc = $disc;
                                                                }
                                                            }
                                                            $subtotal = $subtotal - $totalDisc;
                                                            $total += $subtotal;
                                                        @endphp
                                                        <div class="uk-flex uk-flex-between">
                                                            <div class="uk-text-small">
                                                                {{ $kty }} {{ $satuanpake }}

                                                            </div>
                                                            <div class="uk-text-bold">
                                                                Rp. {{ number_format($subtotal) }}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                @php
                                                    $data = App\Models\Barang\TipeKainAccessories::where('id', $tipe_kain_id)->first();
                                                    $idasc = $data['tipe_kain_id'];
                                                    $maxperiode = DB::table('tipe_kain_prices')
                                                        ->where([['tipe_kain_id', $idasc], ['tipe', $satuan_harga], ['customer_category_id', $customer_cat]])
                                                        ->MAX('periode');
                                                    
                                                    $data = DB::table('tipe_kain_accessories as tka')
                                                        ->leftJoin('accessories as acs', 'acs.id', '=', 'tka.accessories_id')
                                                        ->leftJoin('tipe_kain_prices as tkp', 'tkp.tipe_kain_id', '=', 'tka.tipe_kain_id')
                                                        ->where([['tka.id', $tipe_kain_id], ['tkp.tipe_kain_id', $idasc], ['tkp.tipe', $satuan_harga], ['tkp.customer_category_id', $customer_cat], ['tkp.periode', $maxperiode]])
                                                        ->selectRaw('tka.id,acs.name,acs.harga_roll,acs.harga_ecer,tkp.harga')
                                                        ->first();
                                                    
                                                    $namaAccess = $data->name;
                                                    $harga_roll = $data->harga_roll;
                                                    $harga_ecer = $data->harga_ecer;
                                                    $harga_bdy = $data->harga;
                                                    $disc = $firstDetail['total_disc'] ?? 0;
                                                    $jenis_disc = $firstDetail['jenis_disc'];
                                                    
                                                    $harga = $harga_bdy + $harga_roll;
                                                    if ($satuan != 'ROLL') {
                                                        $harga = $harga_bdy + $harga_ecer;
                                                    }
                                                    $subtotal = $harga * $qty;
                                                    if ($jenis_disc == 'Persen') {
                                                        $totalDisc = ($subtotal * $disc) / 100;
                                                    } else {
                                                        $totalDisc = $disc;
                                                    }
                                                    $subtotal = $subtotal - $totalDisc;
                                                    $total += $subtotal;
                                                @endphp
                                                <div class="rz-checkout-item">
                                                    <dl>
                                                        <dt>{{ $namaAccess }}</dt>
                                                        <dd>{{ $warna_kain }}</dd>
                                                    </dl>
                                                    <div class="uk-flex uk-flex-between">
                                                        <div class="uk-text-small">
                                                            {{ $qty }} {{ 'KG' }}
                                                        </div>
                                                        <div class="uk-text-bold">
                                                            Rp. {{ number_format($subtotal) }}
                                                        </div>
                                                    </div>

                                                </div>
                                            @endif
                                        @endforeach
                                        <div class="rz-checkout-item">
                                            <div class="uk-flex uk-flex-between">
                                                <div class="uk-text-small">
                                                    <i class="ph-fill ph-truck uk-margin-small-right"></i>Ongkos Kirim
                                                </div>
                                                <div class="uk-text-bold">
                                                    Rp. {{ $total_ongkir }}
                                                </div>
                                            </div>
                                            <div class="uk-flex uk-flex-between">
                                                <div class="uk-text-small">
                                                    <i class="ph-fill ph-wallet uk-margin-small-right"></i>Deposit
                                                </div>
                                                <div class="uk-text-bold">
                                                    Rp. 0
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                    <article class="rz-values-horizontal uk-text-small">
                                        <dl>
                                            <dt>Total</dt>
                                            <dd>Rp. {{ number_format($total + $total_ongkir) }}</dd>
                                        </dl>
                                    </article>

                                    @if ($pesanan['status_pesanan_id'] == 2)
                                        {{-- <a href="#" class="uk-button uk-button-primary"><i class="ph-light ph-printer uk-margin-small-right"></i>Cetak</a> --}}
                                        <div class="uk-margin">
                                            <h5>Pembayaran</h5>
                                            <li>

                                                <div id="payment-lunas-1">
                                                    <form action="{{ route('upload.bt', $pesanan['id']) }}"
                                                        method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="uk-margin">
                                                            <div class="js-upload" uk-form-custom>
                                                                <input type="file" name="image_bt" id="image_bt"
                                                                    aria-label="Custom controls"
                                                                    accept="image/png, image/jpeg, image/gif"
                                                                    onchange="showPreview(event)" required>
                                                                <input type="hidden" name="jenis_bukti"
                                                                    value="pelunasan">
                                                                <button class="uk-button uk-button-default"
                                                                    type="button" tabindex="-1">Upload Bukti
                                                                    Pelunasan</button>

                                                            </div>
                                                            <div class="uk-margin">
                                                                <div uk-alert>
                                                                    <ul
                                                                        class="uk-list uk-list-collapse uk-list-divider">
                                                                        Mohon lakukan pembayaran ke no rekening ini
                                                                        <li>Mandiri <b>1300070077899</b> a.n Dunia
                                                                            Sandang Pratama</li>
                                                                        <li>BRI <b>215501000319305</b> a.n Dunia
                                                                            Sandang Pratama</li>
                                                                        <li>IBK <b>040000137701001</b> a.n Dunia
                                                                            Sandang Pratama</li>
                                                                        <li>BCA PT <b>1571138889</b> a.n Dunia
                                                                            Sandang Pratama</li>
                                                                        <li>BNI <b>1322332229</b> a.n Dunia Sandang
                                                                            Pratama PT</li>
                                                                    </ul>
                                                                </div>

                                                            </div>
                                                            <div id="preview uk-margin">
                                                                <br>
                                                                <label for="">Preview :</label>
                                                                <a class="uk-inline" id="link-preview"
                                                                    href="#modalPreview" uk-toggle>
                                                                    <img id="image-preview2"
                                                                        class="uk-object-cover uk-margin" width="200"
                                                                        height="200" style="aspect-ratio: 1 / 1"
                                                                        alt="bukti Pelunasan">
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="uk-child-width-1-3 uk-grid-small" uk-grid>
                                                            <div>
                                                                <a class="uk-button uk-button-secondary uk-button-small"
                                                                    uk-toggle href="#modalPembatalan">Batalkan</a>
                                                            </div>
                                                            <div></div>
                                                            <div class="uk-flex uk-flex-right">
                                                                <button type="button" onclick="resetPreview()"
                                                                    class="uk-button uk-button-primary uk-button-small uk-margin-small-right">Reset</button>
                                                                <button
                                                                    class="uk-button uk-button-primary uk-button-small uk-margin-small-right">Konfirmasi</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>

                                            </li>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>


                </div>

            </div>
        </div>
    </section>
    <div id="modalPembatalan" class="uk-flex-top" uk-modal>
        <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">


            <button class="uk-modal-close-default" type="button" uk-close></button>


            <h4>Pembatalan Pesanan</h4>
            <form class="uk-form-stacked" method="POST" action="{{ route('batalkan-pesanan') }}">
                @csrf
                <div class="uk-margin">
                    <label class="uk-form-label">Alasan Pembatalan</label>
                    <div class="uk-form-controls">
                        <input type="hidden" name="id_so" value="{{ $pesanan['id'] }}">
                        <select class="uk-select uk-form-small">
                            <option>Harga tidak cocok</option>
                            <option>Target pesanan lama</option>
                            <option>Ganti barang</option>
                            <option>Lainnya</option>
                        </select>
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label">Keterangan</label>
                    <div class="uk-form-controls">
                        <textarea rows="3" class="uk-textarea"></textarea>
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label">Kritik &amp; Saran</label>
                    <div class="uk-form-controls">
                        <textarea rows="3" class="uk-textarea"></textarea>
                    </div>
                </div>
                <div class="uk-margin-top uk-text-right">
                    <button
                        type="button"class="uk-button uk-button-default uk-margin-right uk-modal-close">Batal</button>
                    <button type="submit" class="uk-button uk-button-primary">Konfirmasi</button>
                </div>

            </form>


        </div>
    </div>


    <div id="modalPaymentOK" class="uk-flex-top" uk-modal>
        <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical uk-text-center">

            <button class="uk-modal-close-default" type="button" uk-close></button>
            <p>Terimakasih atas pesanan Anda</p>
            <button type="button" uk-close class="uk-button uk-button-primary">OK</button>
        </div>
    </div>
    <div id="modalPreview" class="uk-flex-top" uk-modal>
        <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical uk-text-center">

            <button class="uk-modal-close-default" type="button" uk-close></button>
            <img id="image-preview2" class="uk-object-cover uk-margin" alt="bukti transfer">

        </div>
    </div>
    @push('css')
        <style>
            #preview img {
                display: none;
            }
        </style>
    @endpush
    @push('script')
        <script>
            function togglePaymentOptions(event) {
                var selectedValue = event.target.value;
                var paymentDp = document.getElementById("payment-dp");
                var paymentLunas = document.getElementById("payment-lunas");

                if (selectedValue === "dp") {
                    paymentDp.style.display = "block";
                    paymentLunas.style.display = "none";
                } else if (selectedValue === "lunas") {
                    paymentDp.style.display = "none";
                    paymentLunas.style.display = "block";
                }
            }


            function showPreview(event) {
                if (event.target.files.length > 0) {
                    var src = URL.createObjectURL(event.target.files[0]);

                    // var preview = document.getElementById("image-preview");
                    var preview2 = document.getElementById("image-preview2");
                    // preview.src = src;
                    preview2.src = src;
                    // preview.style.display = "block";

                    preview2.style.display = "block";
                }
            }

            function resetPreview() {

                // var preview = document.getElementById("image-preview");
                var preview2 = document.getElementById("image-preview2");
                // preview.src = "";
                // preview.style.display = "none";

                preview2.src = "";
                preview2.style.display = "none";
            }
        </script>
        @if (session('success'))
            <script>
                UIkit.modal('#modalPaymentOK').show();
            </script>
        @endif
    @endpush

</x-app-layout>
