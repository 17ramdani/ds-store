<x-app-layout>

    <section id="navbarSecondary" class="uk-flex uk-flex-middle uk-flex-left">
        <div class="uk-width-1-1">
            <div class="uk-container">
                <h2 class="rz-text-pagetitle">Pesanan</h2>
            </div>

        </div>

    </section>


    <section class="uk-margin-medium">
        <div class="uk-container">
            <div class="rz-panel">
                <h3>Detail Pesanan</h3>
                <div class="uk-child-width-1-2@s uk-grid-large" uk-grid>
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
                                <th>Target Pesanan</th>
                                <td class="uk-table-shrink">:</td>
                                <td>{{ date_format(date_create($pesanan['target_pesanan']), 'd-M-y') }}</td>
                            </tr>
                            <tr>
                                <th>Status Pesanan</th>
                                <td class="uk-table-shrink">:</td>
                                <td>
                                    {{ $pesanan['status']['keterangan'] ?? '-' }}
                                </td>
                            </tr>

                            @if (
                                $pesanan['status_pesanan_id'] == 5 &&
                                    DB::table('customer_experiences')->where('pesanan_id', $pesanan['id'])->exists())
                                <tr>
                                    <th>Rating</th>
                                    <td class="uk-table-shrink">:</td>
                                    <td>
                                        <div class="stars">
                                            @php
                                                $customer_experience = DB::table('customer_experiences')
                                                    ->where('pesanan_id', $pesanan['id'])
                                                    ->first();
                                            @endphp
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $customer_experience->star)
                                                    <i class="ph-star-fill active"></i>
                                                @else
                                                    <i class="ph-star-fill"></i>
                                                @endif
                                            @endfor
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Testimonial</th>
                                    <td class="uk-table-shrink">:</td>
                                    <td>
                                        <textarea rows="3" id="pre_testi" class="uk-textarea" readonly>{{ $customer_experience->message }}</textarea>
                                        <input type="hidden" id="testi" name="testi"
                                            value="{{ $customer_experience->message }}">
                                    </td>
                                </tr>
                            @endif
                        </table>
                        @if ($pesanan['status_pesanan_id'] == 4 || $pesanan['status_pesanan_id'] == 5)
                            @if (!DB::table('customer_experiences')->where('pesanan_id', $pesanan['id'])->exists())
                                <div class="uk-margin-medium-top">
                                    <a href="#modalPesananDone" class="uk-button uk-button-primary uk-border-rounded"
                                        uk-toggle>Konfirmasi Pesanan Diterima</a>
                                </div>
                            @endif
                        @endif

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
                                    if ($detail['satuan'] == 'KG') {
                                        // $dharga = $detail['tipe_kain']['harga_ecer'];
                                        $dharga = $detail['harga'];
                                    } else {
                                        // $dharga = $detail['tipe_kain']['harga_roll'];
                                        $dharga = $detail['harga'];
                                    }

                                    if ($detail['satuan'] == 'KG') {
                                        $subtotal1 = $detail['qty_act'] * $dharga;
                                    } elseif ($detail['satuan'] == 'ROLL') {
                                        $subtotal1 = $detail['qty_act'] * $dharga;
                                    } elseif ($detail['satuan'] == 'LOT') {
                                        $subtotal1 = $detail['qty_act'] * (12 * 25) * $dharga;
                                    } else {
                                        $subtotal1 = $detail['qty_act'] * $dharga;
                                    }

                                    $subtotal = $subtotal1 - ($subtotal1 * $detail['total_disc']) / 100;
                                    $total += $subtotal;
                                    $jum_qty = $detail['qty_act'];
                                    // $harga = $detail['harga'] == 0 ? $detail['tipe_kain']['harga_final'] : $detail['harga'];
                                    // $subtotal = ($detail['qty'] ?? 0) * $harga;
                                    // $total += $subtotal;
                                @endphp
                                <tr>
                                    <td>{{ $detail['tipe_kain']['kode'] }}</td>
                                    <td>{{ $detail['tipe_kain']['nama'] }}</td>
                                    <td>{{ $detail['tipe_kain']['gramasi']['nama'] }}</td>
                                    <td>{{ $detail['tipe_kain']['lebar']['keterangan'] }}</td>
                                    <td>{{ $detail['warna_pesanan']['nama'] }}</td>
                                    <td>{{ $detail['qty'] }}</td>
                                    <td>{{ $detail['qty_act'] }}</td>
                                    <td>{{ $detail['satuan'] }}</td>
                                    <td>{{ number_format($dharga) }}</td>
                                    <td>{{ number_format($subtotal) }}</td>
                                </tr>
                            @endforeach


                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" rowspan="4">
                                    @if ($pesanan['status_pesanan_id'] == 3)
                                        <div class="uk-margin-medium-top">
                                            Notes : “Harga yang tercantum belum termasuk biaya Ongkis Kirim”
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4"></td>
                                <td>Total</td>
                                <td class="uk-text-right">{{ number_format($total) }}</td>
                            </tr>
                            <tr>
                                <td colspan="4"></td>
                                <td>DP</td>
                                <td class="uk-text-right">{{ $pesanan['dp'] ?? 0 }}</td>
                            </tr>
                            <tr>
                                <td colspan="4"></td>
                                <td>Grand Total</td>
                                <td class="uk-text-right">
                                    @php
                                        $grand_total = $total - ($pesanan['dp'] ?? 0);
                                    @endphp
                                    {{ number_format($grand_total) }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="uk-margin-medium">
                    @if ($pesanan['status_pesanan_id'] == 2)
                        <a href="{{ route('pesanan.checkout', $pesanan['id']) }}"
                            class="uk-button uk-border-rounded uk-button-primary">Lanjutkan Pesanan</a>
                    @endif
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


</x-app-layout>
