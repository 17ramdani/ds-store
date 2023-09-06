<x-app-layout>
    <section class="uk-margin-medium">
        <div class="uk-container">
            <div class="rz-panel">
                <h4>Sales Order Done</h4>
                <div class="uk-overflow-auto uk-margin">
                    <table class="uk-table uk-table-small uk-table-divider">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>TANGGAL PESAN</th>
                                <th>No. Pesanan</th>
                                <th>L/GSM</th>
                                <th>QTY</th>
                                <th>HARGA</th>

                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $totHarga = 0;
                            @endphp
                            @foreach ($pesanans as $i => $pesanan)
                            @foreach ($pesanan['details'] as $detail)
                            @php
                            $totHarga += $pesanan['total'] ?? 0;
                            @endphp
                            @endforeach
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ date_format(date_create($pesanan['tanggal_pesanan']), 'd-M-y') }}</td>
                                <td>{{ $pesanan['nomor'] }}</td>
                                <td>-</td>
                                <td>{{ count($pesanan['details']) }}</td>
                                <td>Rp.{{ number_format($pesanan['total']) }}</td>

                                <td><a href="{{ route('pesanan.detail', $pesanan['id']) }}">Detail</a></td>
                            </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
