<x-app-layout>
    <section id="navbarSecondary" class="uk-flex uk-flex-middle uk-flex-left">
        <div class="uk-width-1-1">
            <div class="uk-container">
                <h2 class="rz-text-pagetitle">Pesanan</h2>
            </div>

        </div>

    </section>
    <section class="uk-margin-medium">
        <div class="uk-container">
            <div class="rz-panel">
                <div class="uk-flex uk-flex-between">
                    <h3>Form Pesanan Baru</h3>
                </div>

                <div>
                    <form class="uk-form-stacked uk-position-relative">

                        <div uk-grid>
                            <div class="uk-width-1-2@l">
                                <div class="uk-margin">
                                    <label class="uk-form-label">Jenis Kain</label>
                                    <div class="uk-form-controls">
                                        <select class="uk-select" name="jenis_kain" id="jenis_kain" required>
                                            <option value="">--Pilih--</option>
                                            @endphp
                                            @foreach ($jenis as $item)
                                                {{-- @php
                                                $jenis_kain = explode(".",$item->nama);
                                                $namaj_kain = $jenis_kain[1];
                                                @endphp --}}
                                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="uk-margin">
                                    <label class="uk-form-label">Tipe Kain</label>
                                    <div class="uk-form-controls">
                                        <select id="tipe_kain" name="tipe_kain" class="uk-select" required>
                                            <option>--Pilih--</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="uk-margin-large-bottom">
                                    <label class="uk-form-label">Kategori Warna</label>
                                    <div class="uk-form-controls">
                                        <select id="kategori_warna" name="kategori_warna" class="uk-select" required>
                                            <option>--Pilih--</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="uk-width-1-2@l">

                            </div>
                        </div>

                        <div class="uk-margin" id="barang-list" hidden>
                            <div id="kain1" class="uk-margin">
                                <div id="kain1_display">
                                    {{-- {{  }} --}}
                                    <img class="uk-object-cover" id="imgid" width="500" height="200"
                                        style="aspect-ratio: 2 / 1"
                                        src="https://duniasandang.com/wp-content/uploads/2022/01/combed-30s-dunia-sandang-1.jpg"
                                        alt="">
                                </div>
                                {{-- <div class="uk-margin-large-top">
                                    <div class="uk-form-controls">
                                        <div class="uk-margin">
                                            <input class="uk-input uk-form-width-large" type="text" id="search" placeholder="Search By warna..">
                                        </div>
                                    </div>
                                </div> --}}
                                <table class="uk-table uk-table-small uk-table-responsive uk-table-striped"
                                    id="table-barang">
                                    <thead>
                                        <tr>
                                            <th>Barang</th>
                                            <th>L/GSM</th>
                                            <th>Warna</th>
                                            <th>Satuan</th>
                                            <th>Qty</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- <tr>
                                            <td>SK.CARDED 24'S</td>
                                            <td>42" /170-180 &amp; 42"/180-190</td>
                                            <td>PUTIH</td>
                                            <td>Roll</td>
                                            <td><input type="number" class="uk-input" placeholder="Qty"></td>
                                            <td><a href=""><span uk-icon="cart"></span></a></td>
                                        </tr> --}}
                                    </tbody>
                                    {{-- <tfoot>
                                        <tr>
                                            <th>
                                                <span id="nama_atd"></span>
                                                <input type="hidden" name="nama_assesoris" id="nama_assesoris"  class="uk-input uk-form-width-small" >
                                                <input type="hidden" name="id_assesoris" id="id_assesoris"  class="uk-input uk-form-width-small" >
                                            </th>
                                            <th>
                                                <span id="lgm_atd"></span>
                                            </th>
                                            <th>-</th>
                                            <th>
                                                -
                                            </th>
                                            <th><input type="text" readonly value="KG" name="satuan_accesories" id="satuan_accesories" class="uk-input uk-form-width-small" ></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tfoot> --}}
                                </table>
                                {{-- <div class="uk-margin">
                                    <label class="uk-form-label">Target Kebutuhan</label>
                                    <div class="uk-form-controls">
                                        <div class="uk-margin">
                                            <input class="uk-input uk-form-width-large" name="target_pesanan"
                                                id="target_pesanan" type="date" placeholder="" aria-label="Large">
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                        </div>

                        <div class="uk-text-meta uk-text-small">
                            <p>Jika pilihan kain dan warna tidak ada, silahkan klik tombol Pesanan Development di bawah
                            </p>
                        </div>


                        <div class="uk-margin-medium-top uk-child-width-1-2@s" uk-grid>
                            <div>
                                <a href="#modalWhiteList"
                                    class="uk-button uk-border-rounded uk-button-default uk-margin-small-right"
                                    uk-toggle><span class="uk-margin-small-right" uk-icon="heart"></span>Wishlist
                                    <small id="label_whitelist_count" class="uk-badge">0</small>
                                </a>
                                {{-- <button type="button" id="button-submit" onclick="keranjangSubmit()"
                                    class="uk-button uk-border-rounded uk-button-primary uk-margin-small-right">
                                    <span id="loading-submit" uk-spinner="ratio: 0.6" hidden></span>Submit
                                </button> --}}
                                <button type="button" id="button-submit" onclick="keranjangSubmit()"
                                    class="uk-button uk-border-rounded uk-button-primary uk-margin-small-right">
                                    <span id="loading-submit" uk-spinner="ratio: 0.6" hidden></span>Lanjutkan
                                </button>
                                <a href="#modalCart" class="uk-visible@m uk-button uk-button-default uk-border-rounded"
                                    uk-toggle><span class="uk-margin-small-right" uk-icon="cart"></span>
                                    <small id="label_keranjang_count" class="uk-badge">0</small>
                                </a>
                            </div>
                            <div class="uk-text-right@s">
                                <a href="https://api.whatsapp.com/send/?phone=%2B6281222776523&text&type=phone_number&app_absent=0"
                                    class="uk-button uk-button-default uk-border-rounded ">Pesanan
                                    Development</a>
                            </div>
                        </div>
                    </form>
                </div>


            </div>
        </div>
    </section>
    <div id="modalSubmitOrder" class="uk-flex-top" uk-modal>
        <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical uk-text-center">

            <button class="uk-modal-close-default" type="button" uk-close></button>

            <p id="submit-message"></p>
            <div id="link-modalSubmitOrder"></div>
        </div>
    </div>
    @push('css')
        <link rel="stylesheet" href="{{ asset('plugins/datatable/datatable.uikit.min.css') }}">
    @endpush
    @push('js')
        <script src="{{ asset('plugins/datatable/dataTables.min.js') }}"></script>
        <script src="{{ asset('plugins/datatable/datatable.uikit.min.js') }}"></script>
    @endpush
    @push('script')
        <script>
            // $('#search').on('keyup', function() {
            //     let keyword     = $(this).val();
            //     let jenis       = $("#jenis_kain").val();
            //     let tipe_kain   = $("#tipe_kain").val();

            //     $.ajax({
            //             type: "POST",
            //             url: "{{ url('/search-by-tipe') }}/" + jenis,
            //             data: {
            //                 keyword : keyword,
            //                 tipe_name: tipe_kain
            //             },
            //             dataType: "json",
            //             success: function(response) {
            //                 let row = "";
            //                 let optvalue = "";
            //                 let optwarnav = "";
            //                 let asc = response.acesoris.id;
            //                 $.each(response.satuan, function(i2, item2) {
            //                     optvalue += `<option value="${item2.keterangan}">${item2.keterangan}</option>`;
            //                 });
            //                 $.each(response.datas, function(i, item) {
            //                     var cat_warna = item.warna_id;
            //                     var nama_kain = item.nama;
            //                     getWarnaId(cat_warna,i);
            //                     row += `<tr>
    //                                 <td>${item.nama}</td>
    //                                 <td>${item.lebar.keterangan} / ${item.gramasi.nama}</td>
    //                                 <td>${item.warna.nama}</td>
    //                                 <td>
    //                                         <select class="uk-input warna_kain" id="warna-${i}">
    //                                         </select>
    //                                 </td>
    //                                 <td>
    //                                     <select class="uk-input" id="satuans-${i}">
    //                                         ${optvalue}
    //                                     </select>
    //                                 </td>
    //                                 <td><input type="number" id="qty-${i}" class="uk-input" placeholder="Qty" min="1" value="1">
    //                                     <input type="hidden" name="id_assesoris" value="${asc}" id="id_assesoris-${i}"  class="uk-input uk-form-width-small" >
    //                                     <input type="hidden" readonly value="KG" name="satuan_accesories" id="satuan_accesories-${i}" class="uk-input uk-form-width-small">
    //                                 </td>
    //                                 <td><a onclick="storeKeranjang(${item.id},${i})"><span uk-icon="cart"></span></a></td>
    //                                 <td><a onclick="storeWhiteList(${item.id},${i})"><span uk-icon="heart"></span></a></td>
    //                             </tr>`;
            //                 });
            //                 $('#table-barang tbody').html(row);
            //             }
            //         });
            // })
        </script>
    @endpush
    @include('pesanan.inc.modal-chart')
    @include('whitelist.inc.modal-whitelist')
    @push('script')
        <script>
            $(function() {
                listKeranjang()
                listWhiteList()
            });
            $('#jenis_kain').on('change', function() {
                let jenis = $(this).val();
                $('#tipe_kain').empty();
                let option = "<option value='0'>-pilih-</option>";
                $.ajax({
                    type: "GET",
                    url: "{{ url('/kain-by-jenis') }}/" + jenis,
                    data: {},
                    dataType: "json",
                    success: function(response) {
                        $.each(response.datas, function(i, item) {
                            option += `<option value="${item.nama}">${item.nama}</option>`;

                        });
                        $('#tipe_kain').html(option);
                    }
                });
            });
            $('#tipe_kain').on('change', function() {
                let jenis = $("#jenis_kain").val();
                let tipe = $(this).val();
                $('#kategori_warna').empty();
                changeGambar(tipe);
                let option = "<option value='0'>-pilih-</option>";
                $.ajax({
                    type: "GET",
                    url: "{{ url('/kain-by-tipe') }}/" + jenis,
                    data: {
                        tipe_name: tipe
                    },
                    dataType: "json",
                    success: function(response) {
                        $.each(response.datas, function(i, item) {
                            option +=
                                `<option value="${item.kategori_warna_id}">${item.kategoriwarna.nama}</option>`;
                        });
                        $('#kategori_warna').html(option);

                    }
                });
            });

            $('#kategori_warna').on('change', function() {
                let jenis = $("#jenis_kain").val();
                let tipe = $("#tipe_kain").val();
                let kategori_warna = $(this).val();
                $('#barang-list').prop('hidden', false);
                $('#table-barang tbody').empty();
                $.ajax({
                    type: "GET",
                    url: "{{ url('/warna-by-tipe') }}/" + jenis,
                    data: {
                        tipe_name: tipe,
                        kategori_warna: kategori_warna,
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log(response.satuan);
                        let row = "";
                        let optvalue = "";
                        let optwarnav = "";
                        // let asc = response.acesoris.id ?? 0;
                        // let bagian_asc = response.acesoris.bagian ?? "accessories";
                        let asc = 0;
                        let bagian_asc = "accessories";

                        $.each(response.satuan, function(i2, item2) {
                            optvalue +=
                                `<option value="${item2.satuan.keterangan}">${item2.satuan.keterangan}</option>`;
                        });

                        $.each(response.datas, function(i, item) {
                            row += `<tr>
                                            <td>${item.nama}</td>
                                            <td>${item.lebar.keterangan} / ${item.gramasi.nama}</td>
                                            <td>
                                                <input type="hidden" readonly value="${item.warna.id}" id="warnaid-${i}"  class="uk-input uk-form-width-small" >
                                                <input type="text" readonly value="${item.warna.nama}" id="warna-${i}"  class="uk-input uk-form-width-medium" >
                                            </td>
                                            <td>
                                                <select class="uk-input uk-form-width-small" id="satuans-${i}">
                                                    <option value="ROLL">ROLL</option>
                                                    ${optvalue}
                                                </select>
                                            </td>
                                            <td><input type="number" id="qty-${i}" class="uk-input" placeholder="Qty" min="1" value="1">
                                                <input type="hidden" name="id_assesoris" value="${asc}" id="id_assesoris-${i}"  class="uk-input uk-form-width-small" >
                                                <input type="hidden" readonly value="KG" name="satuan_accesories" id="satuan_accesories" class="uk-input uk-form-width-small">
                                            </td>
                                            <td><a onclick="storeKeranjang(${item.id},${i})"><span uk-icon="cart"></span></a></td>
                                            <td><a onclick="storeWhiteList(${item.id},${i})"><span uk-icon="heart"></span></a></td>
                                    </tr>`;
                        });
                        $('#table-barang tbody').html(row);
                    }

                })


            });

            function getWarnaId(cat_warna, index) {
                // alert(cat_warna);
                $.ajax({
                    type: "POST",
                    url: "{{ url('/warna-by-tipe') }}",
                    data: {
                        id_warna: cat_warna,
                    },
                    dataType: "json",
                    success: function(response) {
                        let optwarnav = "";
                        $.each(response.callback, function(i3, item3) {
                            optwarnav += `<option value="${item3.id}">${item3.nama}</option>`;
                        });
                        $('#warna-' + index).html(optwarnav);
                    }
                });
            }

            function changeGambar(tipe) {
                let jenis = $("#jenis_kain").val();
                $.ajax({
                    type: "GET",
                    url: "{{ url('/gambar-by-tipe') }}/" + jenis,
                    data: {
                        tipe_name: tipe
                    },
                    dataType: "json",
                    success: function(response) {
                        var gambar = response.datas.gambar;
                        document.getElementById("imgid").src = gambar;
                        // console.log(gambar)
                    }
                });
            }

            function storeWhiteList(tipeId, index) {
                $.ajax({
                    type: "POST",
                    url: "{{ url('/whitelist-store') }}/" + tipeId,
                    data: {
                        qty: $('#qty-' + index).val()
                    },
                    dataType: "json",
                    success: function(response) {
                        // notif('success', 'Barang ditambahkan ke whitelist.');
                        console.log(response)

                        listWhiteList();
                    }
                });
            }

            function storeKeranjang(tipeId, index) {
                $.ajax({
                    type: "POST",
                    url: "{{ url('/keranjang-store') }}/" + tipeId,
                    data: {
                        id_assesoris: $('#id_assesoris-' + index).val(),
                        warna: $('#warnaid-' + index).val(),
                        satuans: $('#satuans-' + index).val(),
                        qty: $('#qty-' + index).val(),
                    },
                    dataType: "json",
                    success: function(response) {
                        notif('success', 'Barang ditambahkan ke keranjang.');

                        listKeranjang();
                        UIkit.modal('#modalWhiteList').hide();
                    }
                });
            }

            function listWhiteList() {
                $('#table-whitelist tbody').empty();
                $.ajax({
                    type: "GET",
                    url: "{{ url('/whitelist') }}",
                    data: {},
                    dataType: "json",
                    success: function(response) {
                        let row = "";
                        $.each(response.datas, function(i, item) {
                            row += `<tr>
                                <td>${item.tipe_kain.nama}</td>
                                <td>${item.tipe_kain.lebar.keterangan} /${item.tipe_kain.gramasi.nama}</td>
                                <td>${item.tipe_kain.warna.nama}</td>
                                <td>${item.tipe_kain.satuan.keterangan}</td>
                                <td><input type="number" id="qty-${i}" class="uk-input" placeholder="Qty" min="1" value="1">
                                </td>
                                <td><a onclick="deleteWhitelist(${item.id})"><span uk-icon="trash"></span></a></td>
                                <td><a onclick="storeKeranjang(${item.tipe_kain_id},${i})"><span uk-icon="cart"></span></a></td>
                            </tr>`;
                        });
                        $('#table-whitelist tbody').html(row);
                        $('#label_whitelist_count').text(response.datas.length)
                    }
                });
            }

            function listKeranjang() {
                $('#table-keranjang tbody').empty();
                $.ajax({
                    type: "GET",
                    url: "{{ url('/keranjang') }}",
                    data: {},
                    dataType: "json",
                    success: function(response) {
                        let row = "";
                        $.each(response.datas, function(i, item) {
                            row += `<tr>
                                <td>${item.tipe_kain.nama}</td>
                                <td>${item.tipe_kain.lebar.keterangan} /${item.tipe_kain.gramasi.nama}</td>
                                <td>${item.tipe_kain.warna.nama}</td>
                                <td>${item.satuan}</td>
                                <td>${item.qty}</td>
                                <td><a onclick="deleteKeranjang(${item.id})"><span uk-icon="trash"></span></a></td>
                            </tr>`;
                        });
                        $('#table-keranjang tbody').html(row);
                        $('#label_keranjang_count').text(response.datas.length)
                        $('#label_keranjang_count_nav').text(response.datas.length)
                    }
                });
            }

            function deleteWhitelist(id) {
                $.ajax({
                    type: "POST",
                    url: "{{ url('/whitelist-destroy') }}/" + id,
                    data: {
                        _method: 'DELETE'
                    },
                    dataType: "json",
                    success: function(response) {
                        notif('success', 'Barang dihapus dari whitelist.');
                        listWhiteList();

                        UIkit.modal('#modalWhiteList').hide();
                    }
                });
            }

            function deleteKeranjang(id) {
                $.ajax({
                    type: "POST",
                    url: "{{ url('/keranjang-destroy') }}/" + id,
                    data: {
                        _method: 'DELETE'
                    },
                    dataType: "json",
                    success: function(response) {
                        notif('success', 'Barang dihapus dari keranjang.');
                        listKeranjang();

                        UIkit.modal('#modalCart').hide();
                    }
                });
            }

            function keranjangSubmit() {
                $("#button-submit").prop("disabled", true);
                $("#loading-submit").prop("hidden", false);
                $.ajax({
                    type: "POST",
                    url: "{{ url('/pesanan') }}",
                    data: {
                        // id_assesoris        : $('#id_assesoris').val(),
                        satuan_accesories: $('#satuan_accesories').val(),
                        // target_pesanan: $('#target_pesanan').val()
                    },
                    dataType: "json",
                    cache: false,
                    timeout: 800000,
                    success: function(response) {
                        if (response.count_keranjang < 1) { // Handle jika user klik lanjutkan kerangjang kosong
                            $('#submit-message').text(response.message)
                            let link = `<a href="pesanan" class="uk-button uk-button-primary">OK</a>`;
                            link = `<a class="uk-button uk-button-primary uk-modal-close">OK</a>`;
                            $('#link-modalSubmitOrder').html(link)
                            UIkit.modal('#modalSubmitOrder').show();
                        } else {
                            window.location.replace(response.redirectUrl);
                        }

                        $("#button-submit").prop("disabled", false);
                        $("#loading-submit").prop("hidden", true);
                    },
                    error: function(response) {
                        $.each(response.responseJSON.errors, function(key, value) {
                            notif("error", value);
                        });
                        if (response.status == 400) {
                            notif("error", response.responseJSON.message);
                        }
                        if (response.status == 500) {
                            notif("error", "Server error!.");
                        }
                        $("#button-submit").prop("disabled", false);
                        $("#loading-submit").prop("hidden", true);
                    }
                });
            }
        </script>
    @endpush
</x-app-layout>
