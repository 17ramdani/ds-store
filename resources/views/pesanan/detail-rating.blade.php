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
                    <div class="rz-detail-order" id="page-rating-so">
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
                                            <tr>
                                                <th>Rating</th>
                                                <td class="uk-table-shrink"></td>
                                                <td>
                                                    <div class="stars">
                                                        <i class="ph-star-fill"></i>
                                                        <i class="ph-star-fill"></i>
                                                        <i class="ph-star-fill"></i>
                                                        <i class="ph-star-fill"></i>
                                                        <i class="ph-star-fill"></i>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Testimonial</th>
                                                <td class="uk-table-shrink"></td>
                                                <td>
                                                    <textarea rows="3" id="pre_testi" class="uk-textarea"></textarea>
                                                </td>
                                            </tr>
                                            <div class="uk-child-width-1-2 uk-grid-small uk-margin-medium-top" uk-grid>
                                                    
                                                <div>
                                                    @if($pesanan['status_pesanan_id'] == 5)
                                                    <a href="#modalPembatalan" class="uk-button uk-button-small uk-button-secondary" uk-toggle>Beri Penilaian</a>
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
            var bintang = 0;
            // ---- ---- Const ---- ---- //
            const stars = document.querySelectorAll('.stars i');
            const starsNone = document.querySelector('.rating-box');

            // ---- ---- Stars ---- ---- //
            stars.forEach((star, index1) => {
                star.addEventListener('click', () => {
                    stars.forEach((star, index2) => {
                        // ---- ---- Active Star ---- ---- //
                        index1 >= index2 ? star.classList.add('active') : star.classList.remove(
                            'active');

                    });
                });
            });

            $('.ph-star-fill').on("click", function() {
                const bintangs = document.querySelectorAll('.stars i.active');
                // alert(bintangs.length)
                $('#rating').val(bintangs.length)
            });
            $('#pre_testi').on("change", function() {
                let value = $(this).val();
                $('#testi').val(value);
            });
        </script>
    @endpush
</x-guest-new-layout>
