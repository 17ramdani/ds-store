<x-app-layout>
    <section id="pageContent" class="uk-section" uk-height-viewport="offset-bottom: 20">
        <div class="uk-container">
            <div class="uk-margin-large uk-grid-large" uk-grid>
                @include('layouts.inc.app-sidebar')
                <!-- Contains uk-width-1-4@s. Don't screw up! -->
                <div class="uk-width-3-4@s">
                    @php
                    $status_pesananid = $pesanan['status_pesanan_id'];

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
                                        <dt>{{ $pesanan['customer']['nama'] }}</dt>
                                        <dd>{{ $pesanan['alamat_kirim'] }}</dd>
                                    </dl>
                                </div>
                                
                            </div>
                            <div class="uk-width-1-2@s">
                                <div class="rz-order-container">
                                    <h5>Rincian Pembelian</h5>
                                    <article>
                                        <!-- Grouping untuk Bagian Body -->
                                        @php
                                            $ongkir = $pesanan['ongkir'] ?? 0;
                                            $totalHarga = 0;
                                            $totalHargaBody = 0;
                                            $totalHargaAksesoris = 0;
                                            $groupedBodyItems = [];
                                            $hargaEcerBody = $pesanan['details']->where('bagian', 'body')->first()->tipe_kain->harga_ecer ?? 0;
                                        @endphp
                                        @dd($pesanan['details']);
                                        @foreach($pesanan['details'] as $key => $p)
                                            @if($p->bagian == "body")
                                                @php
                                                    $typeId = $p->tipe_kain->id;
                                                    $firstItem = true;
                                                @endphp

                                                @if(!isset($groupedBodyItems[$typeId]))
                                                    <div class="rz-checkout-item">
                                                        <dl>
                                                            {{-- <dt>{{ $p->tipe_kain->jenis_kain->nama }}</dt>
                                                            <dd>{{ $p->tipe_kain->nama }} - {{ $p->tipe_kain->lebar->keterangan }}/{{ $p->tipe_kain->gramasi->nama }} - {{ $p->tipe_kain->warna->nama }}</dd> --}}
                                                        </dl>
                                                        @foreach($pesanan['details'] as $subKey => $subP)
                                                            {{-- @if($subP->bagian == "body" && $subP->tipe_kain->id == $typeId) --}}
                                                                @php

                                                                    // if(isset($subP->qty_act)){
                                                                    //     if($subP->qty_act >= $subP->tipe_kain->qty_roll){
                                                                    //         $satuan = "ROLL";
                                                                    //         $qtyna  = $subP->qty."ROLL";
                                                                    //     }else{
                                                                    //         $satuan = $subP->satuan;
                                                                    //         $qtyna = $subP->qty.$subP->satuan;
                                                                    //     }

                                                                    //     if($satuan == "ROLL"){
                                                                    //         $harga = $subP->qty_act * $subP->tipe_kain->harga_roll;
                                                                    //     }else{
                                                                    //         $harga = $subP->qty_act * $subP->tipe_kain->harga_ecer;
                                                                    //     }
                                                                    //     $totalHargaBody += $harga;
                                                                    // }else{
                                                                    //     if($subP->satuan == "ROLL"){
                                                                    //         $qtyna = $subP->qty.$subP->satuan;
                                                                    //         $harga = $subP->qty * $subP->tipe_kain->harga_roll * $subP->tipe_kain->qty_roll;
                                                                    //     }else{
                                                                    //         $qtyna = $subP->qty.$subP->satuan;
                                                                    //         $harga = $subP->qty * $subP->tipe_kain->harga_ecer;
                                                                    //     }
                                                                    //     $totalHargaBody += $harga;
                                                                    // }
                                                                @endphp
                                                                <div class="uk-flex uk-flex-between">
                                                                    <div class="uk-text-small">
                                                                        {{-- {{ $qtyna }} --}}
                                                                    </div>
                                                                    <div class="uk-text-bold">
                                                                        {{-- Rp. {{ number_format($harga) }} --}}
                                                                    </div>
                                                                </div>
                                                            {{-- @endif --}}
                                                        @endforeach
                                                    </div>
                                                @endif
                                                @php
                                                    $groupedBodyItems[$typeId] = true;
                                                @endphp
                                            @endif
                                        @endforeach
                                    
                                        <!-- Grouping untuk Aksesoris -->
                                        @foreach($pesanan['details'] as $key => $p)
                                            @if($p->bagian != "body")
                                                @php
                                                    // $hargaItemAksesoris = ($p->tipe_kain->harga_ecer + $hargaEcerBody) * $p->qty;
                                                    // $totalHargaAksesoris  += $hargaItemAksesoris;
                                                @endphp
                                                <div class="rz-checkout-item">
                                                    <dl>
                                                        {{-- <dt>{{ $p->tipe_kain->nama }}</dt>
                                                        <dd>{{ $p->tipe_kain->warna->nama }}</dd> --}}
                                                    </dl>
                                                    <div class="uk-flex uk-flex-between">
                                                        <div class="uk-text-small">
                                                            {{-- {{ $p->qty }} {{ $p->satuan }} --}}
                                                        </div>
                                                        <div class="uk-text-bold">
                                                            {{-- Rp.{{ number_format($totalHargaAksesoris) }} --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    
                                        <!-- Ongkos Kirim -->
                                        <div class="rz-checkout-item">
                                            <div class="uk-flex uk-flex-between">
                                                <div class="uk-text-small">
                                                    <i class="ph-fill ph-truck uk-margin-small-right"></i>Ongkos Kirim
                                                </div>
                                                <div class="uk-text-bold">
                                                    {{-- Rp. {{ number_format($ongkir) }} --}}
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                    
                                    <article class="rz-values-horizontal uk-text-small">
                                        <dl>
                                            <dt>Total</dt>
                                            {{-- <dd>Rp.{{ number_format($totalHargaBody + $totalHargaAksesoris + $ongkir) }}</dd> --}}
                                        </dl>
                                    </article>
                                    @if($pesanan['status_pesanan_id'] == 2)
                                        {{-- <a href="#" class="uk-button uk-button-primary"><i class="ph-light ph-printer uk-margin-small-right"></i>Cetak</a> --}}
                                    <div class="uk-margin">
                                        <h5>Pembayaran</h5>
                                        <li>

                                            @if($pesanan['customer']['customer_category_id'] == 3)
                                            {{-- <div class="uk-margin">
                                                <select class="uk-select" onchange="togglePaymentOptions(event)" required>
                                                    <option value="">--PILIH--</option>
                                                    <option value="dp">Bayar Menggunakan DP</option>
                                                    <option value="lunas">Bayar Lunas</option>
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

                                            </div> --}}
                                            @else
                                            <div id="payment-lunas-1">
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
                                                        <div class="uk-margin">
                                                            <div>
                                                                <ul class="uk-list uk-list-collapse uk-list-divider">
                                                                    Mohon lakukan pembayaran ke no rekening ini
                                                                    <li>Mandiri <b>1300070077899</b> a.n Dunia Sandang Pratama</li>
                                                                    <li>BRI <b>215501000319305</b> a.n Dunia Sandang Pratama</li>
                                                                    <li>IBK <b>040000137701001</b> a.n Dunia Sandang Pratama</li>
                                                                    <li>BCA PT <b>1571138889</b> a.n Dunia Sandang Pratama</li>
                                                                    <li>BNI <b>1322332229</b> a.n Dunia Sandang Pratama PT</li>
                                                                </ul>
                                                            </div>
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
                                            @endif

                                        </li>
                                    </div>
                                    @else

                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>         
            </div>
        </div>
    </section>


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