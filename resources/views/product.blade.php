<x-guest-new-layout>
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
                @foreach ($porduk_active as $a)
                    <div>
                        <div class="rz-card-product">
                            <div class="uk-inline">
                                {{-- <img src="{{ asset('assets/tipe-kain/' . $a->gambar) }}" alt=""> nanti set pake ini --}}
                            @if($a->gambar)
                                <img src="{{ $a->gambar }}" alt="">
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
                                {{-- data-qtyroll= --}}
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
            
            <div class="uk-margin" id="pag-produk-active">
                <div class="uk-flex uk-flex-right">
                    <ul class="uk-pagination">
                        @if ($porduk_active->currentPage() > 1)
                            <li class="{{ ($porduk_active->currentPage() == $porduk_active->currentPage()) ? 'uk-active' : '' }}">
                                <a href="{{ $porduk_active->previousPageUrl() }}">
                                    <span class="uk-margin-small-right" uk-pagination-previous></span> Previous
                                </a>
                            </li>
                        @endif
                        @if ($porduk_active->hasMorePages())
                            <li class="{{ ($porduk_active->currentPage() == $porduk_active->currentPage()) ? 'uk-active' : '' }}">
                                <a href="{{ $porduk_active->nextPageUrl() }}">
                                    Next <span class="uk-margin-small-left" uk-pagination-next></span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
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

@include('modal-cart')

@push('script')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.add-modal-cart', function() {
                var id              = $(this).attr('data-idx');
                var jenis_kain_id   = $(this).attr('data-id-kain');
                var nama_kain       = $(this).attr('data-kain');
                var nama_lebar      = $(this).attr('data-lebar');
                var nama_gramasi    = $(this).attr('data-gramasi');
                var nama_warna      = $(this).attr('data-warna');
                var warna_id        = $(this).attr('data-warna-id');
                var lebar_id        = $(this).attr('data-lebar-id');
                var gramasi_id      = $(this).attr('data-gramasi-id');
                var bagian          = $(this).attr('data-bagian');
                var harga_produk    = $(this).attr('data-harga');
                // console.log(id + ' - ' + jenis_kain_id + ' - ' + nama_kain);

                $('#judulmodal-fo').text(nama_kain)
                $('#judullebar-fo').text(nama_lebar)
                $('#judulgramasi-fo').text(nama_gramasi)
                $('#judulwarna-fo').text(nama_warna)
                $('#warnaModal').val(warna_id);
                $('#bagian').val(bagian);
                $('#hargModal').val(harga_produk);
                $('#lebarModal').val(nama_lebar);
                $('#gramasiModal').val(nama_gramasi);
                $('#namaWarna').val(nama_warna);

                $.ajax({
                    url: '/fetch-product-modal',
                    type: 'GET',
                    data: {
                        id_prd: id, 
                        jenis_kain_id: jenis_kain_id,
                        nama_produk:nama_kain
                    },
                    success: function(data) {
                        // console.log(id + ' + ' + jenis_kain_id + ' + ' + nama_kain)
                        $('#qtyBodyModal').val('');
                        $('#qtyAscModal').val('');
                        $('#bodySelect').empty();
                        $('#aksesorisSelect').empty(); 
                        $('#total_bodyQty').text('').empty();
                        $('#total_hargabody').text('').empty();
                        $('#total_ascQty').text('').empty();
                        $('#total_hargaasc').text('').empty();
                        $('#total_hargasm').text('').empty();

                        let optvalue = "";
                        let optasc = "";
                        $.each(data.asc, function(i, item) {
                            optasc += `<option value="${item.id}">${item.nama}</option>`;
                        });
                        $.each(data.satuan, function(i2, item2) {
                            optvalue +=
                                `<option value="${item2.satuan.keterangan}">${item2.satuan.keterangan}</option>`;
                        });
                        $('#bodySelect').append(optvalue);

                        var rollExists = false;
                        $.each(data.satuan, function(i2, item2) {
                            if (item2.satuan.keterangan === "ROLL") {
                                rollExists = true;
                                return false; // Menghentikan iterasi
                            }
                        });

                        if (!rollExists) {
                            $('#bodySelect').append('<option value="ROLL">ROLL</option>');
                        }

                        // $('#bodySelect').append('<option value="ROLL">ROLL</option>');
                        $('#aksesorisSelect').append(optasc);
                        $('#jenis_kainidBodyModal').val(jenis_kain_id);
                        $('#id_produkBodyModal').val(id);
                        $('#nama_produkBodyModal').val(nama_kain);
                        // $('#modalAddToCart .uk-modal-body').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endpush

</x-guest-new-layout>