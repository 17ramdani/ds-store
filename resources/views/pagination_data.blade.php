@foreach ($porduk_active as $a)
<div>
    <div class="rz-card-product">
        <div class="uk-inline">
            {{-- <img src="{{ asset('assets/tipe-kain/' . $a->gambar) }}" alt=""> nanti set pake ini --}}
            <img src="{{ asset('tipe-kain/' . rand(7, 24) . '.jpg') }}" alt="">
            <a href="#modalAddToCart" uk-toggle class="uk-icon-button" uk-icon="cart"></a>    
        </div>
        
        <div class="rz-card-product-detail">
            <h5><a href="/product-detail/{{ $a->id }}">{{ $a->nama }}</a></h5>
            <dl>
                <dt>{{ $a->lebar->keterangan }}" / {{ $a->gramasi->nama }}</dt>
                <dd>{{ $a->warna->keterangan }}</dd>
            </dl>
            <div class="rz-card-product-price">
                Rp. {{ number_format($a->harga_roll) }}
            </div>
        </div>
    </div>
</div>
@endforeach