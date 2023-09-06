<div class="rz-order-container">
    <div class="uk-flex uk-flex-between">
        <h5>Rincian Pembelian</h5>
        <div>{{ $pesanan['nomor'] }}</div>
    </div>
    <article>
        @php
            $total = 0;
        @endphp
        {{-- @foreach ($pesanan['details'] as $detail) --}}
        @foreach ($pesanan['details'] as $i => $detail)
        @php
        
        if(isset($detail['qty_act'])){
            $qty_na = $detail['qty_act'];
            $dharga = $detail['harga'];
        }else{
            $qty_na = $detail['qty'];
            if ($detail['satuan'] == 'ROLL') {
                $dharga = $detail['tipe_kain']['harga_roll'];
                if ($detail['bagian'] == 'accessories') {
                    $dharga = $pesanan['details'][$i - 1]['tipe_kain']['harga_roll'] + $detail['tipe_kain']['harga_roll'];
                }
            } else {
                $dharga = $detail['tipe_kain']['harga_ecer'];
                if ($detail['bagian'] == 'accessories') {
                    $dharga = $pesanan['details'][$i - 1]['tipe_kain']['harga_ecer'] + $detail['tipe_kain']['harga_ecer'];
                }
            }
        }

        // if(isset($detail['qty_act'])){
        //     $qty_na = $detail['qty_act'];
        //     $dharga = $detail['harga'];
        // }else{
        //     $qty_na = $detail['qty'];
        //     if ($detail['satuan'] == 'KG') {
        //         $dharga = $detail['tipe_kain']['harga_ecer'];
        //     } else {
        //         $dharga = $detail['tipe_kain']['harga_roll'];
        //     }
        // }
        
        if ($detail['satuan'] == 'KG') {
            $subtotal1 = $qty_na * $dharga;
        } elseif ($detail['satuan'] == 'ROLL') {
            $subtotal1 = $qty_na * $dharga;
        } elseif ($detail['satuan'] == 'LOT') {
            $subtotal1 = $qty_na * (12 * 25) * $dharga;
        } else {
            $subtotal1 = $qty_na * $dharga;
        }

        $subtotal = $subtotal1 - ($subtotal1 * $detail['total_disc']) / 100;
        $total += $subtotal;
        $jum_qty = $detail['qty_act'];
        // $harga = $detail['harga'] == 0 ? $detail['tipe_kain']['harga_final'] : $detail['harga'];
        // $subtotal = ($detail['qty'] ?? 0) * $harga;
        // $total += $subtotal;
        @endphp
        <div class="rz-checkout-item">
            @if($detail['bagian'] == "body")
            <dl>
                <dt>Cotton Single Knit</dt> {{-- Ganti jadi nama kategori kain --}}
                <dd>{{ $detail['tipe_kain']['nama'] }} - {{ $detail['warna_pesanan']['nama'] }}</dd>
            </dl>
            @else 
            <dl>
                <dt>{{ $detail['tipe_kain']['nama'] }}</dt>
                <dd>{{ $detail['warna_pesanan']['nama'] }}</dd>
            </dl>
            @endif
            <div class="uk-flex uk-flex-between">
                <div class="uk-text-small">
                    @if($detail['qty_act'])
                        {{ $detail['qty_act'] }}{{ $detail['satuan'] }}
                    @else
                        {{ $detail['qty'] }}{{ $detail['satuan'] }}
                    @endif
                </div>
                <div class="uk-text-bold">
                    {{ number_format($subtotal) }}
                </div>
            </div>
        </div>
        @endforeach
    </article>
    
    <article class="rz-values-horizontal uk-text-small">
        <dl>
            <dt>Total</dt>
            <dd>{{ number_format($total) }}</dd>
        </dl>
        <dl>
            <dt>DP</dt>
            <dd>{{ $pesanan['dp'] ?? 0 }}</dd>
        </dl>
        <hr>
        <dl>
            <dt>Sisa Pembayaran</dt>
            <dd class="uk-text-bold">
                @php
                    $grand_total = $total - ($pesanan['dp'] ?? 0);
                @endphp
                {{ number_format($grand_total) }}
            </dd>
        </dl>
    </article>
    <div class="uk-margin">
        <h5>Metode Pembayaran</h5>
        <ul class="uk-subnav uk-subnav-pill" uk-switcher>
            <li><a href="#">Kontan</a></li>
            <li><a href="#">Financing</a></li>
            <li><a href="#">Tempo</a></li>
        </ul>

        <ul class="uk-switcher uk-margin">
            <li>
                <div class="uk-margin">
                    <select class="uk-select" onchange="togglePaymentOptions(event)" required>
                        <option value="">--PILIH--</option>
                        @if($pesanan['customer']['customer_category_id'] == 3)
                        <option value="dp">Bayar Menggunakan DP</option>
                        <option value="lunas">Bayar Lunas</option>
                        @else
                        <option value="lunas">Bayar Lunas</option>
                        @endif
                    </select>
                </div>  
                <div id="payment-dp" style="display: none;">
                <form action="{{ route('upload.bt', $pesanan['id']) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="uk-margin">
                        <div class="js-upload" uk-form-custom>
                            <input type="file" name="image_bt" id="image_bt" aria-label="Custom controls"
                            accept="image/png, image/jpeg, image/gif" onchange="showPreview(event)"
                            required>
                            <input type="hidden" name="jenis_bukti" value="dp">
                            <button class="uk-button uk-button-default" type="button" tabindex="-1">Upload Bukti DP</button>
                        </div>
                        <div id="preview uk-margin">
                            <br>
                            <label for="">Preview :</label>
                            <a class="uk-inline" id="link-preview" href="#modalPreview" uk-toggle>
                                <img id="image-preview" class="uk-object-cover uk-margin" width="200"
                                    height="200" style="aspect-ratio: 1 / 1" alt="bukti dp">
                            </a>
                        </div>
                    </div>
                    <div class="uk-child-width-1-3 uk-grid-small" uk-grid>
                        <div>
                            <a class="uk-button uk-button-secondary uk-button-small" href="#">Batalkan</a>
                        </div>
                        <div></div>
                        <div class="uk-flex uk-flex-right">
                            <button type="button" onclick="resetPreview()" class="uk-button uk-button-primary uk-button-small uk-margin-small-right">Reset</button>
                            <button class="uk-button uk-button-primary uk-button-small uk-margin-small-right">Konfirmasi</button>
                        </div>
                    </div>
                </form>
                </div>
                <div id="payment-lunas" style="display: none;">
                    <form action="{{ route('upload.bt', $pesanan['id']) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="uk-margin">
                            <div class="js-upload" uk-form-custom>
                                <input type="file" name="image_bt" id="image_bt" aria-label="Custom controls"
                                accept="image/png, image/jpeg, image/gif" onchange="showPreview(event)"
                                required>
                                <input type="hidden" name="jenis_bukti" value="pelunasan">
                                <button class="uk-button uk-button-default" type="button" tabindex="-1">Upload Bukti Pelunasan</button>
                            </div>
                            <div id="preview uk-margin">
                                <br>
                                <label for="">Preview :</label>
                                <a class="uk-inline" id="link-preview" href="#modalPreview" uk-toggle>
                                    <img id="image-preview2" class="uk-object-cover uk-margin" width="200"
                                        height="200" style="aspect-ratio: 1 / 1" alt="bukti Pelunasan">
                                </a>
                            </div>
                        </div>
                        <div class="uk-child-width-1-3 uk-grid-small" uk-grid>
                            <div>
                                <a class="uk-button uk-button-secondary uk-button-small" href="#">Batalkan</a>
                            </div>
                            <div></div>
                            <div class="uk-flex uk-flex-right">
                                <button type="button" onclick="resetPreview()" class="uk-button uk-button-primary uk-button-small uk-margin-small-right">Reset</button>
                                <button class="uk-button uk-button-primary uk-button-small uk-margin-small-right">Konfirmasi</button>
                            </div>
                        </div>
                    </form>
                </div>
            </li>
            <li>
                <div class="uk-margin">
                    <a href="" class="uk-button uk-button-default">Pengajuan Financing</a>
                </div>
                <div class="uk-child-width-1-2 uk-grid-small" uk-grid>
                    
                    <div>
                        <a href="#modalPembatalan" class="uk-button uk-button-secondary" uk-toggle>Batalkan</a>
                    </div>
                    <div>
                        <a href="" class="uk-button uk-button-primary">Konfirmasi</a>
                    </div>
                </div>
            </li>
            <li>
                <form class="uk-form-stacked">
                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-select">Termin</label>
                        <div class="uk-form-controls">
                            <select class="uk-select uk-form-small" id="form-stacked-select">
                                <option>1 kali pembayaran</option>
                                <option>1 kali pembayaran</option>
                            </select>
                        </div>
                    </div>
                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-select">Jatuh Tempo</label>
                        <div class="uk-form-controls">
                            <input type="date" class="uk-input uk-form-small">
                        </div>
                    </div>

                </form>
                <div class="uk-child-width-1-2 uk-grid-small" uk-grid>
                    
                    <div>
                        <a href="#modalPembatalan" class="uk-button uk-button-secondary" uk-toggle>Batalkan</a>
                    </div>
                    <div>
                        <a href="" class="uk-button uk-button-primary">Konfirmasi</a>
                    </div>
                </div>
            </li>
        </ul>

    </div>                
</div>