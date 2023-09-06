
<x-app-layout>

    <section id="pageContent" class="uk-section" uk-height-viewport="offset-bottom: 20">
        <div class="uk-container">
            <div class="uk-margin-large uk-grid-large" uk-grid>
                @include('layouts.inc.sidebar')
                
                <!-- Contains uk-width-1-4@s. Don't screw up! -->
                <div class="uk-width-3-4@s">
                
                <!-- Mobile-only product sidebar -->
                <div class="uk-hidden@s" uk-grid>
                    <div class="uk-width-2-5">
                        <select name="kategori" id="kategori" class="uk-select uk-form-small">
                            <option>--Kategori--</option>
                            @foreach ($data as $jk)
                            <option value="{{ $jk->id }}">{{ $jk->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="uk-width-3-5">
                        <select name="sub_kategori" id="sub_kategori" class="uk-select uk-form-small">
                            <option>--Sub Kategori--</option>
                        </select>
                    </div>
                </div> 
    
                <div class="uk-child-width-1-4@s uk-child-width-1-2 uk-grid-small" uk-grid id="produk-active">
                    @foreach ($product_active as $a)
                        <div>
                            <div class="rz-card-product">
                                <div class="uk-inline">
                                @if($a->gambar)
                                    <img src="https://duniasandang.coba.dev/dspanel/storage/tipe-kain/Cotton_Carded_24s_001_1.jpg.jpg" alt="">
                                @else
                                    <img src="{{ asset('tipe-kain/' . rand(7, 24) . '.jpg') }}" alt="">
                                @endif
                                
                                    <a href="#modalAddToCart"
                                    data-idx="{{ $a->id }}" 
                                    data-id-kain="{{ $a->jenis_kain_id }}" 
                                    data-kain="{{ $a->nama }}"
                                    data-lebar="{{ $a->lebar->keterangan }}" 
                                    data-gramasi="{{ $a->gramasi->nama }}" 
                                    data-warna="{{ $a->warna->keterangan }}" 
                                    data-warna-id="{{ $a->warna->id }}" 
                                    data-lebar-id="{{ $a->barang_lebar_id }}" 
                                    data-gramasi-id="{{ $a->barang_gramasi_id }}" 
                                    data-bagian="{{ $a->bagian }}" 
                                    data-harga="{{ $a->harga_ecer }}"
                                    uk-toggle class="uk-icon-button add-modal-cart" uk-icon="cart"></a>    
                                </div>
                                
                                <div class="rz-card-product-detail">
                                    <h5><a href="/product-detail/{{ $a->id }}">{{ $a->nama }}</a></h5>
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
                                        Rp. {{ number_format($a->harga_ecer) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
    
                <div class="uk-child-width-1-4@s uk-child-width-1-2 uk-grid-small" uk-grid id="produk-container">
                    
                </div>
    
                <div id="card-container">
                    @include('cards')
                </div>
                
                </div>         
            </div>
        </div>
    </section>

</x-app-layout>

