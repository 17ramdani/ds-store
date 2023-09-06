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
                <x-alert />
                <div class="uk-margin uk-text-right"><a href="{{ route('pesanan.add') }}" class="uk-button uk-button-primary uk-border-rounded"><span class="uk-margin-small-right" uk-icon="plus-circle"></span>Pesanan baru</a></div>
                <div class="uk-child-width-1-6@l uk-child-width-1-3 uk-grid-small uk-margin-medium" uk-grid>
                    <div>
                        <div class="rz-cell-alt">
                            <div class="rz-cell-value">{{ $count->sts_0 }}</div>
                            <div class="rz-cell-label">Total Pesanan</div>
                        </div>
                    </div>
                    <div>
                        <div class="rz-cell-alt">
                            <div class="rz-cell-value">{{ $count->sts_1 }}</div>
                            <div class="rz-cell-label"><a href="{{ route('draft.index') }}">Tunggu Konfirmasi</a></div>
                        </div>
                    </div>
                    <div>
                        <div class="rz-cell-alt">
                            <div class="rz-cell-value">{{ $count->sts_2 }}</div>
                            <div class="rz-cell-label"><a href="{{ route('invoicing.index') }}">Tunggu Pembayaran</a>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="rz-cell-alt">
                            <div class="rz-cell-value">{{ $count->sts_3 }}</div>
                            <div class="rz-cell-label">Pesanan Diproses</div>
                        </div>
                    </div>
                    <div>
                        <div class="rz-cell-alt">
                            <div class="rz-cell-value">{{ $count->sts_4 }}</div>
                            <div class="rz-cell-label">Pesanan Diantar</div>
                        </div>
                    </div>
                    <div>
                        <div class="rz-cell-alt">
                            <div class="rz-cell-value">{{ $count->sts_5 }}</div>
                            <div class="rz-cell-label"><a href="{{ route('done.index') }}">Pesanan Selesai</a></div>
                        </div>
                    </div>
                </div>
                <div class="uk-overflow-auto uk-margin">
                    <table class="uk-table uk-table-small uk-table-divider">
                        <thead>
                            <tr>
                                <th>No SO</th>
                                <th>Tgl Pesanan</th>
                                <th>Total Item</th>
                                {{-- <th>Total QTY</th> --}}
                                <th>Total Harga</th>
                                <th>Status SO</th>
                                <!-- <th>Target Proses</th> -->
                                <th>Target Pesanan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pesanans as $i => $item)
                            @php
                            $total_item = count($item['details']);
                            $total_qty = 0;
                            $total_harga = 0;
                            @endphp
                            @foreach ($item['details'] as $detail)
                            @php
                            $total_qty += $detail['qty'];
                            // $total_harga += $detail['harga'];
                            $total_harga += $item['total'];
                            @endphp
                            @endforeach
                            <tr>
                                <td>{{ $item['nomor'] }}</td>
                                <td>{{ date_format(date_create($item['tanggal_pesanan']), 'd-M-y') }}</td>
                                <td>{{ $total_item }}</td>
                                <td>
                                    @if($item['status']['kode'] != "STS01")
                                    {{ 'Rp. ' . number_format($item['total']) }}
                                    @else
                                    {{ '-' }}
                                    @endif
                                </td>
                                <td>{{ $item['status']['keterangan'] }}</td>
                                <!-- <td>-</td> -->
                                <td>{{ date_format(date_create($item['target_pesanan']), 'd-M-y') }}</td>
                                <td>
                                    @if ($item['status_pesanan_id'] == 1 || $item['status_pesanan_id'] == 2)
                                    <a href="{{ route('draft.detail', $item['id']) }}">Detail</a>
                                    {{-- |
                                    <a href="{{ route('draft.edit', $item['id']) }}"><span class="uk-margin-small-right" uk-icon="plus-circle"></span></a> --}}
                                    @else
                                    <a href="{{ route('pesanan.detail', $item['id']) }}">Detail</a>
                                    @endif
                                </td>

                            </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>



</x-app-layout>
