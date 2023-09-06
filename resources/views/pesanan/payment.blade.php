<x-app-layout>
    <section class="uk-margin-medium">
        <div class="uk-container">
            <div class="rz-panel">
                <h3>Pembayaran</h3>
                <x-alert />
                <div class="uk-margin uk-child-width-1-2@s" uk-grid>
                    <div>
                        <table class="rz-table-vertical">
                            <tr>
                                <th>No. Sales Order</th>
                                <td class="uk-table-shrink">:</td>
                                <td>{{ $pesanan['nomor'] }}</td>
                            </tr>
                            <tr>
                                <th>No. Invoice</th>
                                <td class="uk-table-shrink">:</td>
                                <td>{{ $pesanan['no_invoice'] }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td class="uk-table-shrink">:</td>
                                <td>{{ $pesanan['status']['keterangan'] }}</td>
                            </tr>
                            <tr>
                                <th>Point</th>
                                <td>:</td>
                                <td>{{ $point }} pts</td>
                            </tr>
                            <tr>
                                <th></th>
                                <td></td>
                                <td><label><input class="uk-checkbox" type="checkbox"> Bayar sebagian dengan point</label>
                                </td>
                            </tr>

                        </table>

                    </div>
                    <div>
                        <div class="uk-text-small uk-text-muted">
                            Syarat Ketentuan:
                            <ol>
                                <li>Untuk eceran, Kain yang sudah dibeli, tidak dapat diretur atau dibatalkan</li>
                                <li>Untuk Roll-an, tidak terima retur berupa kain yang sudah di-cutting</li>
                                <li>Batas Maksimal retur 3 hari setelah penerimaan barang, S.JLn retur dari Customer
                                    terlampir</li>
                            </ol>
                        </div>
                    </div>
                </div>

                <table class="uk-table uk-table-small uk-table-divider">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Tipe Pesanan</th>
                            <th>Nama Barang</th>
                            <th>Varian</th>
                            <th>Satuan</th>
                            <th>QTY</th>
                            <th class="uk-text-right">Harga</th>
                            <th class="uk-text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total = 0;
                        @endphp
                        @foreach ($pesanan['details'] as $i => $item)
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
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $pesanan['tipe_pesanan'] }}</td>
                                <td>
                                    <div>{{ $item['tipe_kain']['jenis_kain']['nama'] }}</div>
                                    <div>{{ $item['tipe_kain']['nama'] }}</div>
                                    <div>{{ $item['tipe_kain']['lebar']['keterangan'] }} /
                                        {{ $item['tipe_kain']['gramasi']['nama'] }}</div>
                                </td>
                                <td>{{ $item['warna_pesanan']['nama'] }}</td>
                                <td>{{ $item['satuan'] }}
                                <td>{{ $item['qty_act'] }}</td>
                                </td>
                                <td class="uk-text-right">{{ number_format($item['harga']) }}</td>
                                <td class="uk-text-right">{{ number_format($subtotal) }}</td>
                            </tr>
                        @endforeach

                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6"></td>
                            <td>Total</td>
                            <td class="uk-text-right">{{ number_format($total) }}</td>
                        </tr>
                        <tr>
                            <td colspan="6"></td>
                            <td>DP</td>
                            <td class="uk-text-right">{{ number_format($pesanan['dp']) }}</td>
                        </tr>
                        <tr>
                            <td colspan="6"></td>
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
                <form action="{{ route('upload.bt', $pesanan['id']) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="uk-margin-large" uk-grid>
                        <div class="uk-width-1-2@s">
                            <div class="uk-margin">
                                <div uk-form-custom>
                                    <input type="file" name="image_bt" id="image_bt" aria-label="Custom controls"
                                        accept="image/png, image/jpeg, image/gif" onchange="showPreview(event)"
                                        required>
                                    <button class="uk-button uk-button-default" type="button" tabindex="-1">Upload
                                        Bukti
                                        Transfer</button>
                                </div>
                                <div id="preview uk-margin">
                                    <br>
                                    <label for="">Preview :</label>
                                    <a class="uk-inline" id="link-preview" href="#modalPreview" uk-toggle>
                                        <img id="image-preview" class="uk-object-cover uk-margin" width="200"
                                            height="200" style="aspect-ratio: 1 / 1" alt="bukti transfer">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-1-2@s">
                            <div class="uk-margin uk-text-right@s">
                                <button type="submit" id="button-confirm"
                                    class="uk-button uk-border-rounded uk-button-primary">Konfirmasi
                                    Pembayaran</button>
                            </div>
                        </div>
                    </div>



                </form>
            </div>
        </div>
    </section>

    <div id="modalPaymentOK" class="uk-flex-top" uk-modal>
        <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical uk-text-center">

            <button class="uk-modal-close-default" type="button" uk-close></button>
            <p>Terimakasih atas pesanan Anda</p>
            <a href="{{ route('pesanan.index') }}" class="uk-button uk-button-primary">OK</a>
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
            function showPreview(event) {
                if (event.target.files.length > 0) {
                    var src = URL.createObjectURL(event.target.files[0]);
                    var preview = document.getElementById("image-preview");
                    var preview2 = document.getElementById("image-preview2");
                    preview.src = src;
                    preview2.src = src;
                    preview.style.display = "block";
                }
            }
        </script>
        @if (session('success'))
            <script>
                UIkit.modal('#modalPaymentOK').show();
            </script>
        @endif
    @endpush
</x-app-layout>
