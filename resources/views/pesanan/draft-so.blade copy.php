<x-app-layout>
    <section id="pageContent" class="uk-section" uk-height-viewport="offset-bottom: 20">
        <div class="uk-container">
            <div class="uk-margin-large uk-grid-large" uk-grid>
                @include('layouts.inc.sidebar')
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
                                        @foreach($pesanan['details'] as $key => $p)
                                            @if($p->bagian == "body")
                                                @php
                                                    $typeId = $p->tipe_kain->id;
                                                    $firstItem = true;
                                                @endphp

                                                @if(!isset($groupedBodyItems[$typeId]))
                                                    <div class="rz-checkout-item">
                                                        <dl>
                                                            <dt>{{ $p->tipe_kain->jenis_kain->nama }}</dt>
                                                            <dd>{{ $p->tipe_kain->nama }} - {{ $p->tipe_kain->lebar->keterangan }}/{{ $p->tipe_kain->gramasi->nama }} - {{ $p->tipe_kain->warna->nama }}</dd>
                                                        </dl>
                                                        @foreach($pesanan['details'] as $subKey => $subP)
                                                            @if($subP->bagian == "body" && $subP->tipe_kain->id == $typeId)
                                                                @php
                                                                    if($subP->satuan == "ROLL"){
                                                                        $harga = $subP->qty * $subP->tipe_kain->harga_roll * $subP->tipe_kain->qty_roll;
                                                                    }else{
                                                                        $harga = $subP->qty * $subP->tipe_kain->harga_ecer;
                                                                    }
                                                                    $totalHargaBody += $harga;
                                                                @endphp
                                                                <div class="uk-flex uk-flex-between">
                                                                    <div class="uk-text-small">
                                                                        {{ $subP->qty }} {{ $subP->satuan }}
                                                                    </div>
                                                                    <div class="uk-text-bold">
                                                                        Rp. {{ number_format($harga) }}
                                                                    </div>
                                                                </div>
                                                            @endif
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
                                                    $hargaItemAksesoris = ($p->tipe_kain->harga_ecer + $hargaEcerBody) * $p->qty;
                                                    $totalHargaAksesoris  += $hargaItemAksesoris;
                                                @endphp
                                                <div class="rz-checkout-item">
                                                    <dl>
                                                        <dt>{{ $p->tipe_kain->nama }}</dt>
                                                        <dd>{{ $p->tipe_kain->warna->nama }}</dd>
                                                    </dl>
                                                    <div class="uk-flex uk-flex-between">
                                                        <div class="uk-text-small">
                                                            {{ $p->qty }} {{ $p->satuan }}
                                                        </div>
                                                        <div class="uk-text-bold">
                                                            Rp.{{ number_format($totalHargaAksesoris) }}
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
                                                    Rp. {{ number_format($ongkir) }}
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                    
                                    <article class="rz-values-horizontal uk-text-small">
                                        <dl>
                                            <dt>Total</dt>
                                            <dd>Rp.{{ number_format($totalHargaBody + $totalHargaAksesoris + $ongkir) }}</dd>
                                        </dl>
                                    </article>
                                    <div class="uk-margin-medium-top">
                                        <div class="uk-flex uk-flex-between" uk-grid>

                                            <div>
                                                <a href="#modalPembatalan" class="uk-button uk-button-secondary" uk-toggle>Batalkan</a>
                                            </div>
                                            <!-- ini button dynamic, akan berubah sesuai status, please read instructions -->
                                            <div>
                                                <a href="#" class="uk-button uk-button-primary"><i class="ph-light ph-printer uk-margin-small-right"></i>Cetak</a>
                                            </div>
                                        </div>

                                    </div>                
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="rz-detail-order" id="page-detail-so">
                        <div class="uk-flex uk-flex-between">
                            <div>
                                <h3><i class="ph-light ph-receipt rz-icon"></i>Sales Order</h3>
                            </div>
                            <div>
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
                                <div class="rz-order-container">
                                    <h5>Invoice No.</h5>
                                    <ul class="uk-list uk-list-collapse" uk-switcher="connect: .whoa">
                                        @foreach($no_pesanan as $n)
                                        <li><a href="#body{{ $n->id }}">{{ $n->nomor }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                                
                            </div>
                            <div class="uk-width-1-2@s">
                                <div class="uk-switcher whoa">
                                    @foreach($no_pesanan as $n)
                                    <div id="response_body_{{ $n->id }}"></div>
                                    @endforeach

                                    <div class="rz-order-container" id="tabs-active">
                                        <div class="uk-flex uk-flex-between">
                                            <h5>Rincian Pembelian</h5>
                                            <div>{{ $pesanan['nomor'] }}</div>
                                        </div>

                                        

                                        <article class="rz-values-horizontal uk-text-small">
                                            <dl>
                                                <dt>Total</dt>
                                                {{-- <dd>{{ number_format($total) }}</dd> --}}
                                            </dl>
                                            <dl>
                                                <dt>DP</dt>
                                                {{-- <dd>{{ $pesanan['dp'] ?? 0 }}</dd> --}}
                                            </dl>
                                            <hr>
                                            <dl>
                                                <dt>Sisa Pembayaran</dt>
                                                <dd class="uk-text-bold">
                                                    @php
                                                        // $grand_total = $total - ($pesanan['dp'] ?? 0);
                                                    @endphp
                                                    {{-- {{ number_format($grand_total) }} --}}
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

                                </div>
                                
                            </div>
                        </div>
    
                    </div>
                    
    
                    
                    <div id="card-container">
                        @include('cards')
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
        $(document).ready(function() {
            
            $('#tabs-active').show();
            $('ul.uk-list li a').on('click', function(e) {
                e.preventDefault();
                var href = $(this).attr('href');
                var id = href.split('#body')[1];
                $.ajax({
                    url: '{{ route("get-bodyinvoice", ":id") }}'.replace(':id', id),
                    type: 'GET',
                    success: function(response) {
                        $('#tabs-active').hide();
                        $('#response_body_' + id).html(response);
                    },
                    error: function(xhr) {
                        // Handle error
                    }
                });
            });
        });
    </script>
    @endpush
    @push('script')
        <script>
            // var paymentDp = document.getElementById("payment-dp");
            // var paymentLunas = document.getElementById("payment-lunas");
            //     paymentDp.style.display = "block";
            //     paymentLunas.style.display = "none";
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