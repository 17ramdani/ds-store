<div class="uk-child-width-1-4@s uk-child-width-1-2 uk-grid-small" uk-grid>

    {{-- <div id="product-list"></div> --}}
    @foreach ($cards as $card)
    <div>
    <div class="rz-card-product">
        <div class="uk-inline">
            {{-- <img src="{{ asset('assets/tipe-kain/' . $card->gambar) }}" alt=""> nanti set pake ini --}}
            @if($card->gambar)
                <img src="{{ $card->gambar }}" alt="">
            @else
                <img src="{{ asset('tipe-kain/' . rand(7, 24) . '.jpg') }}" alt="">
            @endif
            <a href="#modalAddToCart" 
                data-idx="{{ $card->id }}" 
                data-id-kain="{{ $card->jenis_kain_id }}" 
                data-kain="{{ $card->nama }}"
                data-lebar="{{ $card->lebar->keterangan }}" 
                data-gramasi="{{ $card->gramasi->nama }}" 
                data-warna="{{ $card->warna->keterangan }}" 
                data-warna-id="{{ $card->warna->id }}" 
                data-lebar-id="{{ $card->barang_lebar_id }}" 
                data-gramasi-id="{{ $card->barang_gramasi_id }}" 
                data-bagian="{{ $card->bagian }}" 
                data-harga="{{ $card->harga_ecer }}"
                uk-toggle class="uk-icon-button add-modal-cart" uk-icon="cart"></a>    
        </div>
        
        <div class="rz-card-product-detail">
            <h5><a href="/product-detail/{{ $card->id }}">{{ $card->nama }}</a></h5>
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
                Rp. {{ number_format($card->harga_ecer) }}
            </div>
        </div>
    </div>
    </div>
    @endforeach
</div>