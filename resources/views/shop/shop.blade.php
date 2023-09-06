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
                                <option value="{{ $category_kain }}" selected>{{ $category_kain }}</option>
                            </select>
                        </div>
                    </div>
                    {{-- @dd($porduk_active) --}}
                    <div class="uk-child-width-1-4@s uk-child-width-1-2 uk-grid-small" uk-grid id="page-shop">
                        @foreach ($porduk_active as $a)
                            <div>
                                <div class="rz-card-product">
                                    <div class="uk-inline">
                                        @if ($a->gambar)
                                            <img src="{{ $a->gambar }}" alt="">
                                        @else
                                            <img src="{{ asset('tipe-kain/' . rand(7, 24) . '.jpg') }}" alt="">
                                        @endif

                                        {{-- <a href="#modalAddToCart" data-idx="{{ $a->id }}" uk-toggle
                                            class="uk-icon-button add-modal-cart" uk-icon="cart"></a> --}}
                                        @if ($a->jenis_kain_id == 3)
                                            <a href="#modalAddToCartLacoste" data-idx="{{ $a->id }}" uk-toggle
                                                class="uk-icon-button add-modal-cart-lacoste" uk-icon="cart"></a>
                                        @else
                                            <a href="#modalAddToCart" data-idx="{{ $a->id }}" uk-toggle
                                                class="uk-icon-button add-modal-cart" uk-icon="cart"></a>
                                        @endif
                                    </div>

                                    <div class="rz-card-product-detail">
                                        <h5><a
                                                href="{{ route('shop.detail', ['id' => $a->id]) }}/?category-kain={{ Str::slug($a->nama) }}">{{ $a->nama }}</a>
                                        </h5>
                                        <ul class="rz-stars">
                                            <li><i class="ph-fill ph-star"></i></li>
                                            <li><i class="ph-fill ph-star"></i></li>
                                            <li><i class="ph-fill ph-star"></i></li>
                                            <li><i class="ph-fill ph-star"></i></li>
                                            <li><i class="ph-fill ph-star"></i></li>
                                        </ul>
                                        <dl>
                                            <dt>{{ $a->lebar->keterangan }}" / {{ $a->gramasi->nama }}</dt>
                                            <dd>{{ $a->warna->keterangan }}</dd>
                                        </dl>
                                        <div class="rz-card-product-price">
                                            @if (isset($a->prices[0]))
                                                Rp. {{ number_format($a->prices[0]->harga) }}
                                            @else
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
                                @if ($porduk_active->currentPage() > 1)
                                    <li
                                        class="{{ $porduk_active->currentPage() == $porduk_active->currentPage() ? 'uk-active' : '' }}">
                                        <a href="{{ $porduk_active->previousPageUrl() }}">
                                            <span class="uk-margin-small-right" uk-pagination-previous></span> Previous
                                        </a>
                                    </li>
                                @endif
                                @if ($porduk_active->hasMorePages())
                                    <li
                                        class="{{ $porduk_active->currentPage() == $porduk_active->currentPage() ? 'uk-active' : '' }}">
                                        <a href="{{ $porduk_active->nextPageUrl() }}">
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

</x-app-layout>
