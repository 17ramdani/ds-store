
<x-app-layout>

    <section id="pageContent" class="uk-section" uk-height-viewport="offset-bottom: 20">
        <div class="uk-container">
            <div class="uk-margin-large uk-grid-large" uk-grid>
                @include('layouts.inc.sidebar')
                <!-- Contains uk-width-1-4@s. Don't screw up! -->
                <div class="uk-width-3-4@s">

                    <div class="rz-detail-product" id="page-whitelist">
                        <div uk-grid>
                            <div class="uk-width-3-5@s">
                                <h3><i class="ph-fill ph-heart rz-icon"></i>Wishlist</h3>
                                <div class="rz-cart-container">
                                    
                                    <article>
                                        @foreach($cartArray as $w)
                                        <div class="rz-cart-item uk-grid-small" uk-grid>
                                            <div class="uk-width-1-5@m uk-width-1-3">
                                                <img src="{{ asset('tipe-kain/21C.jpg')}}" class="uk-border-rounded" alt="">
                                            </div>
                                            <div class="uk-width-4-5@m uk-width-2-3">
                                                <dl>
                                                    <dt>{{ $w['jenis_kain']['nama'] }}</dt>
                                                    <dd>{{ $w['nama'] }} - {{ $w['lebar']['keterangan'] }}/{{ $w['gramasi']['nama'] }} - {{ $w['warna']['nama'] }}</dd>
                                                </dl>
                                                <a href="/remove-whitelist/{{ $w['id'] }}" class="uk-icon-button remove-whitelist" uk-icon="trash"></a>                 
                                            </div>
                                        </div>
                                        @endforeach
                                    </article>
                                    
                                </div>
                            </div>
                            <div class="uk-width-2-5@s">
                                
                            </div>
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

    <div id="modalAddToCart" uk-modal>
        <div class="uk-modal-dialog">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header">
                <h4 id="judulmodal-fo"></h4>
                <dl>
                    <dt><span id="judullebar-fo"></span>  / <span id="judulgramasi-fo"></span></dt>
                    <dd><span id="judulwarna-fo"></span></dd>
                </dl>
            </div>
            <div class="uk-modal-body" uk-overflow-auto>
                <div class="uk-child-width-1-2@s" uk-grid>
                    <div>
                        <div class="uk-margin">
                            <strong>Body</strong>
                            <form class="uk-grid-small" uk-grid>
                                <div class="uk-width-1-2">
                                   <select id="bodySelect" class="uk-select uk-form-small" required>
                                   </select>
                                </div>
                                <div class="uk-width-1-2">
                                   <input type="hidden" id="jenis_kainidBodyModal" class="uk-input uk-form-small" placeholder="">
                                   <input type="hidden" id="id_produkBodyModal" class="uk-input uk-form-small" placeholder="">
                                   <input type="hidden" id="nama_produkBodyModal" class="uk-input uk-form-small" placeholder="">
                                   <input type="hidden" id="hargModal" class="uk-input uk-form-small" placeholder="">
                                   <input type="hidden" id="harga-pil" class="uk-input uk-form-small" placeholder="">
                                   <input type="hidden" id="warnaModal" class="uk-input uk-form-small" placeholder="">
                                   <input type="hidden" id="lebarModal" class="uk-input uk-form-small" placeholder="">
                                   <input type="hidden" id="gramasiModal" class="uk-input uk-form-small" placeholder="">
                                   <input type="number" id="qtyBodyModal" class="uk-input uk-form-small" placeholder="Masukkan qty" required>
                                   <input type="hidden" id="bagian" class="uk-input uk-form-small" placeholder="Masukkan qty">
                                   <input type="hidden" id="harga-asc" class="uk-input uk-form-small" placeholder="">
                                   <input type="hidden" id="namaWarna" class="uk-input uk-form-small" placeholder="">
                                   
                                </div>
                            </form>
                        </div>
                        <div class="uk-margin">
                            <strong>Aksesoris</strong>
                            <form class="uk-grid-small" uk-grid>
                                <div class="uk-width-1-2">
                                   <select id="aksesorisSelect" class="uk-select uk-form-small" required>
                                   </select>
                                </div>
                                <div class="uk-width-1-2">
                                   <input type="number" id="qtyAscModal" class="uk-input uk-form-small" placeholder="Masukkan qty">
                                </div>
                            </form>
                            <span class="uk-text-meta"><span class="uk-margin-small-right" uk-icon="icon: info; ratio: 0.75"></span>Pembelian rib min. 5% dari pembelian body</span>
                        </div>
                    </div>
                    <div>
                        <table class="rz-table-vertical">
                            <tr>
                                <th>Total Body</th>
                                <td class="uk-text-right" id="total_bodyQty"></td>
                                <td class="uk-text-right" id="total_hargabody"></td>
                                <input type="hidden" id="total_hargavaluebody" class="uk-input uk-form-small">
                            </tr>
                            <tr>
                                <th>Total Aksesoris</th>
                                <td class="uk-text-right" id="total_ascQty"></td>
                                <td class="uk-text-right" id="total_hargaasc"></td>
                                <input type="hidden" id="total_hargavalueasc" class="uk-input uk-form-small">
                            </tr>
                            <tr>
                                <th>Total Bayar <span uk-icon="icon: info; ratio: 0.75" uk-tooltip="Harga yang tertera masih bersifat estimasi, harga dan berat yang sudah fixed akan diinformasikan pada halaman konfirmasi pesanan"></span></th>
                                <td></td>
                                <td class="uk-text-right uk-text-bold" id="total_hargasm"></td>
                                <input type="hidden" id="total_harga" class="uk-input uk-form-small">
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
    
            <div class="uk-modal-footer uk-text-right">
                <button class="uk-button uk-button-default uk-modal-close" type="button">Batal</button>
                <button type="button" onclick="addToCart()" class="uk-button uk-button-primary" id="addToCartButton">
                    <span id="addToCartText">Tambah</span>
                    <i id="addToCartLoading" class="ph ph-spinner ph-spin ph-lg custom-spin" style="display: none;"></i>
                </button>
            </div>
    
        </div>
    </div>

    @if(session('success'))
    @push('script')
        <script>
            notif('success', '{{ session('success') }}');
        </script>
    @endpush
    @endif

    @if(session('warning'))
    @push('script')
        <script>
            notif('warning', '{{ session('warning') }}');
        </script>
    @endpush
    @endif

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
                        console.log()
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

</x-app-layout>

