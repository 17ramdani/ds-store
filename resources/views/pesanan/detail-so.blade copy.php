<x-guest-new-layout>
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

                                    <!-- Invoice#1 -->
                                    <div class="rz-order-container" id="tabs-active">
                                        <div class="uk-flex uk-flex-between">
                                            <h5>Rincian Pembelian</h5>
                                            <div>{{ $pesanan['nomor'] }}</div>
                                        </div>
                                        
    
                                        <article>
                                            @php
                                                $total = 0;
                                                $prevItemName = '';
                                                $prevColorName = '';
                                            @endphp
                                        
                                            @foreach ($pesanan['details'] as $i => $detail)
                                                @php
                                                    // if (isset($detail['qty_act'])) {
                                                    //     $qty_na = $detail['qty_act'];
                                                    //     $dharga = $detail['harga'];
                                                    // } else {
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
                                                    // }
                                                    
                                                    if ($detail['satuan'] == 'KG') {
                                                        $subtotal1 = $qty_na * $dharga;
                                                    } elseif ($detail['satuan'] == 'ROLL') {
                                                        $subtotal1 = $qty_na * 25 * $dharga;
                                                    } elseif ($detail['satuan'] == 'LOT') {
                                                        $subtotal1 = $qty_na * (12 * 25) * $dharga;
                                                    } else {
                                                        $subtotal1 = $qty_na * $dharga;
                                                    }
                                        
                                                    $subtotal = $subtotal1 - ($subtotal1 * $detail['total_disc']) / 100;
                                                    $total += $subtotal;
                                                    $jum_qty = $detail['qty_act'];
                                                @endphp
                                        
                                                <div class="rz-checkout-item">
                                                    <dl>
                                                        <dt>
                                                            @if ($prevItemName != $detail['tipe_kain']['nama'])
                                                                {{ $detail['tipe_kain']['nama'] }}
                                                            @endif
                                                        </dt>
                                                        <dd>
                                                            @if ($prevItemName != $detail['tipe_kain']['nama'] || $prevColorName != $detail['warna_pesanan']['nama'])
                                                                {{ $detail['warna_pesanan']['nama'] }}
                                                            @endif
                                                        </dd>
                                                    </dl>
                                                    <div class="uk-flex uk-flex-between">
                                                        <div class="uk-text-small">
                                                            {{-- @if($detail['qty_act'])
                                                                {{ $detail['qty_act'] }} {{ $detail['satuan'] }}
                                                            @else --}}
                                                                {{ $detail['qty'] }} {{ $detail['satuan'] }}
                                                            {{-- @endif --}}
                                                        </div>
                                                        <div class="uk-text-bold">
                                                            {{ number_format($subtotal) }}
                                                        </div>
                                                    </div>
                                                </div>
                                        
                                                @php
                                                    $prevItemName = $detail['tipe_kain']['nama'];
                                                    $prevColorName = $detail['warna_pesanan']['nama'];
                                                @endphp
                                            @endforeach
                                        </article>
                                        
                                        <article class="rz-values-horizontal uk-text-small">
                                            <dl>
                                                <dt>Total</dt>
                                                <dd>{{ number_format($total) }}</dd>
                                            </dl>
                                            <dl>
                                                <dt>DP</dt>
                                                <dd>{{ number_format($pesanan['dp']) ?? 0 }}</dd>
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
                                            <div id="preview uk-margin">
                                                <br>
                                                @if($pesanan['customer']['customer_category_id'] == 3)
                                                
                                                @else
                                                <a class="uk-inline" id="link-preview" href="#modalPreview" uk-toggle>
                                                    <img src="{{ asset('storage/bt/' . $pesanan['bukti_transfer']) }}" class="uk-object-cover uk-margin" width="200"
                                                        height="200" style="aspect-ratio: 1 / 1" alt="bukti Pelunasan">
                                                </a>
                                                
                                                @endif
                                            </div>
                                            <div class="uk-child-width-1-2 uk-grid-small uk-margin-medium-top" uk-grid>
                                                    
                                                <div>
                                                    @if($pesanan['status_pesanan_id'] == 5)
                                                    <a href="#modalPembatalan" class="uk-button uk-button-small uk-button-secondary" uk-toggle>Beri Penilaian</a>
                                                    @endif
                                                </div>
                                                <!-- ini button dynamic, akan berubah sesuai status, please read instructions -->
                                                <div>
                                                    @if($pesanan['status_pesanan_id'] == 4)
                                                    <button class="uk-button uk-button-primary uk-button-small uk-margin-small-right" href="#modalPesananDone" uk-toggle>Pesanan diterima</button>
                                                    @endif
                                                </div>
                                            </div>
    
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

    <div id="modalPesananDone" class="uk-flex-top" uk-modal>
        <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical uk-text-center">

            <button class="uk-modal-close-default" type="button" uk-close></button>

            <p>Terimakasih atas konfirmasi Anda. Jangan lupa untuk memberikan rating dan testimonial Anda untuk semakin
                meningkatkan pelayanan kami untuk Anda</p>
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
                } else{
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

</x-guest-new-layout>