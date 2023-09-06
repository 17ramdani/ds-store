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
                    <h3>Form Accesories</h3>
                </div>

                <div>
                    {{-- <form class="uk-form-stacked uk-position-relative" id="form_accesories"> --}}
                    <div class="uk-margin" id="barang-list">
                        <div id="kain1" class="uk-margin">

                            <table class="uk-table uk-table-small uk-table-responsive uk-table-striped"
                                id="table-barang">
                                <thead>
                                    <tr>
                                        <th colspan="6">
                                            <h3 style="font-size: 18px !important">Data Pesanan</h3>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Barang</th>
                                        <th>L/GSM</th>
                                        <th>Kategori Watna</th>
                                        <th>Warna</th>
                                        <th>Satuan</th>
                                        <th>Qty</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pesanan as $p)
                                        @if ($p['satuan'] == 'ROLL')
                                            @for ($i = 0; $i < $p['qty']; $i++)
                                                <tr>
                                                    <td>{{ $p['tipe_kain']['nama'] }}</td>
                                                    <td>{{ $p['tipe_kain']['gramasi']['nama'] }}</td>
                                                    <td>{{ $p['tipe_kain']['warna']['nama'] }}</td>
                                                    <td>{{ $p['warna_pesanan']['nama'] }}</td>
                                                    <td>{{ $p['satuan'] }}</td>
                                                    <td>{{ $p['qty'] / $p['qty'] }}</td>
                                                </tr>
                                            @endfor
                                        @else
                                            <tr>
                                                <td>{{ $p['tipe_kain']['nama'] }}</td>
                                                <td>{{ $p['tipe_kain']['gramasi']['nama'] }}</td>
                                                <td>{{ $p['tipe_kain']['warna']['nama'] }}</td>
                                                <td>{{ $p['warna_pesanan']['nama'] }}</td>
                                                <td>{{ $p['satuan'] }}</td>
                                                <td>{{ $p['qty'] }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>

                            <table class="uk-table uk-table-small uk-table-responsive uk-table-striped"
                                id="table-barang">
                                <thead>
                                    <tr>
                                        <th colspan="6">
                                            <h3 style="font-size: 18px !important">Accesories</h3>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Barang</th>
                                        <th>L/GSM</th>
                                        <th>Kategori Watna</th>
                                        <th>Warna</th>
                                        <th>Satuan</th>
                                        <th>Qty</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @if ($asssc)
                                        @foreach ($pesanan as $asc)
                                            <tr>
                                                {{-- <td>{{ $asc['accesories']['nama'] }}</td>
                                                <td>{{ $asc['accesories']['gramasi']['nama'] }}</td>
                                                <td>{{ $asc['accesories']['warna']['nama'] }}</td> --}}
                                                <td>
                                                    <select name="id_asc[]" id="id_asc-{{ $asc['id'] }}"
                                                        class="uk-select" required>
                                                        <option value="">-pilih-</option>
                                                        @foreach ($asssc as $ascs)
                                                            <option value="{{ $ascs->id_asc }}">{{ $ascs->nama_kain }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <div id="gramasc"></div>
                                                </td>
                                                <td>
                                                    <div id="kat_warnaasc"></div>
                                                </td>
                                                <td>{{ $asc['warna_pesanan']['nama'] }}</td>
                                                <td>
                                                    {{-- <input type="text" value="KG" class="uk-input" name="satuan_asc" readonly> --}}
                                                    <select name="satuan_asc" id="satuan_asc" class="uk-select"
                                                        required>
                                                        <option value="">-pilih-</option>
                                                        <option value="KG">ECER</option>
                                                        <option value="ROLL">ROLL</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" id="qty-{{ $asc['id'] }}" class="uk-input"
                                                        placeholder="Qty" step="0.01" min="0" value="0">
                                                    <input type="hidden" id="id_keran-{{ $asc['id'] }}"
                                                        value="{{ $asc['id'] }}" class="uk-input">
                                                    <input type="hidden" id="vid_asc-{{ $asc['id'] }}"
                                                        class="uk-input">
                                                </td>
                                                <td><a onclick="storeAccesories({{ $asc['id'] }})"><span
                                                            uk-icon="cart"></span></a></td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>

                            <div class="uk-child-width-expand@s" uk-grid>
                                <div>
                                    <table class="uk-table uk-table-hover uk-table-divider uk-width-1-3">
                                        <thead>
                                            <tr>
                                                <th colspan="6">
                                                    <h3 style="font-size: 18px !important"> Keterangan Accesories</h3>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th class="uk-text">Jenis</th>
                                                <th class="uk-text">Body(kg)</th>
                                                <th class="uk-text"> % Aksesories</th>
                                                <th class="uk-text">Acc (Kg)</th>
                                                <th class="uk-text">PCS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="uk-text">Kerah</td>
                                                <td class="uk-text">25.00</td>
                                                <td class="uk-text">13.2%</td>
                                                <td class="uk-text">3.30</td>
                                                <td class="uk-text">110</td>
                                            </tr>
                                            <tr>
                                                <td class="uk-text">Manset</td>
                                                <td class="uk-text">25.00</td>
                                                <td class="uk-text">8.8%</td>
                                                <td class="uk-text">2.20</td>
                                                <td class="uk-text">110</td>
                                            </tr>
                                            <tr>
                                                <td class="uk-text">Rib</td>
                                                <td class="uk-text">25.00</td>
                                                <td class="uk-text">5.0%</td>
                                                <td class="uk-text">1.25</td>
                                                <td class="uk-text">-</td>
                                            </tr>
                                            <tr>
                                                <td class="uk-text">Bur</td>
                                                <td class="uk-text">25.00</td>
                                                <td class="uk-text">20.0%</td>
                                                <td class="uk-text">5.0</td>
                                                <td class="uk-text">-</td>
                                            </tr>
                                            <tr>
                                                <td class="uk-text">Kerah</td>
                                                <td class="uk-text">1.00</td>
                                                <td class="uk-text">13.2%</td>
                                                <td class="uk-text">0.13</td>
                                                <td class="uk-text">4</td>
                                            </tr>
                                            <tr>
                                                <td class="uk-text">Manset</td>
                                                <td class="uk-text">1.00</td>
                                                <td class="uk-text">8.8%</td>
                                                <td class="uk-text">0.09</td>
                                                <td class="uk-text">4</td>
                                            </tr>
                                            <tr>
                                                <td class="uk-text">Rib</td>
                                                <td class="uk-text">1.00</td>
                                                <td class="uk-text">5.0%</td>
                                                <td class="uk-text">0.05</td>
                                                <td class="uk-text">-</td>
                                            </tr>
                                            <tr>
                                                <td class="uk-text">Bur</td>
                                                <td class="uk-text">1.00</td>
                                                <td class="uk-text">20.0%</td>
                                                <td class="uk-text">0.20</td>
                                                <td class="uk-text">-</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="uk-margin">
                                        <p><strong>Catatan:</strong></p>
                                        <ul>
                                            <li>Kerah dan Manset untuk Bahan Lacoste</li>
                                            <li>Rib untuk Bahan Kaos (Combed/Carded)</li>
                                            <li>Bur untuk Bahan Sweater (Babyterry/Fleece)</li>
                                        </ul>
                                    </div>
                                </div>
                                <div>
                                    <div class="uk-margin">
                                        <label class="uk-form-label">Target Kebutuhan</label>
                                        <div class="uk-form-controls">
                                            <div class="uk-margin">
                                                <input class="uk-input uk-form-width-large" name="target_pesanan"
                                                    id="target_pesanan" type="date" placeholder=""
                                                    aria-label="Large">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="uk-margin-medium-top uk-child-width-1-2@s" uk-grid>
                                        <div>
                                            <button type="button" id="button-submit" onclick="keranjangSubmit()"
                                                class="uk-button uk-border-rounded uk-button-primary uk-margin-small-right">
                                                <span id="loading-submit" uk-spinner="ratio: 0.6" hidden></span>Submit
                                            </button>


                                            {{-- <a href="#modalCart" class="uk-visible@m uk-button uk-button-default uk-border-rounded"
                                                    uk-toggle><span class="uk-margin-small-right" uk-icon="cart"></span>
                                                    <small id="label_keranjang_count" class="uk-badge">0</small>
                                                </a> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>




                        </div>
                    </div>

                    {{-- </form> --}}
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
    @include('pesanan.inc.modal-chart')
    @include('whitelist.inc.modal-whitelist')
    @push('script')
        <script>
            $('select[name="id_asc[]"]').on('change', function() {
                let id_asc = $(this).val();
                let target_id = $(this).attr('id').split('-')[1];
                let gramasc_td = $(this).closest('tr').find('div#gramasc');
                let kat_warna_td = $(this).closest('tr').find('div#kat_warnaasc');
                $.ajax({
                    url: "{{ url('/get_asc_detail/') }}" + "/" + id_asc,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        let gram = response.callback.nama_gram;
                        let warna = response.callback.nama_warna;
                        gramasc_td.html(gram);
                        kat_warna_td.html(gram);
                        // $('#gramasc-' + target_id).html(gram);
                        // $('#kat_warnaasc-' + target_id).html(gram);
                        $('#vid_asc-' + target_id).val(response.callback.id_asc);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });

                // let option = "<option value='0'>-pilih-</option>";
                // $.ajax({
                //     type: "GET",
                //     url: "{{ url('/kain-by-jenis') }}/" + jenis,
                //     data: {},
                //     dataType: "json",
                //     success: function(response) {
                //         $.each(response.datas, function(i, item) {
                //             option += `<option value="${item.nama}">${item.nama}</option>`;

                //         });
                //         $('#tipe_kain').html(option);
                //     }
                // });
            });

            function storeAccesories(id) {
                // alert($('#vid_asc-' + id).val())
                $.ajax({
                    type: "POST",
                    url: "{{ url('/store-asc') }}",
                    data: {
                        id_asc: $('#vid_asc-' + id).val(),
                        qty: $('#qty-' + id).val(),
                        idkeran: $('#id_keran-' + id).val(),
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 1) {
                            notif('success', response.pesan);
                        } else {
                            notif('warning', response.pesan);
                        }
                        console.log(response)
                    }
                });
            }

            function keranjangSubmit() {
                $("#button-submit").prop("disabled", true);
                $("#loading-submit").prop("hidden", false);

                $.ajax({
                    type: "POST",
                    url: "{{ url('/accesories') }}",
                    data: {
                        satuan_asc: $('#satuan_asc').val(),
                        target_pesanan: $('#target_pesanan').val(),
                    },
                    dataType: "json",
                    cache: false,
                    timeout: 800000,
                    success: function(response) {
                        $('#submit-message').text(response.message)
                        let link = `<a href="pesanan" class="uk-button uk-button-primary">OK</a>`;
                        link = `<a class="uk-button uk-button-primary uk-modal-close">OK</a>`;
                        $('#link-modalSubmitOrder').html(link)
                        UIkit.modal('#modalSubmitOrder').show();
                        // window.location.replace(response.redirectUrl);
                        $("#button-submit").prop("disabled", false);
                        $("#loading-submit").prop("hidden", true);
                        // console.log(response)
                        $(document).on('click', '#link-modalSubmitOrder a', function() {
                            window.location.replace("/pesanan");
                        });
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
