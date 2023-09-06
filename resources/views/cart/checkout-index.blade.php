<x-app-layout>
    <section id="pageContent" class="uk-section" uk-height-viewport="offset-bottom: 20">
        <div class="uk-container">
            <div class="uk-margin-large uk-grid-large" uk-grid>
                {{-- @include('layouts.inc.sidebar') --}}
                @include('layouts.inc.app-sidebar')
                <!-- Contains uk-width-1-4@s. Don't screw up! -->
                <div class="uk-width-3-4@s">

                    <!-- Mobile-only product sidebar -->
                    {{-- <div class="uk-hidden@s" uk-grid>
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
                </div>  --}}

                    <div class="rz-detail-product" id="page-checkout">
                        <div>

                            <a href="/cart-shop" class="uk-text-small"><span class="uk-margin-small-right"
                                    uk-icon="chevron-left"></span>Cart</a>

                        </div>
                        <h3><i class="ph-light ph-shopping-bag-open rz-icon"></i>Checkout</h3>
                        <div class="uk-margin-medium-top" uk-grid>
                            <div class="uk-width-1-2@s">
                                <div class="rz-cart-container">
                                    <h5>Alamat Pengiriman</h5>
                                    <dl>
                                        <dt id="penerima-label">{{ $address_primary->name ?? $data_cust['nama'] }}</dt>
                                        <dd id="alamat-pilihan">
                                            {{ $address_primary->full_address ?? $data_cust['alamat'] }}</dd>
                                    </dl>
                                    <a href="#modalAddressList" class="uk-button uk-button-default uk-button-small"
                                        uk-toggle>Ganti Alamat</a>
                                </div>
                            </div>
                            <div class="uk-width-1-2@s">
                                <div class="rz-checkout-container">
                                    <h5>Rincian Pembelian</h5>
                                    @php
                                        $total_smt = 0;
                                        $btnSubmitSts = 'disabled';
                                    @endphp
                                    <article>
                                        {{-- @dd($cartdata) --}}
                                        @if ($cartdata && count($cartdata) != 0)
                                            @php
                                                $btnSubmitSts = '';
                                            @endphp
                                            @foreach ($cartdata as $i => $item)
                                                @php
                                                    $tipekain_id = $item['tipe_kain_id'];
                                                    $satuan = $item['satuan'];
                                                    $bagian = $item['bagian'];
                                                    $qty = $item['qty'];
                                                    $satuan_harga = $satuan;
                                                    if ($satuan != 'ROLL') {
                                                        $satuan_harga = 'ECER';
                                                    }
                                                    $id_keranjang = isset($item['id']) ? $item['id'] : '0';
                                                @endphp
                                                @if ($bagian == 'body')
                                                    @php
                                                        $data = App\Models\Barang\TipeKain::with('jenis_kain', 'lebar', 'gramasi', 'warna', 'satuan')
                                                            ->where('id', $tipekain_id)
                                                            ->firstOrFail();
                                                        
                                                        $maxperiode = DB::table('tipe_kain_prices')
                                                            ->where([['tipe_kain_id', $tipekain_id], ['tipe', $satuan_harga], ['customer_category_id', $cust_cat]])
                                                            ->MAX('periode');
                                                        
                                                        $daharga = DB::table('tipe_kain_prices')
                                                            ->where([['tipe_kain_id', $tipekain_id], ['tipe', $satuan_harga], ['customer_category_id', $cust_cat], ['periode', $maxperiode]])
                                                            ->first();
                                                        $jenisKain = $data['jenis_kain']['nama'];
                                                        $namaKain = $data['nama'];
                                                        $warnKain = $data['warna']['nama'];
                                                        $harga = $daharga->harga;
                                                        if ($satuan == 'ROLL') {
                                                            $satuan_view = 'ROLL';
                                                            $subtotal = $harga * $qty * $data['qty_roll'];
                                                        } else {
                                                            $subtotal = $harga * $qty;
                                                            $satuan_view = $data['satuan']['keterangan'];
                                                        }
                                                        $total_smt += $subtotal;
                                                    @endphp
                                                    <div class="rz-cart-item">
                                                        <div class="uk-grid-medium" uk-grid>
                                                            <div class="uk-width-4-5">
                                                                <dl>
                                                                    <dt>{{ $jenisKain }}</dt>
                                                                    <dd>{{ $namaKain }} - {{ $warnKain }}</dd>
                                                                </dl>
                                                            </div>
                                                            <div class="uk-width-1-5 uk-text-right">
                                                                <a href="" id="delete-{{ $tipekain_id }}"
                                                                    class="delete-item" data-id="{{ $tipekain_id }}"
                                                                    style="text-decoration: none;font-size:20px;color:#808080;">
                                                                    <i class="ph ph-trash"></i>
                                                                </a>
                                                            </div>
                                                        </div>

                                                        <div class="uk-grid-small" uk-grid>
                                                            <div class="uk-width-1-5">
                                                                <input type="number" name="qty[]"
                                                                    value="{{ $item['qty'] }}"
                                                                    id="qty-{{ $tipekain_id }}"
                                                                    onkeyup="hitungTotal({{ $tipekain_id }})"
                                                                    class="uk-input uk-form-small" placeholder="30">
                                                                <input type="hidden" name="id_keranjang[]"
                                                                    value="{{ $id_keranjang }}"
                                                                    class="uk-input uk-form-small" placeholder="">
                                                                <input type="hidden" name="satuan[]"
                                                                    value="{{ $satuan }}"
                                                                    class="uk-input uk-form-small">
                                                                <input type="hidden" name="bagian[]"
                                                                    value="{{ $bagian }}"
                                                                    class="uk-input uk-form-small">
                                                                <input type="hidden" name="id[]"
                                                                    value="{{ $tipekain_id }}"
                                                                    class="uk-input uk-form-small">
                                                                <input type="hidden" name="bagian[]"
                                                                    value="{{ $bagian }}"
                                                                    class="uk-input uk-form-small">
                                                            </div>
                                                            <div class="uk-width-auto">
                                                                {{ $satuan_view }}
                                                            </div>
                                                            {{-- <div class="uk-width-expand">
                                                                <ul>
                                                                    <li>

                                                                    </li>
                                                                    <li>
                                                                        <a href=""
                                                                            style="text-decoration: none;font-size:20px;color:#808080;">
                                                                            <i class="ph-light ph-lg ph-heart add-to-wishlist"
                                                                                data-item-id="{{ $tipekain_id }}"></i>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div> --}}
                                                            <div class="uk-width-expand uk-text-right uk-text-bold">
                                                                {{-- Rp. {{ number_format($item['subtotal']) }} --}}
                                                                Rp. {{ number_format($subtotal) }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    @php
                                                        $dataasc = App\Models\Barang\TipeKainAccessories::where('id', $tipekain_id)->first();
                                                        $idasc = $dataasc['tipe_kain_id'];
                                                        $maxperiode = DB::table('tipe_kain_prices')
                                                            ->where([['tipe_kain_id', $idasc], ['tipe', $satuan_harga], ['customer_category_id', $cust_cat]])
                                                            ->MAX('periode');
                                                        
                                                        $data = DB::table('tipe_kain_accessories as tka')
                                                            ->leftJoin('accessories as acs', 'acs.id', '=', 'tka.accessories_id')
                                                            ->leftJoin('tipe_kain_prices as tkp', 'tkp.tipe_kain_id', '=', 'tka.tipe_kain_id')
                                                            ->where([['tka.id', $tipekain_id], ['tkp.tipe_kain_id', $idasc], ['tkp.tipe', $satuan_harga], ['tkp.customer_category_id', $cust_cat], ['tkp.periode', $maxperiode]])
                                                            ->selectRaw('tka.id,acs.name,acs.harga_roll,acs.harga_ecer,tkp.harga')
                                                            ->first();
                                                        $harga_roll = $data->harga_roll;
                                                        $harga_ecer = $data->harga_ecer;
                                                        $harga_bdy = $data->harga;
                                                        // dd($data);
                                                        $namaAccessories = $data->name;
                                                        $harga = $harga_bdy + $harga_roll;
                                                        if ($satuan != 'ROLL') {
                                                            $harga = $harga_bdy + $harga_ecer;
                                                        }
                                                        $subtotal = $harga * $qty;
                                                        $total_smt += $subtotal;
                                                    @endphp
                                                    <div class="rz-cart-item">
                                                        <dl>
                                                            <dt>{{ $namaAccessories }}</dt>
                                                            <dd>{{ $warnKain }}</dd>
                                                        </dl>
                                                        <div class="uk-grid-small" uk-grid>
                                                            <div class="uk-width-1-5">
                                                                <input type="hidden" name="qty1[]"
                                                                    value="{{ $item['qty'] }}"
                                                                    id="qty-{{ $tipekain_id }}"
                                                                    onkeyup="hitungTotal({{ $tipekain_id }})"
                                                                    class="uk-input uk-form-small" placeholder="30">
                                                                <input type="number" name="qty[]"
                                                                    value="{{ $qty }}"
                                                                    id="qty-{{ $tipekain_id }}"
                                                                    onkeyup="hitungTotal({{ $tipekain_id }})"
                                                                    class="uk-input uk-form-small" placeholder="30">
                                                                <input type="hidden" name="id_keranjang[]"
                                                                    value="{{ $id_keranjang }}"
                                                                    class="uk-input uk-form-small" placeholder="">
                                                                <input type="hidden" name="id[]"
                                                                    value="{{ $tipekain_id }}"
                                                                    class="uk-input uk-form-small">
                                                                <input type="hidden" name="bagian[]"
                                                                    value="{{ $bagian }}"
                                                                    class="uk-input uk-form-small">
                                                            </div>
                                                            <div class="uk-width-auto">
                                                                {{ $satuan_view }}
                                                            </div>
                                                            {{-- <div class="uk-width-expand">
                                                                <ul>
                                                                    <li>
                                                                        <a href=""
                                                                            id="delete-{{ $tipekain_id }}"
                                                                            class="delete-item"
                                                                            data-id="{{ $tipekain_id }}"
                                                                            style="text-decoration: none;font-size:20px;color:#808080;">
                                                                            <i class="ph ph-trash"></i>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href=""
                                                                            style="text-decoration: none;font-size:20px;color:#808080;">
                                                                            <i class="ph-light ph-lg ph-heart add-to-wishlist"
                                                                                data-item-id="{{ $tipekain_id }}"></i>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div> --}}
                                                            <div class="uk-width-expand uk-text-right uk-text-bold">
                                                                {{-- Rp. {{ number_format($item['subtotal']) }} --}}
                                                                Rp. {{ number_format($subtotal) }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @else
                                            <div class="uk-alert-warning" uk-alert>
                                                <a class="uk-alert-close" uk-close></a>
                                                <p class="uk-text-center">Item tidak ditemukan.</p>
                                            </div>
                                        @endif

                                    </article>
                                    @if ($cartdata)
                                        <article class="rz-values-horizontal uk-text-small">
                                            <dl>
                                                <dt>Subtotal</dt>
                                                <dd>Rp. {{ number_format($total_smt) }}</dd>
                                            </dl>
                                            <dl>
                                                <dt>Diskon</dt>
                                                <dd>Rp. 0</dd>
                                            </dl>
                                            <dl>
                                                <dt>Ongkos Kirim</dt>
                                                <dd>Rp. 0</dd>
                                            </dl>
                                            <hr>
                                            <dl>
                                                <dt>TOTAL</dt>
                                                <dd class="uk-text-bold">Rp. {{ number_format($total_smt) }}</dd>
                                            </dl>
                                        </article>
                                        <div class="uk-margin">
                                            <form action="checkout" class="uk-form-stacked" method="POST">
                                                @csrf
                                                <div class="uk-form-controls">
                                                    <input type="hidden" name="addr_id" id="addr_id"
                                                        value="{{ $address_primary->id ?? 0 }}">
                                                    <input type="hidden" name="penerima" id="penerima"
                                                        value="{{ $address_primary->name ?? $data_cust->nama }}">
                                                    <input name="alamat_kirim" type="hidden"
                                                        value="{{ $address_primary->full_address ?? $data_cust['alamat'] }}"
                                                        id="alamat-kirim" class="uk-textarea">
                                                </div>
                                                @if ($data_cust['customer_category_id'] == 3)
                                                    <div class="uk-margin">
                                                        <label class="uk-form-label">Target kebutuhan</label>
                                                        <div class="uk-form-controls">
                                                            <input type="date" name="target_kebutuhan"
                                                                class="uk-input" required>
                                                        </div>
                                                    </div>
                                                @endif
                                                <label class="uk-form-label">Catatan</label>
                                                <div class="uk-form-controls">
                                                    <textarea rows="2" name="catatan" class="uk-textarea"></textarea>
                                                </div>
                                        </div>
                                        <div class="uk-margin-top uk-align-right@s">
                                            <button type="submit" class="uk-button uk-button-primary"
                                                {{ $btnSubmitSts }}>Submit</button>
                                            </form>
                                        </div>
                                    @endif
                                </div>

                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>

    @include('cart.inc.modal-add-address')

    @if (session('success'))
        @push('script')
            <script>
                notif('success', 'Barang siap dicheckout.');
            </script>
        @endpush
    @endif

    @push('script')
        <script>
            function changeAddress(ele) {
                let address = $(ele).data('alamat');
                let penerima = $(ele).data('penerima');
                let id = $(ele).data('addrid');
                $('#addr_id').val(id);
                $('#penerima-label').text(penerima);
                $('#penerima').val(penerima);
                $('#alamat-pilihan').text(address);
                $('#alamat-kirim').val(address);
                UIkit.modal('#modalAddressList').hide();
                console.log(penerima);
            }
            // $('.change-address').on('click', function() {
            //     let address = $(this).data('alamat');
            //     let penerima = $(this).data('penerima');
            //     let id = $(this).data('addrid');
            //     $('#addr_id').val(id);
            //     $('#penerima-label').text(penerima);
            //     $('#penerima').val(penerima);
            //     $('#alamat-pilihan').text(address);
            //     $('#alamat-kirim').val(address);
            //     UIkit.modal('#modalAddressList').hide();
            // });

            $('#form-add-address').on('submit', function(e) {
                e.preventDefault();
                let dataForm = new FormData($(this)[0]);
                dataForm.append('customer_id', "{{ $data_cust->id }}");
                $.ajax({
                    type: "POST",
                    url: "{{ route('address.store') }}",
                    data: dataForm,
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        notif('success', response.message);
                        UIkit.modal('#modalAddressAdd').hide();
                        UIkit.modal('#modalAddressList').show();
                        listAddress();
                    }
                });
            });

            function listAddress() {
                let template = ``;
                $.ajax({
                    type: "get",
                    url: "{{ route('address.index') }}",
                    data: {},
                    dataType: "json",
                    success: function(response) {
                        $('#list-address').html(template);
                        $.each(response.datas, function(i, item) {
                            template += `<li>
                    <div class="uk-flex uk-flex-between">
                        <dl>
                            <dt>${item.name}</dt>
                            <dd>${item.full_address}</dd>
                            <div class="uk-margin-small-top">
                                <button data-alamat="${item.full_address}" data-penerima="${item.name}"
                                    data-addrid="${item.id}"
                                    class="uk-button uk-button-small uk-button-primary uk-modal-close change-address"
                                    type="button" onclick="changeAddress(this)">Pilih alamat</button>
                            </div>
                        </dl>
                        <div>
                            <ul class="uk-iconnav">
                                <li><a  onclick="editAddress(this)" data-addrid="${item.id}"
                                        data-penerima="${item.name}" data-category="${item.category}"
                                        data-fulladdress="${item.full_address}" uk-icon="icon: file-edit"></a></li>
                                <li><a onclick="deleteAddress(this)" data-addrid="${item.id}" uk-icon="icon: trash"></a></li>
                            </ul>
                        </div>
                    </div>
                </li>`;
                        });
                        $('#list-address').append(template);
                    }
                });
            }

            //delete ITEM cart
            $('.delete-item').on('click', function(event) {
                event.preventDefault();

                const tipekainId = $(this).data('id');
                const grp = $(this).data('grp');

                $.ajax({
                    url: '/delete-item',
                    type: 'POST',
                    data: {
                        item_id: tipekainId,
                        grp: grp
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        // console.log(response)
                        notif('success', 'Item berhasil di hapus!');
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });

            });

            function editAddress(ele) {
                let id = $(ele).data('addrid');
                let penerima = $(ele).data('penerima');
                let category = $(ele).data('category');
                let fullAddress = $(ele).data('fulladdress');
                let action = "{{ url('/address') }}/" + id

                UIkit.modal('#modalAddressEdit').show();
                $('#edit_nama_penerima').val(penerima);
                $('#edit_kategori_alamat').val(category);
                $('#edit_alamat_lengkap').val(fullAddress);
                $('#form-edit-address').attr('action', action);
            }
            $('#form-edit-address').on('submit', function(e) {
                e.preventDefault();
                let dataForm = new FormData($(this)[0]);
                dataForm.append('customer_id', "{{ $data_cust->id }}");
                $.ajax({
                    type: "POST",
                    url: $(this).attr("action"),
                    data: dataForm,
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        notif('success', response.message);
                        UIkit.modal('#modalAddressEdit').hide();
                        UIkit.modal('#modalAddressList').show();
                        listAddress();
                    }
                });
            });

            function deleteAddress(ele) {
                let id = $(ele).data('addrid');
                UIkit.modal.confirm('Apakah anda yakin ?').then(function() {
                    $.ajax({
                        type: "POST",
                        url: "{{ url('/address') }}/" + id,
                        data: {
                            _method: "DELETE"
                        },
                        dataType: "json",
                        success: function(response) {
                            notif('success', response.message);
                            UIkit.modal('#modalAddressList').hide();
                            listAddress();
                        },
                        error: function(response) {
                            notif('error', response.responseJSON.message);
                        }
                    });
                }, function() {
                    console.log('Rejected.');
                });
            }
        </script>
    @endpush
</x-app-layout>
