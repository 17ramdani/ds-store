<x-app-layout>
    <section id="pageContent" class="uk-section" uk-height-viewport="offset-bottom: 20">
        <div class="uk-container">
            <div class="uk-margin-large uk-grid-large" uk-grid>
                {{-- @include('layouts.inc.app-sidebar') --}}
                <x-side-menu />
                <!-- Contains uk-width-1-4@s. Don't screw up! -->
                <div class="uk-width-3-4@s">

                    <!-- Mobile-only product sidebar -->
                    <div class="uk-hidden@s" uk-grid>
                        <div class="uk-width-2-5">
                            <select name="kategori" id="kategori" class="uk-select uk-form-small">
                                <option>--Kategori--</option>
                                @foreach ($data as $jk)
                                    <option value="{{ $jk->id }}" @selected($jk->id == $jenis_id)>{{ $jk->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="uk-width-3-5">
                            <select name="sub_kategori" id="sub_kategori" class="uk-select uk-form-small">
                                <option>--Sub Kategori--</option>
                                <option value="{{ $t_nama }}" selected>{{ $t_nama }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="uk-child-width-1-4@s uk-child-width-1-2 uk-grid-small" uk-grid>
                        @foreach ($cards as $card)
                            <div>
                                <div class="rz-card-product">
                                    <div class="uk-inline">
                                        @if ($card->gambar)
                                            <img src="{{ $card->gambar }}" alt="">
                                        @else
                                            <img src="{{ asset('tipe-kain/' . rand(7, 24) . '.jpg') }}" alt="">
                                        @endif

                                        @if ($card->jenis_kain_id == 3)
                                            <a href="#modalAddToCartLacoste" data-idx="{{ $card->id }}" uk-toggle
                                                class="uk-icon-button add-modal-cart-lacoste" uk-icon="cart"></a>
                                        @else
                                            <a href="#modalAddToCart" data-idx="{{ $card->id }}" uk-toggle
                                                class="uk-icon-button add-modal-cart" uk-icon="cart"></a>
                                        @endif

                                    </div>
                                    <div class="rz-card-product-detail">
                                        {{-- <h5><a href="{{ route('shop.detail', ['id' => $card->id]) }}">{{ $card->nama }}</a></h5> --}}
                                        <h5><a
                                                href="{{ route('shop.detail', ['id' => $card->id]) }}/?category-kain={{ $card->slug }}">{{ $card->nama }}</a>
                                        </h5>
                                        <ul class="rz-stars">
                                            <li><i class="ph-fill ph-star"></i></li>
                                            <li><i class="ph-fill ph-star"></i></li>
                                            <li><i class="ph-fill ph-star"></i></li>
                                            <li><i class="ph-fill ph-star"></i></li>
                                            <li><i class="ph-fill ph-star"></i></li>
                                        </ul>
                                        <dl>
                                            <dt>{{ $card->lebar->keterangan }} / {{ $card->gramasi->nama }}</dt>
                                            <dd>{{ $card->warna->keterangan }}</dd>
                                        </dl>
                                        <div class="rz-card-product-price">
                                            @if (isset($card->prices[0]))
                                                Rp. {{ number_format($card->prices[0]->harga) }}
                                            @else
                                                Rp. {{ number_format(0) }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="uk-margin" id="pag-produk-active">
                        <div class="uk-flex uk-flex-right">
                            <ul class="uk-pagination">
                                @if ($cards->currentPage() > 1)
                                    <?php
                                    $category = app('request')->input('category-kain'); // Mendapatkan nilai dari parameter category-kain saat ini
                                    $previousPageUrlWithCategory = url()->current() . '?category-kain=' . urlencode($category) . '&page=' . ($cards->currentPage() - 1);
                                    ?>
                                    <li
                                        class="{{ $cards->currentPage() == $cards->currentPage() ? 'uk-active' : '' }}">
                                        <a href="{{ $previousPageUrlWithCategory }}">
                                            <span class="uk-margin-small-right" uk-pagination-previous></span> Previous
                                        </a>
                                    </li>
                                @endif
                                @if ($cards->hasMorePages())
                                    <?php
                                    $category = app('request')->input('category-kain'); // Mendapatkan nilai dari parameter category-kain saat ini
                                    $nextPageUrlWithCategory = url()->current() . '?category-kain=' . urlencode($category) . '&page=' . ($cards->currentPage() + 1);
                                    ?>
                                    <li
                                        class="{{ $cards->currentPage() == $cards->currentPage() ? 'uk-active' : '' }}">
                                        <a href="{{ $nextPageUrlWithCategory }}">
                                            Next <span class="uk-margin-small-left" uk-pagination-next></span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>

                    <div class="uk-child-width-1-4@s uk-child-width-1-2 uk-grid-small" uk-grid id="product-mobile">
                    </div>

                </div>
            </div>
        </div>
    </section>

    @include('modal-add-tocart')

    @include('modal-add-tocart-lacoste')

    @push('script')
        <script>
            $(document).ready(function() {
                $('#kategori').trigger('change');

                setTimeout(() => {
                    $('#sub_kategori').val("{{ $t_nama }}");
                }, 2000);

            });
        </script>
    @endpush
</x-app-layout>
