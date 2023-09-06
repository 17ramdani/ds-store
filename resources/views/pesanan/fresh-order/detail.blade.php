<x-app-layout>
    <section id="pageContent" class="uk-section" uk-height-viewport>
        <div class="uk-container">
            <div class="uk-margin-large uk-grid-large" uk-grid>
                @include('layouts.inc.app-sidebar')

                <div class="uk-width-3-4@s">

                    <div class="rz-detail-order">
                        <div class="" uk-grid>
                            <div class="uk-width-expand@s">
                                <h3><i class="ph-light ph-receipt rz-icon"></i>Sales Order</h3>
                            </div>
                            <div class="uk-width-auto@s">
                                <div>{{ $pesanan->nomor ?? $pesanan->inq_number }}</div>
                                @if ($pesanan->status == 'Draft')
                                    <span class="uk-label uk-label-warning">Tunggu Konfirmasi</span>
                                @elseif ($pesanan->status == 'Approved')
                                    <span class="uk-label uk-label-primary">Tunggu Pembayaran</span>
                                @elseif ($pesanan->status == 'Invoicing')
                                    <span class="uk-label uk-label-primary">Pesanan Diproses</span>
                                @elseif ($pesanan->status == 'Delivery')
                                    <span class="uk-label uk-label-primary">Pesanan Diantar</span>
                                @elseif ($pesanan->status == 'Done')
                                    <span class="uk-label uk-label-success">Pesanan Selesai</span>
                                @else
                                    <span class="uk-label uk-label-danger">-</span>
                                @endif
                            </div>
                        </div>


                        <div class="uk-margin-medium-top" uk-grid>
                            <div class="uk-width-1-2@s">
                                <div class="rz-order-container uk-margin-medium">
                                    <h5>Alamat Pengiriman</h5>
                                    <dl>
                                        <dt>Apriana Ivan</dt>
                                        <dd>Jl. Buah Batu No. 161 Bandung</dd>
                                    </dl>
                                    <a href="#modalAddressList" class="uk-button uk-button-default uk-button-small"
                                        uk-toggle>Ganti Alamat</a>
                                </div>

                            </div>
                            <div class="uk-width-1-2@s">
                                <div class="rz-order-container">
                                    <h5>Rincian Pembelian</h5>
                                    <div class="uk-margin">
                                        @if (count($pesanan->details) <= 0)
                                            <div class="uk-alert-primary" uk-alert>
                                                <a class="uk-alert-close" uk-close></a>
                                                <p>Pesanan masih dalam proses validasi sehingga harga barang belum dapat
                                                    ditampilkan.</p>
                                            </div>
                                        @endif
                                    </div>
                                    <article>
                                        @if (count($pesanan->details) <= 0)
                                            <div class="rz-checkout-item">
                                                <dl>
                                                    <dt>{{ $pesanan->jenis_kain }}</dt>
                                                    <dd>{{ $pesanan->tipe_kain . ' - ' . $pesanan->gramasi . '/' . $pesanan->lebar . ' - ' . $pesanan->warna }}
                                                    </dd>
                                                </dl>
                                                <div class="uk-flex uk-flex-between">
                                                    <div class="uk-text-small">
                                                        {{ $pesanan->qty }} roll
                                                    </div>
                                                    <div class="uk-text-bold">
                                                        Rp. 0
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="rz-checkout-item">
                                                @foreach ($pesanan['accs'] as $acc)
                                                    <dl>
                                                        <dt>{{ $acc->accessories }}</dt>
                                                        <dd>{{ $pesanan->warna }}</dd>
                                                    </dl>
                                                    <div class="uk-flex uk-flex-between">
                                                        <div class="uk-text-small">
                                                            {{ $acc->qty }} kg
                                                        </div>
                                                        <div class="uk-text-bold">
                                                            Rp. 0
                                                        </div>
                                                    </div>
                                                @endforeach

                                            </div>
                                        @else
                                            <div class="rz-checkout-item">
                                                <dl>
                                                    <dt>{{ $pesanan->jenis_kain }}</dt>
                                                    <dd>{{ $pesanan->tipe_kain . ' - ' . $pesanan->gramasi . '/' . $pesanan->lebar . ' - ' . $pesanan->warna }}
                                                    </dd>
                                                </dl>
                                                @foreach ($pesanan->details as $detail)
                                                    @if ($detail->bagian == 'Body')
                                                        <div class="uk-flex uk-flex-between">
                                                            <div class="uk-text-small">
                                                                {{ $detail->qty }} roll
                                                            </div>
                                                            <div class="uk-text-bold">
                                                                Rp. {{ number_format($detail->subtotal) }}
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                            <div class="rz-checkout-item">
                                                @foreach ($pesanan->details as $detail)
                                                    @if ($detail->bagian == 'Accessories')
                                                        <dl>
                                                            <dt>{{ $detail->nama }}</dt>
                                                            <dd>{{ $detail->warna . ' - ' . $detail->kategori_warna }}
                                                            </dd>
                                                        </dl>
                                                        <div class="uk-flex uk-flex-between">
                                                            <div class="uk-text-small">
                                                                {{ $detail->qty_act }} kg
                                                            </div>
                                                            <div class="uk-text-bold">
                                                                Rp. {{ number_format($detail->subtotal) }}
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach

                                            </div>
                                        @endif

                                        <div class="rz-checkout-item">
                                            <div class="uk-flex uk-flex-between">
                                                <div class="uk-text-small">
                                                    <i class="ph-fill ph-truck uk-margin-small-right"></i>Ongkos Kirim
                                                </div>
                                                <div class="uk-text-bold">
                                                    Rp. {{ number_format($pesanan->ongkir) }}
                                                </div>
                                            </div>
                                            <div class="uk-flex uk-flex-between">
                                                <div class="uk-text-small">
                                                    <i class="ph-fill ph-wallet uk-margin-small-right"></i>Deposit
                                                </div>
                                                <div class="uk-text-bold">
                                                    Rp. 0
                                                </div>
                                            </div>
                                        </div>
                                    </article>

                                    <article class="rz-values-horizontal uk-text-small">
                                        <dl>
                                            <dt>Total</dt>
                                            <dd>Rp. {{ number_format($pesanan->grand_total) }}</dd>
                                        </dl>

                                        <dl>
                                            <dt>DP</dt>
                                            <dd>Rp. {{ number_format($pesanan->dp) }}</dd>
                                        </dl>

                                        <hr>
                                        <dl>
                                            <dt>Sisa Pembayaran</dt>
                                            <dd class="uk-text-bold">Rp. {{ number_format($pesanan->sisa_pembayaran) }}
                                            </dd>
                                        </dl>

                                    </article>

                                    <div class="uk-margin-medium-top">
                                        <dl>
                                            <dt>Upload Bukti Transfer</dt>
                                            <dd class="uk-margin">

                                                <div class="js-upload" uk-form-custom>
                                                    <input type="file" multiple>
                                                    <button class="uk-button uk-button-default uk-button-small"
                                                        type="button" tabindex="-1">DP</button>
                                                </div>
                                                <div class="js-upload" uk-form-custom>
                                                    <input type="file" multiple>
                                                    <button class="uk-button uk-button-default uk-button-small"
                                                        type="button" tabindex="-1">Pelunasan</button>
                                                </div>
                                            </dd>
                                        </dl>

                                    </div>


                                    <div class="uk-margin-medium-top">
                                        <div class="uk-flex uk-flex-between">

                                            <div>
                                                <a href="#modalPembatalan" class="uk-button uk-button-secondary"
                                                    uk-toggle>Batalkan</a>
                                            </div>
                                            <div>
                                                <a href="" class="uk-button uk-button-default"
                                                    uk-toggle>Cetak</a>
                                            </div>
                                            <!-- ini button dynamic, akan berubah sesuai status, please read instructions -->
                                            <div>
                                                <a href="" class="uk-button uk-button-primary">Submit</a>
                                            </div>
                                        </div>

                                    </div>
                                </div>




                            </div>
                        </div>

                    </div>





                </div>

            </div>
        </div>
    </section>
    <div id="modalAddressList" class="uk-flex-top" uk-modal>
        <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">

            <button class="uk-modal-close-default" type="button" uk-close></button>
            <h5>Daftar Alamat</h5>
            <ul class="uk-list uk-list-divider">
                <li>
                    <div class="uk-flex uk-flex-between">
                        <dl>
                            <dt>Rumah</dt>
                            <dd>Jl. Buah Batu No. 161 Bandung</dd>
                            <div class="uk-margin-small-top"><a href=""
                                    class="uk-button uk-button-small uk-button-primary">Pilih alamat</a></div>
                        </dl>
                        <div>
                            <ul class="uk-iconnav">
                                <li><a href="#" uk-icon="icon: file-edit"></a></li>
                                <li><a href="#" uk-icon="icon: trash"></a></li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="uk-flex uk-flex-between">
                        <dl>
                            <dt>Kantor</dt>
                            <dd>Jl. Terusan Pasirkoja No.250, Babakan, Kec. Babakan Ciparay, Kota Bandung, Jawa Barat
                                40222</dd>
                            <div class="uk-margin-small-top"><a href=""
                                    class="uk-button uk-button-small uk-button-primary">Pilih alamat</a></div>
                        </dl>
                        <div>
                            <ul class="uk-iconnav">
                                <li><a href="#" uk-icon="icon: file-edit"></a></li>
                                <li><a href="#" uk-icon="icon: trash"></a></li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>

        </div>
    </div>
</x-app-layout>
