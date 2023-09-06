<x-app-layout>
    <section id="navbarSecondary" class="uk-flex uk-flex-middle uk-flex-left">
        <div class="uk-width-1-1">
            <div class="uk-container">
                <h2 class="rz-text-pagetitle">Welcome</h2>
            </div>
        </div>
    </section>


    <main class="uk-margin-medium">
        <div class="uk-container uk-container-small">
            <x-alert />
            <div class="rz-panel">
                <div class="uk-grid-medium" uk-grid>
                    <div class="uk-width-1-2@s">
                        <div class="uk-child-width-1-2 uk-grid-small uk-margin-medium" uk-grid>
                            <div>
                                <div class="rz-cell">
                                    <i class="ph-lg ph-star-thin"></i>
                                    <div class="rz-cell-label">Level</div>
                                    <div class="rz-cell-value">{{ $customer->nama ?? '??' }}</div>
                                </div>
                            </div>
                            <div>
                                <div class="rz-cell">
                                    <i class="ph-lg ph-coins-thin"></i>
                                    <div class="rz-cell-label">Point</div>
                                    <div class="rz-cell-value">{{ $point }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="uk-child-width-1-3 uk-grid-small" uk-grid>
                            <div>
                                <a href="{{ route('pesanan.index') }}" class="rz-cell-alt">
                                    <div class="rz-cell-value">{{ $count->sts_0 }}</div>
                                    <div class="rz-cell-label">Total Pesanan</div>
                                </a>
                            </div>
                            <div>
                                <div class="rz-cell-alt">
                                    <div class="rz-cell-value">{{ $count->sts_1 }}</div>
                                    <div class="rz-cell-label">Tunggu Konfirmasi</div>
                                </div>
                            </div>
                            <div>
                                <div class="rz-cell-alt">
                                    <div class="rz-cell-value">{{ $count->sts_2 }}</div>
                                    <div class="rz-cell-label">Tunggu Pembayaran</div>
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
                                    <div class="rz-cell-label">Pesanan Selesai</div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="uk-child-width-expand uk-grid-small" uk-grid>
                            <div>
                                <div class="rz-cell-alt">
                                    <div class="rz-cell-value">{{ number_format($total_byr-$inv_byr) }}</div>
                                    <div class="rz-cell-label">Deposit</div>
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <div class="uk-width-1-2@s">
                        <div>
                            <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1" uk-slideshow="animation: fade; autoplay: true; autoplay-interval: 2000;min-height: 300; max-height: 600">

                                <ul class="uk-slideshow-items uk-border-rounded">
                                    <li>
                                        <div class="uk-position-cover uk-height-medium uk-animation-kenburns uk-animation-reverse uk-transform-origin-center-left">
                                            <img src="https://duniasandang.com/wp-content/uploads/2022/01/fabric-dunia-sandang.jpg" alt="" uk-cover>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="uk-position-cover uk-height-medium uk-animation-kenburns uk-animation-reverse uk-transform-origin-top-right">
                                            <img src="https://duniasandang.com/wp-content/uploads/2022/01/kantor-dunia-sandang-1.jpg" alt="" uk-cover>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="uk-position-cover uk-height-medium uk-animation-kenburns uk-animation-reverse uk-transform-origin-bottom-left">
                                            <img src="https://duniasandang.com/wp-content/uploads/2022/11/rekomendasi-kain-untuk-baju-gamis-1-1024x808.jpg" alt="" uk-cover>
                                        </div>
                                    </li>
                                </ul>

                                <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slideshow-item="previous"></a>
                                <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slideshow-item="next"></a>

                            </div>

                        </div>
                    </div>

                </div>

            </div>




        </div>
    </main>
</x-app-layout>
