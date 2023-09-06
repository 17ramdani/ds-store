<x-app-layout>
    <section id="pageContent" class="uk-section" uk-height-viewport="offset-bottom: 20">
        <div class="uk-container">
            <div class="uk-margin-large uk-grid-large" uk-grid>
                @include('layouts.inc.sidebar')
                
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
                        <a href="/cart-shop" class="uk-text-small"><span class="uk-margin-small-right" uk-icon="chevron-left"></span>Cart</a>
                    </div>
                     <h3><i class="ph-light ph-shopping-bag-open rz-icon"></i>Checkout</h3>
                      <div class="uk-margin-medium-top" uk-grid>
                          <div class="uk-width-1-2@s">
                              <div class="rz-cart-container">
                                  <h5>Alamat Pengiriman</h5>
                                  <dl>
                                      <dt>{{ $data_cust['nama'] }}</dt>
                                      <dd id="alamat-pilihan">{{ $data_cust['alamat'] }}</dd>
                                  </dl>
                                  <a href="#modalAddressList" class="uk-button uk-button-default uk-button-small" uk-toggle>Ganti Alamat</a>
                              </div>
                          </div>
                          <div class="uk-width-1-2@s">
                              <div class="rz-checkout-container">
                                  <h5>Rincian Pembelian</h5>
                                  
                                  <article>
                                    {{-- @dd($cartdata) --}}
                                    @if($cartdata)
                                        @php
                                            $total_smt = 0;
                                            $bodyItems = [];
                                            $accessoriesItems = [];
                                        @endphp
                            
                                        @foreach ($cartdata as $i => $item)
                                            @php
                                                $tipekain_id = $item['tipe_kain_id'];
                                                $qty_ = $item['qty'];
                                                $satuan = $item['satuan'];
                                                $tipekainData = collect($tipekain)->firstWhere('id', $tipekain_id);
                                                
                                                if ($satuan == "ROLL"){
                                                    $harga_body = $tipekainData['harga_roll'];
                                                }else{
                                                    $harga_asc = $tipekainData['harga_ecer'];
                                                }
                                                if (isset($item['qty_roll'])){
                                                    $qty_roll = $item['qty_roll'];
                                                }else{
                                                    $qty_roll = $tipekainData['qty_roll'];
                                                }
                                                if (isset($item['bagian'])){
                                                    $bagian = $item['bagian'];
                                                }else{
                                                    $bagian = $tipekainData['bagian'];
                                                }

                                                if ($bagian == "accessories") {
                                                    // $harga_body = $item['harga_body'];
                                                    // $harga_asc = $item['harga_asc'];
                                                    if (isset($item['harga_body']) or isset($item['harga_asc'])) {
                                                        $harga_body = $item['harga_body'];
                                                        $harga_asc = $item['harga_asc'];
                                                    } else {
                                                        $harga_body = $harga_body ?? 0;
                                                        $harga_asc = $harga_asc ?? 0;
                                                    }
                                                    $hargax = $harga_body + $harga_asc;
                                                    $item['subtotal'] = $qty_ * $hargax;
                                                    $item['harga'] = $hargax;
                                                    $accessoriesItems[$tipekain_id][] = $item;
                                                } else {
                                                    if($satuan == "ROLL"){
                                                        $hargax = $tipekainData['harga_roll'];
                                                        $item['subtotal'] = $qty_ * $hargax * $qty_roll;
                                                        $item['harga'] = $hargax;
                                                        $bodyItems[$tipekain_id][] = $item;
                                                    }else{
                                                        if (isset($item['harga_body'])) {
                                                            $harga_body = $item['harga_body'];
                                                        } else {
                                                            $harga_body = $tipekainData['harga_ecer'] ?? 0; 
                                                        }
                                                        $hargax = $harga_body;
                                                        $item['subtotal'] = $qty_ * $hargax;
                                                        $item['harga'] = $hargax;
                                                        $bodyItems[$tipekain_id][] = $item;
                                                    }
                                                }
                                            @endphp
                                            <input type="hidden" name="satuan[]" value="{{ $satuan }}" class="uk-input uk-form-small">
                                            <input type="hidden" name="bagian[]" value="{{ $bagian }}" class="uk-input uk-form-small">
                                            <input type="hidden" name="id[]" value="{{ $tipekain_id }}" class="uk-input uk-form-small">
                                            @endforeach
                            
                                            @foreach ($bodyItems as $tipekain_id => $items)
                                                @php
                                                    $dataTipeKain = \App\Models\Barang\TipeKain::with('jenis_kain','lebar', 'gramasi','warna')->where('id', $tipekain_id)->first();
                                                    $nama_kain = $dataTipeKain['nama'];
                                                    // $bagian = $items[0]['bagian'];
                                                    
                                                @endphp
                                                {{-- @dd($dataTipeKain) --}}
                                                <div class="rz-cart-item">
                                                    <dl>
                                                        <dt>{{ $dataTipeKain->jenis_kain->nama }}</dt>
                                                        <dd>{{ $nama_kain }} - {{ $dataTipeKain->warna->keterangan }}</dd>
                                                    </dl>
                                                    @foreach ($items as $item)
                                                        @php
                                                            $satuan = $item['satuan'];
                                                        @endphp
                                                        <div class="uk-grid-small" uk-grid>
                                                            <div class="uk-width-1-5">
                                                                <input type="number" name="qty[]" value="{{ $item['qty'] }}" id="qty-{{ $tipekain_id }}" onkeyup="hitungTotal({{ $tipekain_id }})" class="uk-input uk-form-small" placeholder="30">
                                                            </div>
                                                            <div class="uk-width-auto">
                                                                {{ $satuan }}
                                                            </div>
                                                            <div class="uk-width-expand">
                                                                <ul>
                                                                    <li>
                                                                        <a href="" id="delete-{{ $tipekain_id }}" style="text-decoration: none;font-size:20px;color:#808080;">
                                                                            <i class="ph ph-trash"></i>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="" style="text-decoration: none;font-size:20px;color:#808080;">
                                                                            <i class="ph-light ph-lg ph-heart add-to-wishlist" data-item-id="{{ $tipekain_id }}"></i>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="uk-width-2-5 uk-text-right uk-text-bold">
                                                                Rp. {{ number_format($item['subtotal']) }}
                                                            </div>
                                                        </div>
                                                        @php
                                                            $total_smt += $item['subtotal'];
                                                        @endphp
                                                    @endforeach
                                                </div>
                                            @endforeach
                            
                                            @foreach ($accessoriesItems as $tipekain_id => $items)
                                                @php
                                                    $dataTipeKain = \App\Models\Barang\TipeKain::with('jenis_kain','lebar', 'gramasi','warna')->where('id', $tipekain_id)->first();
                                                    // $nama_kain = $items[0]['nama'];
                                                    $nama_kain = $dataTipeKain['nama'];
                                                    // $bagian = $items[0]['bagian'];
                                                @endphp
                            
                                                <div class="rz-cart-item">
                                                    <dl>
                                                        <dt>{{ $dataTipeKain->jenis_kain->nama }}</dt>
                                                        <dd>{{ $nama_kain }} - {{ $dataTipeKain->warna->keterangan }}</dd>
                                                    </dl>
                                                    @foreach ($items as $item)
                                                        @php
                                                            $satuan = $item['satuan'];
                                                        @endphp
                                                        <div class="uk-grid-small" uk-grid>
                                                            <div class="uk-width-1-5">
                                                                <input type="number" name="qty[]" value="{{ $item['qty'] }}" id="qty-{{ $tipekain_id }}" onkeyup="hitungTotal({{ $tipekain_id }})" class="uk-input uk-form-small" placeholder="30">
                                                            </div>
                                                            <div class="uk-width-auto">
                                                                {{ $satuan }}
                                                            </div>
                                                            <div class="uk-width-expand">
                                                                <ul>
                                                                    <li>
                                                                        <a href="" id="delete-{{ $tipekain_id }}" style="text-decoration: none;font-size:20px;color:#808080;">
                                                                            <i class="ph ph-trash"></i>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="" style="text-decoration: none;font-size:20px;color:#808080;">
                                                                            <i class="ph-light ph-lg ph-heart add-to-wishlist" data-item-id="{{ $tipekain_id }}"></i>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="uk-width-2-5 uk-text-right uk-text-bold">
                                                                Rp. {{ number_format($item['subtotal']) }}
                                                            </div>
                                                        </div>
                                                        @php
                                                            $total_smt += $item['subtotal'];
                                                        @endphp
                                                    @endforeach
                                                </div>
                                            @endforeach
                                                
                                    @else
                                        <p>Tidak ada data.</p>
                                    @endif
                                </article>
                                @if($cartdata)
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
                                            <input name="alamat_kirim" type="hidden" value="{{ $data_cust['alamat'] }}" id="alamat-kirim" class="uk-textarea">      
                                        </div>
                                        @if($data_cust['customer_category_id'] == 3)
                                        <div class="uk-margin">
                                            <label class="uk-form-label">Target kebutuhan</label>
                                            <div class="uk-form-controls">
                                                <input type="date" name="target_kebutuhan" class="uk-input" required>    
                                            </div>
                                        </div>
                                        @endif
                                        <label class="uk-form-label">Catatan</label>
                                        <div class="uk-form-controls">
                                            <textarea rows="2" name="catatan" class="uk-textarea"></textarea>        
                                        </div>
                                  </div>
                                  <div class="uk-margin-top uk-align-right@s">
                                    <button type="submit" class="uk-button uk-button-primary">Submit</button>
                                    </form>
                                  </div>    
                                  @endif            
                              </div>
  
                          </div>
                      </div>
  
                  </div>
    
                <div id="card-container">
                    @include('cards')
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
                            <dd>{{ $data_cust['alamat'] }}</dd>
                            <input type="hidden" value="{{ $data_cust['alamat'] }}" id="alamat-rumah">
                            <div class="uk-margin-small-top">
                                <button class="uk-button uk-button-small uk-button-primary uk-modal-close change-gambar-rumah" type="button">Pilih alamat</button>
                            </div>
                        </dl>
                        <div>
                            <ul class="uk-iconnav">
                                <li><a href="/edit-alamat-rumah" uk-icon="icon: file-edit"></a></li>
                                <li><a href="#" uk-icon="icon: trash"></a></li>
                            </ul>
                        </div>                    
                    </div>
                </li>
                <li>
                    <div class="uk-flex uk-flex-between">
                        <dl>
                            <dt>Kantor</dt>
                            <dd>{{ $data_cust['alamat_perusahaan'] }}</dd>
                            <input type="hidden" value="{{ $data_cust['alamat_perusahaan'] }}" id="alamat-perusahaan">
                            <div class="uk-margin-small-top">
                                <button class="uk-button uk-button-small uk-button-primary uk-modal-close change-gambar-kantor" type="button">Pilih alamat</button>
                            </div>
                        </dl>
                        <div>
                            <ul class="uk-iconnav">
                                <li><a href="/edit-alamat-kantor" uk-icon="icon: file-edit"></a></li>
                                <li><a href="#" uk-icon="icon: trash"></a></li>
                            </ul>
                        </div>                    
                    </div>
                </li>
            </ul>
    
        </div>
    </div>

@if(session('success'))
@push('script')
    <script>
        notif('success', 'Barang siap dicheckout.');
    </script>
@endpush
@endif

@push('script')
<script>
    $(document).ready(function() {
       $('.change-gambar-rumah').click(function(e) {
           e.preventDefault();
           var alam_rumah = $('#alamat-rumah').val();
           var alam_prsha = $('#alamat-perusahaan').val();
        //    alert(alam_prsha)

           $('#alamat-pilihan').text(alam_rumah);
           $('#alamat-kirim').val(alam_rumah);
       });
   })
</script>
<script>
    $(document).ready(function() {
       $('.change-gambar-kantor').click(function(e) {
           e.preventDefault();
           
           var alam_rumah = $('#alamat-rumah').val();
           var alam_prsha = $('#alamat-perusahaan').val();
        //    alert(alam_rumah)

           $('#alamat-pilihan').text(alam_prsha);
           $('#alamat-kirim').val(alam_prsha);
       });
   })
</script>
@endpush
</x-app-layout>