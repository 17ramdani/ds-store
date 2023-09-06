<x-app-layout>
    <section class="uk-margin-medium">
        <div class="uk-container">
            <div class="rz-panel">
                <h3>Checkout</h3>
                <div class="uk-overflow-auto uk-margin-medium-top">
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
                            @foreach ($pesanan['details'] as $item)
                            @php
                            if ($item['satuan'] == 'KG') {
                            // $dharga = $item['tipe_kain']['harga_ecer'];
                            $dharga = $item['harga'];
                            } else {
                            // $dharga = $item['tipe_kain']['harga_roll'];
                            $dharga = $item['harga'];
                            }

                            if ($item['satuan'] == 'KG') {
                            $subtotal1 = $item['qty_act'] * $dharga;
                            } elseif ($item['satuan'] == 'ROLL') {

                            $subtotal1 = $item['qty_act'] * $dharga;

                            } elseif ($item['satuan'] == 'LOT') {
                            $subtotal1 = $item['qty_act'] * (12 * 25) * $dharga;
                            } else {
                            $subtotal1 = $item['qty_act'] * $dharga;
                            }

                            $subtotal = $subtotal1 - ($subtotal1 * $item['total_disc']) / 100;
                            $total += $subtotal;
                            $jum_qty = $item['qty_act'];
                            // $subtotal = ($item['qty'] ?? 0) * ($item['harga'] ?? 0);
                            // $total += $subtotal;
                            @endphp
                            <tr>
                                <td>{{ $item['tipe_kain']['kode'] }}</td>
                                <td>{{ $item['tipe_kain']['nama'] }}</td>
                                <td>{{ $item['tipe_kain']['gramasi']['nama'] }}</td>
                                <td>{{ $item['tipe_kain']['lebar']['keterangan'] }}</td>
                                <td>{{ $item['warna_pesanan']['nama'] }}</td>
                                <td>{{ $item['qty'] }}</td>
                                <td>{{ $item['qty_act'] }}</td>
                                <td>{{ $item['satuan'] }}
                                </td>
                                <td>{{ number_format($item['harga']) }}</td>
                                <td class="uk-text-right">{{ number_format($subtotal) }}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
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
                                <td class="uk-text-right">{{ number_format($pesanan['dp']) }}</td>
                            </tr>
                            <tr>
                                <td colspan="8"></td>
                                <td>Grand Total</td>
                                <td class="uk-text-right">
                                    @php
                                    $grand_total = $total - $pesanan['dp'];
                                    @endphp
                                    {{ number_format($grand_total) }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="uk-margin uk-child-width-1-2@s" uk-grid>
                    <div>
                        <form class="uk-form-stacked">


                            <h5>Metode Pembayaran</h5>
                            <ul class="uk-subnav uk-subnav-pill" uk-switcher>
                                <li><a href="#">Kontan</a></li>
                                <li><a href="#">Financing</a></li>
                                <li><a href="#">Tempo</a></li>
                            </ul>

                            <ul class="uk-switcher uk-margin">
                                <li>
                                    <p class="uk-text-meta">Silahkan melanjutkan ke proses pembayaran </p>
                                    <a href="{{ route('pesanan.payment', $pesanan['id']) }}" class="uk-button uk-button-primary uk-border-rounded">Bayar</a>
                                </li>
                                <li>
                                    <p class="uk-text-meta">Silahkan melanjutkan ke proses pengajuan buyer financing,
                                        dengan
                                        mengisi form berikutnya </p>

                                    <a href="{{ route('financing.add.checkout',$pesanan['id']) }}" class="uk-button uk-button-primary uk-border-rounded">Pengajuan Financing</a>

                                </li>
                                <li>
                                    <select class="uk-select uk-margin-bottom" id="tempo-dropdown">
                                        <option>--Pilih Jatuh Tempo--</option>
                                        <option value="1">1 Hari</option>
                                        <option value="3">3 Hari</option>
                                        <option value="7">7 Hari</option>
                                        <option value="14">14 Hari</option>
                                        <option value="30">30 Hari</option>
                                        <option value="60">60 Hari</option>
                                    </select>
                                    <div class="uk-form-controls">
                                        <label for="tanggal_tempo">Jatuh Tempo</label><br>
                                        <input type="text" class="uk-input" id="tanggal_tempo" name="jatuh_tempo" readonly>
                                    </div>

                                    <br>
                                    <br>
                                    <a href="{{ route('pesanan.payment', $pesanan['id']) }}" class="uk-button uk-button-primary uk-border-rounded">Bayar</a>
                                </li>
                            </ul>


                        </form>
                    </div>
                    <div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    @push('script')
    <script>

        // let linkLanjut = "/pesanan/payment/" + "{{ $pesanan['id'] }}";
        $('input[name="metode"]').on('click', function() {
            let value = $(this).val();
            if (value == "buyfinancing") {
                let linkLanjut = "/financing_checkout" + "{{ $pesanan['id'] }}";
            } else {
                let linkLanjut = "/pesanan/payment/" + "{{ $pesanan['id'] }}";

            }
            $('#button-lanjut').attr('href', linkLanjut);
        });
    </script>
    <script>
        $(document).ready(function() {
            var tanggal_pesanan = "{{ $pesanan->tanggal_pesanan }}";
            $('#tempo-dropdown').change(function() {
                var tempo = $(this).val();
                if (tempo != '') {
                    var tanggal_tempo = new Date(tanggal_pesanan);
                    tanggal_tempo.setDate(tanggal_tempo.getDate() + parseInt(tempo));
                    var formatted_date = tanggal_tempo.getFullYear() + "-" + padZero(tanggal_tempo
                        .getMonth() + 1) + "-" + padZero(tanggal_tempo.getDate());
                    $('#tanggal_tempo').val(formatted_date);
                }
            });

            function padZero(num) {
                if (num < 10) {
                    return "0" + num;
                } else {
                    return num;
                }
            }
        });
    </script>
    @endpush
</x-app-layout>
