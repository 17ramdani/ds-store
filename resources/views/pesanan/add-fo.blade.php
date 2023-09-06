<x-app-layout>
    <section id="pageContent" class="uk-section" uk-height-viewport="offset-bottom: 20">
        <div class="uk-container">
            <div class="uk-margin-large uk-grid-large" uk-grid>
                @include('layouts.inc.app-sidebar')


                <!-- Contains uk-width-1-4@s. Don't screw up! -->
                <div class="uk-width-3-4@s">

                    <div class="rz-detail-order">
                       <h4><i class="ph-light ph-hammer rz-icon"></i>Pesanan {{ $tipe }}</h4>
                        <x-alert/>
                       <form class="uk-form-horizontal uk-margin-large" method="POST" action="{{ route('order.create') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="uk-margin">
                            <label class="uk-form-label">Jenis Kain</label>
                            <div class="uk-form-controls">
                                <input class="uk-input" type="text" name="jenis_kain" value="{{ old('jenis_kain') }}" placeholder="e.g SK M61 COMBED 30S">
                            </div>
                        </div>
                        <div class="uk-margin">
                            <label class="uk-form-label">Tipe Kain</label>
                            <div class="uk-form-controls">
                                <input class="uk-input" type="text" name="tipe_kain" value="{{ old('tipe_kain') }}" placeholder="e.g Misty Single Knit">
                            </div>
                        </div>

                        <div class="uk-margin">
                            <label class="uk-form-label">Warna</label>
                            <div class="uk-form-controls">
                                <input class="uk-input" type="text" name="warna" value="{{ old('warna') }}"  placeholder="e.g Merah Tua">

                            </div>
                        </div>
                        <div class="uk-margin">
                            <label class="uk-form-label">Gramasi</label>
                            <div class="uk-form-controls">

                                <input class="uk-input" type="text" name="gramasi" value="{{ old('gramasi') }}"  placeholder="e.g 30s">

                            </div>
                        </div>
                        <div class="uk-margin">
                            <label class="uk-form-label">Lebar</label>
                            <div class="uk-form-controls">

                                <input class="uk-input" type="text" name="lebar" value="{{ old('lebar') }}"  placeholder="e.g 30s">

                            </div>
                        </div>
                        <div class="uk-margin">
                            <label class="uk-form-label">Qty Pesanan (Roll)</label>
                            <div class="uk-form-controls">

                                <input class="uk-input" type="number" name="qty_pesanan" value="{{ old('qty_pesanan') }}" >
                            </div>
                        </div>

                        <div class="uk-margin">
                            <div class="uk-form-label">Aksesoris</div>
                            <div class="uk-form-controls">
                                <div>
                                    <table class="uk-table uk-table-small uk-text-small rz-table-vertical-alt">
                                        <tr>
                                            <th class="uk-width-auto">Rib (kg)</th>
                                            <td class="uk-table-shrink">:</td>

                                            <td><input type="number" class="uk-input uk-form-small" name="rib" min="0" step="0.01" value="{{ old('rib')??0 }}"></td>
                                        </tr>
                                        <tr>
                                            <th class="uk-width-auto">Rib Spandex(kg)</th>
                                            <td class="uk-table-shrink">:</td>
                                            <td><input type="number" class="uk-input uk-form-small" name="rib_spandex" min="0" step="0.01" value="{{ old('rib_spandex')??0 }}"></td>

                                        </tr>
                                        <tr>
                                            <th class="uk-width-auto">Bur (kg)</th>
                                            <td class="uk-table-shrink">:</td>

                                            <td><input type="number" class="uk-input uk-form-small" name="bur" min="0" step="0.01" value="{{ old('bur')??0 }}"></td>

                                        </tr>
                                        <tr>
                                            <th class="uk-width-auto">Bur Spandex (kg)</th>
                                            <td class="uk-table-shrink">:</td>

                                            <td><input type="number" class="uk-input uk-form-small" name="bur_spandex" min="0" step="0.01" value="{{ old('bur_spandex')??0 }}"></td>

                                        </tr>
                                        <tr>
                                            <th class="uk-width-auto">Kerah (kg)</th>
                                            <td class="uk-table-shrink">:</td>

                                            <td><input type="number" class="uk-input uk-form-small" name="kerah" min="0" step="0.01" value="{{ old('kerah')??0 }}"></td>

                                        </tr>
                                        <tr>
                                            <th class="uk-width-auto">Manset (kg)</th>
                                            <td class="uk-table-shrink">:</td>

                                            <td><input type="number" class="uk-input uk-form-small" name="manset" min="0" step="0.01" value="{{ old('manset')??0 }}"></td>
                                        </tr>

                                    </table>
                                </div>
                            </div>

                        </div>

                        <div class="uk-margin">
                            <label class="uk-form-label">Keterangan</label>
                            <div class="uk-form-controls">
                                <textarea rows="3" class="uk-textarea" name="keterangan">{{ old('keterangan') }}</textarea>

                            </div>
                        </div>
                        <div class="uk-margin">
                            <label class="uk-form-label">Gambar</label>
                            <div class="uk-form-controls">
                                <div class="js-upload" uk-form-custom>

                                    <input type="file" name="gambar" id="gambar" onchange="getFileData()">

                                    <button class="uk-button uk-button-default" type="button" tabindex="-1">Pilih File</button>
                                </div>
                                <span class="uk-margin-medium-top" id="filename"></span>
                            </div>
                        </div>

                        <input type="hidden" name="tipe_pesanan" value="{{ $tipe }}">

                        <div class="uk-margin-large-top uk-text-right">
                            <button type="submit" class="uk-button uk-button-primary">Submit</button>
                        </div>
                    </form>

                    </div>

                </div>

            </div>
        </div>
    </section>

    {{-- @include('pesanan.inc.modal-chart-new') --}}

    {{-- @include('modal-add-tocart') --}}

    @push('script')
    <script>
        function getFileData() {
                const fileInput = document.getElementById('gambar');
                const fileNamesContainer = document.getElementById('filename');

                // Clear previous file names (if any)
                fileNamesContainer.innerHTML = '';

                // Get the selected files
                const files = fileInput.files;

                // Display each file name
                for (let i = 0; i < files.length; i++) {
                    const fileName = files[i].name;
                    const fileNameElement = document.createElement('p');
                    fileNameElement.textContent = fileName;
                    fileNamesContainer.appendChild(fileNameElement);
                }
            }

        //      $(document).ready(function() {
        //     $(document).on('click', '.add-modal-cart', function() {
        //         var id  = $(this).attr('data-idx');
        //         $.ajax({
        //             url: '/get-product-modal',
        //             type: 'GET',
        //             data: {
        //                 id: id
        //             },
        //             success: function(data) {
        //                 // console.log(data.asc);
        //                 var id_product      = data.datas.id;
        //                 var nama_kain       = data.datas.nama;
        //                 var gramasi         = data.datas.gramasi.nama;
        //                 var lebar           = data.datas.lebar.keterangan;
        //                 var warna           = data.datas.warna.nama;
        //                 var harga_product   = data.datas.harga_ecer;
        //                 var qty_roll        = data.datas.qty_roll;
        //                 var bagian          = data.datas.bagian

        //                 let optvalue = "";
        //                 let optasc = "";

        //                 $('#satuan-body').empty();
        //                 $('#satuan-accessories').empty();
        //                 $('#qty-body').val('');
        //                 $('#qty-accessories').val('');
        //                 $('#total-qty-body').empty();
        //                 $('#total-qty-asc').empty();
        //                 $('#total-body').empty();
        //                 $('#total-harga-asc').empty();
        //                 $('#total-bayar').empty();

        //                 optasc += `<option value="">--PILIH--</option>`;
        //                 $.each(data.asc, function(i, item) {
        //                     optasc += `<option value="${item.id}">${item.nama}</option>`;
        //                 });
        //                 $('#satuan-accessories').append(optasc);

        //                 optvalue += `<option value="">--PILIH--</option>`;
        //                 $.each(data.satuan, function(i2, item2) {
        //                     optvalue +=
        //                         `<option value="${item2.satuan.keterangan}">${item2.satuan.keterangan}</option>`;
        //                 });
        //                 optvalue += `<option value="ROLL">ROLL</option>`;
        //                 $('#satuan-body').append(optvalue);

        //                 $('#judulmodal-fo').text(nama_kain)
        //                 $('#judullebar-fo').text(lebar)
        //                 $('#judulgramasi-fo').text(gramasi)
        //                 $('#judulwarna-fo').text(warna)

        //                 $('#id-product').val(id_product)
        //                 $('#harga-product').val(harga_product)
        //                 $('#qty-roll').val(qty_roll)
        //                 $('#bagian').val(bagian)
        //             },
        //             error: function(xhr, status, error) {
        //                 notif('error', 'Server Error!');
        //             }
        //         })
        //     });
        // });
    </script>
    @endpush
</x-app-layout>
