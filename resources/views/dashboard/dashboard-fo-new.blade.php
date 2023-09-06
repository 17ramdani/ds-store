<x-app-layout>
    <section id="pageContent" class="uk-section" uk-height-viewport>
        <div class="uk-container">
            <div class="uk-margin-large uk-grid-large" uk-grid>
                @include('layouts.inc.app-sidebar')

                <!-- Contains uk-width-1-4@s. Don't screw up! -->
                <div class="uk-width-3-4@s">

                    <div class="rz-list-container">
                        <div class="rz-panel">
                            <h3><i class="ph-light ph-basket rz-icon"></i>List Pesanan Fresh Order</h3>
                            <div class="uk-child-width-1-6@l uk-child-width-1-3 uk-grid-small uk-grid-match uk-margin-medium"
                                uk-grid>
                                <div>
                                    <a class="rz-cell-alt">
                                        <div class="rz-cell-value">{{ $count->sts_0 }}</div>
                                        <div class="rz-cell-label">Total Pesanan</div>
                                    </a>
                                </div>
                                <div>
                                    <a class="rz-cell-alt">
                                        <div class="rz-cell-value">{{ $count->sts_1 }}</div>
                                        <div class="rz-cell-label">Tunggu Konfirmasi</div>
                                    </a>
                                </div>
                                <div>
                                    <a class="rz-cell-alt">
                                        <div class="rz-cell-value">{{ $count->sts_2 }}</div>
                                        <div class="rz-cell-label">Tunggu Pembayaran</div>
                                    </a>
                                </div>
                                <div>
                                    <a class="rz-cell-alt">
                                        <div class="rz-cell-value">{{ $count->sts_3 }}</div>
                                        <div class="rz-cell-label">Pesanan Diproses</div>
                                    </a>
                                </div>
                                <div>
                                    <a class="rz-cell-alt">
                                        <div class="rz-cell-value">{{ $count->sts_4 }}</div>
                                        <div class="rz-cell-label">Pesanan Diantar</div>
                                    </a>
                                </div>
                                <div>
                                    <a class="rz-cell-alt">
                                        <div class="rz-cell-value">{{ $count->sts_5 }}</div>
                                        <div class="rz-cell-label">Pesanan Selesai</div>
                                    </a>
                                </div>
                            </div>
                        </div>

                        @forelse ($pesanans as $pesanan)
                            <article>
                                <header class="uk-flex uk-flex-between">
                                    <span
                                        class="rz-text-primary">{{ date_format(date_create($pesanan->tanggal), 'd-M-Y') }}</span>
                                    <span class="uk-label uk-label-warning">
                                        @if ($pesanan->status == 'Draft')
                                            Tunggu Konfirmasi
                                        @elseif ($pesanan->status == 'Approved')
                                            Tunggu Pembayaran
                                        @elseif ($pesanan->status == 'Invoicing')
                                            Pesanan Diproses
                                        @elseif ($pesanan->status == 'Delivery')
                                            Pesanan Diantar
                                        @elseif ($pesanan->status == 'Done')
                                            Pesanan Selesai
                                        @else
                                            -
                                        @endif
                                    </span>
                                </header>
                                <main class="uk-grid-small" uk-grid>
                                    <div class="uk-width-1-5@s">
                                        <a
                                            href="{{ route('fo.detail', $pesanan->id) }}">{{ $pesanan->nomor ?? $pesanan->inq_number }}</a>
                                        <br class="uk-hidden@s">
                                    </div>
                                    <div class="uk-width-1-5@s uk-width-1-2">
                                        <dl>
                                            <dt>Total Item</dt>
                                            <dd>{{ count($pesanan->accs) }}</dd>
                                        </dl>
                                    </div>
                                    <div class="uk-width-1-5@s uk-width-1-2">
                                        <dl>
                                            <dt>Target Pesanan</dt>
                                            <dd>{{ date_format(date_create($pesanan->tanggal_kirim), 'd-M-Y') }}</dd>
                                        </dl>
                                    </div>
                                    <div class="uk-width-1-5@s uk-width-1-2">
                                        <!-- <dl>
                                    <dt>Harga Estimasi</dt>
                                    <dd>Rp. 7,200,000</dd>
                                </dl> -->
                                    </div>
                                    <div class="uk-width-1-5@s uk-width-1-2">
                                        <dl>
                                            <dt>Harga Aktual</dt>
                                            <dd>{{ number_format($pesanan->grand_total) }}</dd>
                                        </dl>
                                    </div>
                                    <div class="uk-width-2-5@s">
                                        <dl>
                                            <dt>Catatan</dt>
                                            <dd>{{ $pesanan->keterangan }}</dd>
                                        </dl>
                                    </div>

                                </main>
                                <footer class="uk-text-right">
                                    <a href="{{ route('fo.detail', $pesanan->id) }}">Detail<i
                                            class="ph-light ph-caret-circle-right"></i></a>
                                </footer>

                            </article>
                        @empty
                            <article>
                                <main class="uk-grid-small" uk-grid>
                                    <div class="uk-width-1-1@s">
                                        <div class="uk-alert-primary" uk-alert>
                                            <a class="uk-alert-close" uk-close></a>
                                            <p>Daftar belanjaan anda masih kosong.
                                                <a href="{{ route('pesanan-add-fo') }}"> Belanja sekarang</a>
                                            </p>
                                        </div>
                                    </div>


                                </main>

                            </article>
                        @endforelse


                    </div>





                </div>
            </div>
        </div>
    </section>



</x-app-layout>
