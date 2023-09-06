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
                            <div class="uk-width-auto@s uk-text-right@s">
                                <div>{{ $pesanan['nomor'] }}</div>
                                <span class="uk-label uk-label-{{ $status_warna }}">{{ $text_status_pesanan }}</span>
                                @if ($pesanan['status_pesanan_id'] == 5)
                                    <div class="uk-margin">
                                        <div class="stars">
                                            <i class="ph-fill ph-star"></i>
                                            <i class="ph-fill ph-star"></i>
                                            <i class="ph-fill ph-star"></i>
                                            <i class="ph-fill ph-star"></i>
                                            <i class="ph-fill ph-star"></i>

                                        </div>

                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="uk-margin-medium-top" uk-grid>
                            <div class="uk-width-1-2@s">
                                <div class="rz-order-container uk-margin-medium">
                                    <h5>Alamat Pengiriman</h5>
                                    <dl>
                                        <dt>{{ $pesanan['customer']['nama'] }}</dt>
                                        <dd>{{ $pesanan['alamat_kirim'] }}</dd>
                                    </dl>
                                </div>

                                @if ($pesanan['status_pesanan_id'] == 4 || $pesanan['status_pesanan_id'] == 5)
                                    <div class="rz-order-container">
                                        <h5>Rincian Pengiriman</h5>
                                        <dl>
                                            <dt>Armada</dt>
                                            <dd>{{ $delivery->armada ?? '-' }}</dd>
                                        </dl>
                                        <dl>
                                            <dt>Tanggal Pengiriman</dt>
                                            <dd>
                                                @if (isset($delivery->created_at))
                                                    {{ date_format(date_create($delivery->created_at), 'd/m/Y') }}
                                                @else
                                                    {{ '-' }}
                                                @endif
                                            </dd>
                                        </dl>
                                        <dl>
                                            <dt>Status Pengiriman</dt>
                                            <dd>{{ $delivery->status ?? '-' }}</dd>
                                        </dl>
                                        <dl>
                                            <dt>No. Resi / Link Pengiriman</dt>
                                            <dd>{{ $delivery->no_resi ?? '-' }}</dd>
                                        </dl>
                                        <dl>
                                            <dt>Bukti Pengiriman</dt>
                                            <dd><a href="#modalBuktiKirim" uk-toggle>View</a></dd>
                                        </dl>
                                    </div>
                                @endif


                            </div>
                            <div class="uk-width-1-2@s">
                                <div class="rz-order-container">
                                    <h5>Rincian Pembelian</h5>
                                    <article>
                                        @php
                                            $total = 0;
                                            $total_ongkir = $pesanan['ongkir'] ?? 0;
                                            $subtotalAfterDisc = 0;
                                            $totalDisc = 0;
                                            $groupedDetails = collect($pesanan['details'])->groupBy('tipe_kain_id');
                                        @endphp
                                        @foreach ($groupedDetails as $tipe_kain_id => $d)
                                            @php
                                                $firstDetail = $d->first();
                                                $tipe_kain_id = $firstDetail['tipe_kain_id'];
                                                $pesanan_id = $firstDetail['pesanan_id'];
                                                $satuan = $firstDetail['satuan'];
                                                $bagian = $firstDetail['bagian'];
                                                $qty = $firstDetail['qty'];
                                                $qty_act = $firstDetail['qty_act'];
                                                $harga_detail = $firstDetail['harga'];
                                                $customer_cat = $pesanan['customer']['customer_category_id'];
                                                $qtyna = $qty;
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
                                                        <dt>{{ $jenis_kain }}</dt>
                                                        <dd>{{ $nama_kain }} - {{ $gramasi }} -
                                                            {{ $warna_kain }}</dd>
                                                    </dl>
                                                    @php
                                                        $qs = App\Models\Pesanan\DetailPesanan::with([
                                                            'tipe_kain' => ['satuan'],
                                                        ])
                                                            ->where([['pesanan_id', $pesanan_id], ['tipe_kain_id', $tipe_kain_id]])
                                                            ->get();
                                                        // dd($qs);
                                                    @endphp
                                                    @foreach ($qs as $q)
                                                        @php
                                                            $satuan_harga = $q->satuan;
                                                            $tpkid = $q->tipe_kain_id;
                                                            $kty = $q->qty;
                                                            $kty_act = $q->qty_act;
                                                            $disc = $q->total_disc ?? 0;
                                                            $jenis_disc = $q->jenis_disc;
                                                            
                                                            if ($q->satuan == 'ROLL') {
                                                                $satuanpake = 'ROLL';
                                                            } else {
                                                                $satuanpake = $q->tipe_kain->satuan->keterangan;
                                                            }
                                                            $maxperiode = DB::table('tipe_kain_prices')
                                                                ->where([['tipe_kain_id', $tipe_kain_id], ['tipe', $satuan_harga], ['customer_category_id', $customer_cat]])
                                                                ->MAX('periode');
                                                            
                                                            $harga = $q->harga;
                                                            $subtotal = $harga * $kty;
                                                            if ($satuan_harga == 'ROLL') {
                                                                $subtotal = $harga * $kty_act * $kty;
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
                                                {{-- accessories --}}
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
                                                    $disc2 = $firstDetail['total_disc'] ?? 0;
                                                    $jenis_disc2 = $firstDetail['jenis_disc'];
                                                    
                                                    $subtotal = $harga_detail * $qty_act;
                                                    if ($jenis_disc2 == 'Persen') {
                                                        $totalDisc = ($subtotal * $disc2) / 100;
                                                    } else {
                                                        $totalDisc = $disc2;
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
                                            @if ($pesanan['customer']['customer_category_id'] == 3)
                                                @if (isset($pesanan['bukti_pelunasan']))
                                                    <li>
                                                        <div class="uk-margin">
                                                            <select class="uk-select"
                                                                onchange="togglePaymentOptions(event)" required>
                                                                <option value="">--PILIH--</option>
                                                                @if ($pesanan['customer']['customer_category_id'] == 3)
                                                                    <option value="dp">Bayar Menggunakan DP</option>
                                                                    <option value="lunas">Bayar Lunas</option>
                                                                @else
                                                                    <option value="lunas">Bayar Lunas</option>
                                                                @endif
                                                            </select>
                                                        </div>
                                                        <div id="payment-dp" style="display: none;">
                                                            <form action="{{ route('upload.bt', $pesanan['id']) }}"
                                                                method="post" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('PATCH')
                                                                <div class="uk-margin">
                                                                    <div class="js-upload" uk-form-custom>
                                                                        <input type="file" name="image_bt"
                                                                            id="image_bt" aria-label="Custom controls"
                                                                            accept="image/png, image/jpeg, image/gif"
                                                                            onchange="showPreview(event)" required>
                                                                        <input type="hidden" name="jenis_bukti"
                                                                            value="dp">
                                                                        <button class="uk-button uk-button-default"
                                                                            type="button" tabindex="-1">Upload Bukti
                                                                            DP</button>
                                                                    </div>
                                                                    <div id="preview uk-margin">
                                                                        <br>
                                                                        <label for="">Preview :</label>
                                                                        <a class="uk-inline" id="link-preview"
                                                                            href="#modalPreview" uk-toggle>
                                                                            <img id="image-preview"
                                                                                class="uk-object-cover uk-margin"
                                                                                width="200" height="200"
                                                                                style="aspect-ratio: 1 / 1"
                                                                                alt="bukti dp">
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="uk-child-width-1-3 uk-grid-small" uk-grid>
                                                                    <div>
                                                                        <a class="uk-button uk-button-secondary uk-button-small"
                                                                            href="#">Batalkan</a>
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
                                                        <div id="payment-lunas" style="display: none;">
                                                            <form action="{{ route('upload.bt', $pesanan['id']) }}"
                                                                method="post" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('PATCH')
                                                                <div class="uk-margin">
                                                                    <div class="js-upload" uk-form-custom>
                                                                        <input type="file" name="image_bt"
                                                                            id="image_bt" aria-label="Custom controls"
                                                                            accept="image/png, image/jpeg, image/gif"
                                                                            onchange="showPreview(event)" required>
                                                                        <input type="hidden" name="jenis_bukti"
                                                                            value="pelunasan">
                                                                        <button class="uk-button uk-button-default"
                                                                            type="button" tabindex="-1">Upload Bukti
                                                                            Pelunasan</button>
                                                                    </div>
                                                                    <div id="preview uk-margin">
                                                                        <br>
                                                                        <label for="">Preview :</label>
                                                                        <a class="uk-inline" id="link-preview"
                                                                            href="#modalPreview" uk-toggle>
                                                                            <img id="image-preview2"
                                                                                class="uk-object-cover uk-margin"
                                                                                width="200" height="200"
                                                                                style="aspect-ratio: 1 / 1"
                                                                                alt="bukti Pelunasan">
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="uk-child-width-1-3 uk-grid-small" uk-grid>
                                                                    <div>
                                                                        <a class="uk-button uk-button-secondary uk-button-small"
                                                                            href="#">Batalkan</a>
                                                                    </div>
                                                                    <div></div>
                                                                    <div class="uk-flex uk-flex-right">
                                                                        <button type="button"
                                                                            onclick="resetPreview()"
                                                                            class="uk-button uk-button-primary uk-button-small uk-margin-small-right">Reset</button>
                                                                        <button
                                                                            class="uk-button uk-button-primary uk-button-small uk-margin-small-right">Konfirmasi</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </li>
                                                @else
                                                    <div>
                                                        <dl>
                                                            <dt>Bukti Transfer:</dt>
                                                            <dd><img src="{{ $pesanan['bukti_pelunasan'] }}"
                                                                    alt=""></dd>
                                                        </dl>
                                                        <dl>
                                                            <dt>Catatan Admin:</dt>
                                                            <dd>{{ $pesanan['catatan_cs'] }}</dd>
                                                        </dl>
                                                        <div class="uk-flex uk-flex-between" uk-grid>
                                                            @if ($pesanan['status_pesanan_id'] == 4)
                                                                <div>
                                                                    <button
                                                                        class="uk-button uk-button-primary uk-button-small uk-margin-small-right"
                                                                        href="#modalPesananDone" uk-toggle><span
                                                                            class="uk-margin-small-right"
                                                                            uk-icon="check"></span> Konfirmasi Pesanan
                                                                        diterima</button>
                                                                </div>
                                                            @elseif($pesanan['status_pesanan_id'] == 5)
                                                                <div>
                                                                    <a href="{{ route('komplain.create', $pesanan['id']) }}"
                                                                        class="uk-button uk-button-secondary">Komplain</a>
                                                                </div>
                                                                <div>
                                                                    <a href="#"
                                                                        class="uk-button uk-button-primary"><i
                                                                            class="ph-fill ph-star uk-margin-small-right"></i>Beri
                                                                        Penilaian</a>
                                                                </div>
                                                            @endif
                                                        </div>

                                                    </div>
                                                @endif
                                        </div>
                                    @else
                                        @if (isset($pesanan['bukti_pelunasan']))
                                            <li>
                                                <div class="uk-margin">
                                                    <select class="uk-select" onchange="togglePaymentOptions(event)"
                                                        required>
                                                        <option value="">--PILIH--</option>
                                                        @if ($pesanan['customer']['customer_category_id'] == 3)
                                                            <option value="dp">Bayar Menggunakan DP</option>
                                                            <option value="lunas">Bayar Lunas</option>
                                                        @else
                                                            <option value="lunas">Bayar Lunas</option>
                                                        @endif
                                                    </select>

                                                </div>
                                                <div id="payment-dp" style="display: none;">
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
                                                                    value="dp">
                                                                <button class="uk-button uk-button-default"
                                                                    type="button" tabindex="-1">Upload Bukti
                                                                    DP</button>
                                                            </div>
                                                            <div id="preview uk-margin">
                                                                <br>
                                                                <label for="">Preview :</label>
                                                                <a class="uk-inline" id="link-preview"
                                                                    href="#modalPreview" uk-toggle>
                                                                    <img id="image-preview"
                                                                        class="uk-object-cover uk-margin"
                                                                        width="200" height="200"
                                                                        style="aspect-ratio: 1 / 1" alt="bukti dp">
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="uk-child-width-1-3 uk-grid-small" uk-grid>
                                                            <div>
                                                                <a class="uk-button uk-button-secondary uk-button-small"
                                                                    href="#">Batalkan</a>
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
                                                <div id="payment-lunas" style="display: none;">
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
                                                            <div id="preview uk-margin">
                                                                <br>
                                                                <label for="">Preview :</label>

                                                                <a class="uk-inline" id="link-preview"
                                                                    href="#modalPreview" uk-toggle>
                                                                    <img id="image-preview2"
                                                                        class="uk-object-cover uk-margin"
                                                                        width="200" height="200"
                                                                        style="aspect-ratio: 1 / 1"
                                                                        alt="bukti Pelunasan">

                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="uk-child-width-1-3 uk-grid-small" uk-grid>
                                                            <div>

                                                                <a class="uk-button uk-button-secondary uk-button-small"
                                                                    href="#">Batalkan</a>
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
                                        @else
                                            <div>
                                                <dl>
                                                    <dt>Bukti Transfer:</dt>
                                                    <dd><img src="{{ $pesanan['bukti_transfer'] }}" alt="">
                                                    </dd>

                                                </dl>
                                                <dl>
                                                    <dt>Catatan Admin:</dt>
                                                    <dd>{{ $pesanan['catatan_cs'] }}</dd>
                                                </dl>
                                                <div class="uk-flex uk-flex-between" uk-grid>

                                                    @if ($pesanan['status_pesanan_id'] == 4)
                                                        <div>
                                                            <button
                                                                class="uk-button uk-button-primary uk-button-small uk-margin-small-right"
                                                                href="#modalPesananDone" uk-toggle><span
                                                                    class="uk-margin-small-right"
                                                                    uk-icon="check"></span> Konfirmasi Pesanan
                                                                diterima</button>
                                                        </div>
                                                    @elseif($pesanan['status_pesanan_id'] == 5)
                                                        <div>
                                                            <a href="{{ route('komplain.create', $pesanan['id']) }}"
                                                                class="uk-button uk-button-secondary">Komplain</a>
                                                        </div>
                                                        <div>
                                                            <a href="#" class="uk-button uk-button-primary"><i
                                                                    class="ph-fill ph-star uk-margin-small-right"></i>Beri
                                                                Penilaian</a>

                                                        </div>
                                                    @endif
                                                </div>

                                            </div>

                                        @endif
                                    @endif
                                @else
                                    <div>
                                        @php
                                            $bukti = $pesanan['bukti_pelunasan'];
                                        @endphp
                                        <dl>
                                            <dt>Bukti Transfer:</dt>
                                            <dd><img src="{{ $bukti }}" alt=""></dd>
                                        </dl>
                                        <dl>
                                            <dt>Catatan Admin:</dt>
                                            <dd>{{ $pesanan['catatan_cs'] }}</dd>
                                        </dl>
                                        <div class="uk-flex uk-flex-between" uk-grid>

                                            @if ($pesanan['status_pesanan_id'] == 4)
                                                <div>
                                                    <button
                                                        class="uk-button uk-button-primary uk-button-small uk-margin-small-right"
                                                        href="#modalPesananDone" uk-toggle><span
                                                            class="uk-margin-small-right" uk-icon="check"></span>
                                                        Konfirmasi Pesanan diterima</button>
                                                </div>
                                            @elseif($pesanan['status_pesanan_id'] == 5)
                                                <div>
                                                    <a href="{{ route('komplain.create', $pesanan['id']) }}"
                                                        class="uk-button uk-button-secondary">Komplain</a>
                                                </div>
                                                {{-- <div>
                                                    <a href="#" class="uk-button uk-button-primary"><i class="ph-fill ph-star uk-margin-small-right"></i>Beri Penilaian</a>

                                                </div> --}}
                                            @endif
                                        </div>
                                    </div>
                                    @endif
                                </div>

                            </div>


                        </div>
                    </div>

                    @if ($pesanan['status_pesanan_id'] == 5)
                        {{-- <div class="rz-detail-order uk-margin-top uk-text-right">
                            <a href="{{ route('retur.create', $pesanan['id']) }}"
                                class="uk-button uk-button-primary">Retur</a>
                        </div> --}}
                    @endif

                </div>
            </div>
        </div>
    </section>

    <div id="modalPesananDone" class="uk-flex-top" uk-modal>
        <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical uk-text-center">

            <button class="uk-modal-close-default" type="button" uk-close></button>

            <p>Terimakasih atas konfirmasi Anda. Jangan lupa untuk memberikan rating dan testimonial Anda untuk semakin
                meningkatkan pelayanan kami untuk Anda </p>
            <form action="{{ route('pesanan.done', $pesanan['id']) }}" method="post">
                @csrf
                @method('PATCH')
                <button type="submit" class="uk-button uk-button-primary">OK</button>
            </form>
            {{-- <a href="{{ route('pesanan.rating', $pesanan['id']) }}" class="uk-button uk-button-primary">OK</a> --}}

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

    <div id="modalBuktiKirim" class="uk-flex-top" uk-modal>
        <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">

            <button class="uk-modal-close-default" type="button" uk-close></button>
            <h5>Bukti Kirim</h5>
            @php
                $file_resi = $delivery->file_resi ?? '-';
                $file_resi_exploded = explode('.', $file_resi);
                $file_resi_ext = end($file_resi_exploded);
            @endphp
            @if ($file_resi_ext == 'pdf')
                <iframe src="{{ $file_resi }}" width="100%" height="800"></iframe>
            @else
                <img src="{{ $file_resi }}" alt="resi">
            @endif

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
            $(document).ready(function() {

            });
        </script>
    @endpush
    @push('script')
        <script>
            // ---- ---- Const ---- ---- //
            const stars = document.querySelectorAll('.stars i');
            const starsNone = document.querySelector('.rating-box');

            // ---- ---- Stars ---- ---- //
            stars.forEach((star, index1) => {
                star.addEventListener('click', () => {
                    stars.forEach((star, index2) => {
                        // ---- ---- Active Star ---- ---- //
                        index1 >= index2 ?
                            star.classList.add('active') :
                            star.classList.remove('active');
                    });
                });
            });
        </script>
        <script>
            var paymentDp = document.getElementById("payment-dp");
            var paymentLunas = document.getElementById("payment-lunas");
            paymentDp.style.display = "block";
            paymentLunas.style.display = "none";

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

                } else {

                    paymentDp.style.display = "block";
                    paymentLunas.style.display = "none";
                }
            }


            function showPreview(event) {
                if (event.target.files.length > 0) {
                    var src = URL.createObjectURL(event.target.files[0]);
                    var preview = document.getElementById("image-preview");
                    var preview2 = document.getElementById("image-preview2");
                    preview.src = src;
                    preview2.src = src;
                    preview.style.display = "block";
                    preview2.style.display = "block";
                }
            }

            function resetPreview() {
                var preview = document.getElementById("image-preview");
                var preview2 = document.getElementById("image-preview2");
                preview.src = "";
                preview.style.display = "none";
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
