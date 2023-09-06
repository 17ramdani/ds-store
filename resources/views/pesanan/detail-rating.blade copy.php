<x-app-layout>
    <section class="uk-margin-medium">
        <div class="uk-container">
            <div class="rz-panel">
                <h3>Detail Pesanan</h3>
                <div class="uk-child-width-1-2@s uk-grid-medium" uk-grid>
                    <div>
                        <table class="rz-table-vertical">
                            <tr>
                                <th>No. Pesanan</th>
                                <td class="uk-table-shrink">:</td>
                                <td>{{ $pesanan['nomor'] }}</td>
                            </tr>
                            <tr>
                                <th>No. Invoice</th>
                                <td class="uk-table-shrink">:</td>
                                <td>{{ $pesanan['no_invoice'] }}</td>
                            </tr>
                            <tr>
                                <th>Customer</th>
                                <td class="uk-table-shrink">:</td>
                                <td>{{ $pesanan['customer']['nama'] }}</td>
                            </tr>
                            <tr>
                                <th>Sales</th>
                                <td class="uk-table-shrink">:</td>
                                <td>{{ $pesanan['sales_man']['nama'] ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Catatan Pembayaran</th>
                                <td>:</td>
                                <td>-</td>
                            </tr>
                        </table>
                    </div>
                    <div>
                        <table class="rz-table-vertical">
                            <tr>
                                <th>Jatuh Tempo</th>
                                <td class="uk-table-shrink">:</td>
                                <td>{{ date_format(date_create($pesanan['jatuh_tempo']), 'd-M-y') }}</td>
                            </tr>
                            <tr>
                                <th>Status Pesanan</th>
                                <td class="uk-table-shrink">:</td>
                                <td>
                                    {{ $pesanan['status']['keterangan'] ?? '-' }}
                                </td>
                            </tr>
                            <tr>
                                <th>Rating</th>
                                <td class="uk-table-shrink">:</td>
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
                                <td class="uk-table-shrink">:</td>
                                <td>
                                    <textarea rows="3" id="pre_testi" class="uk-textarea"></textarea>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="uk-overflow-auto uk-margin-medium-top">
                    <h4>Detail Barang</h4>
                    <table class="uk-table uk-table-small uk-table-striped">
                        <thead>
                            <tr>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Grm</th>
                                <th>Lbr</th>
                                <th>Warna</th>
                                <th>Qty Est.</th>
                                <th>Qty Act.</th>
                                <th>Stn</th>
                                <th>Harga</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total = 0;
                            @endphp
                            @foreach ($pesanan['details'] as $detail)
                                @php
                                    // $harga = $detail['harga'] == 0 ? $detail['tipe_kain']['harga_final'] : $detail['harga'];
                                    // $subtotal = ($detail['qty'] ?? 0) * $harga;
                                    // $total += $subtotal;
                                    if($detail['satuan'] == "KG"){
                                        // $dharga = $detail['tipe_kain']['harga_ecer'];
                                        $dharga = $detail['harga'];
                                    }else{
                                        // $dharga = $detail['tipe_kain']['harga_roll'];
                                        $dharga = $detail['harga'];
                                    }

                                    if($detail['satuan'] == "KG"){
                                        $subtotal1  = $detail['qty_act'] * $dharga;
                                    }elseif($detail['satuan'] == "ROLL"){
                                        $subtotal1  = $detail['qty_act'] * $dharga;
                                    }elseif($detail['satuan'] == "LOT"){
                                        $subtotal1  = $detail['qty_act'] * (12 * 25) * $dharga;
                                    }else{
                                        $subtotal1  = $detail['qty_act'] * $dharga;
                                    }

                                    $subtotal   = $subtotal1 - ($subtotal1 * $detail['total_disc'] / 100);
                                    $total += $subtotal;
                                    $jum_qty = $detail['qty_act'];
                                @endphp
                                <tr>
                                    <td>{{ $detail['tipe_kain']['kode'] }}</td>
                                    <td>{{ $detail['tipe_kain']['nama'] }}</td>
                                    <td>{{ $detail['tipe_kain']['gramasi']['nama'] }}</td>
                                    <td>{{ $detail['tipe_kain']['lebar']['keterangan'] }}</td>
                                    <td>{{ $detail['warna_pesanan']['nama'] }}</td>
                                    <td>{{ $detail['qty'] }}</td>
                                    <td>{{ $detail['qty_act'] }}</td>
                                    <td>{{ $detail['satuan']}}</td>
                                    <td>{{ number_format($dharga) }}</td>
                                    <td>{{ number_format($subtotal) }}</td>
                                </tr>
                            @endforeach


                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="8"></td>
                                <td>Total</td>
                                <td class="uk-text-right">{{ number_format($total) }}</td>
                            </tr>
                            <tr>
                                <td colspan="8"></td>
                                <td>DP</td>
                                <td class="uk-text-right">{{ $pesanan['dp'] ?? 0 }}</td>
                            </tr>
                            <tr>
                                <td colspan="8"></td>
                                <td>Grand Total</td>
                                <td class="uk-text-right">
                                    @php
                                        $grand_total = $total - ($pesanan['dp'] ?? 0);
                                    @endphp
                                    {{ number_format($grand_total) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="uk-margin-medium uk-text-right">
                    <form action="{{ route('pesanan.rating.store', $pesanan['id']) }}" method="post">
                        @csrf
                        <input type="text" name="star" id="rating" hidden>
                        <input type="text" name="message" id="testi"hidden>
                        <button type="submit" class="uk-button uk-border-rounded uk-button-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
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
</x-app-layout>
