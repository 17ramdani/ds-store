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
                    {{-- <div class="uk-margin">
                        <div class="uk-width-1-2">
                            <strong>KG</strong><br>
                            <input type="number" step="0.1" class="uk-input uk-form-small" placeholder="Masukan Qty" onkeyup="updateSatuan('ecer')">
                            <input type="text" id="satuan-ecer" value="ECER" class="uk-input uk-form-small" placeholder="satuan_db">
                        </div>
                        <div class="uk-width-1-2">
                            <strong>ROLL</strong><br>
                            <input type="number" step="0.1" class="uk-input uk-form-small" placeholder="Masukan Qty" onkeyup="updateSatuan('roll')">
                            <input type="text" id="satuan-roll" value="ROLL" class="uk-input uk-form-small" placeholder="satuan_db">
                        </div>                        
                        <input type="hidden" id="id-product" class="uk-input uk-form-small" placeholder="Id product">
                        <input type="hidden" id="harga-product" class="uk-input uk-form-small" placeholder="Harga product">
                        <input type="hidden" id="harga-accessories" class="uk-input uk-form-small" placeholder="Harga Accessories">
                        <input type="hidden" id="qty-roll" class="uk-input uk-form-small" placeholder="qty-roll">
                        <input type="hidden" id="bagian" class="uk-input uk-form-small" placeholder="bagian">
                        <input type="hidden" id="warna_id" class="uk-input uk-form-small" placeholder="warna_id">
                    </div> --}}
                    <div class="uk-margin">
                        <strong>Body</strong>
                        <form class="uk-grid-small" uk-grid>
                            <div class="uk-width-1-2">
                                <select id="satuan-body" class="uk-select uk-form-small" required></select>
                            </div>
                            <div class="uk-width-1-2">
                                <input type="hidden" id="id-product" class="uk-input uk-form-small" placeholder="Id product">
                                <input type="hidden" id="harga-product" class="uk-input uk-form-small" placeholder="Harga product">
                                <input type="number" step="0.1" id="qty-body" class="uk-input uk-form-small" placeholder="Masukkan qty" required>
                                <input type="hidden" id="harga-accessories" class="uk-input uk-form-small" placeholder="Harga Accessories">
                                <input type="hidden" id="qty-roll" class="uk-input uk-form-small" placeholder="qty-roll">
                                <input type="hidden" id="bagian" class="uk-input uk-form-small" placeholder="bagian">
                                <input type="hidden" id="warna_id" class="uk-input uk-form-small" placeholder="warna_id">
                                <input type="hidden" id="satuan-db" class="uk-input uk-form-small" placeholder="satuan_db">

                                <input type="hidden" id="paket" class="uk-input uk-form-small" placeholder="Paket">

                            </div>
                        </form>
                    </div>
                    <div class="uk-margin accessories" id="jenis-kain-nolacoste">
                        <strong>Aksesoris</strong>
                        <form class="uk-grid-small" uk-grid>
                            <div class="uk-width-1-2">
                                <select id="id-accessories" class="uk-select uk-form-small" required></select>
                            </div>
                            <div class="uk-width-1-2">
                                <input type="number" step="0.1" id="qty-accessories" class="uk-input uk-form-small" placeholder="Masukkan qty">
                            </div>
                        </form>
                        <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                            <label class="uk-text-muted">
                                <input class="uk-checkbox uk-text-small" id="use-max-acs" type="checkbox"> Gunakan maksmial Aksesoris dari Body
                            </label>
                        </div>
                        <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                            <span class="uk-text-meta">
                                <span class="uk-margin-small-right" uk-icon="icon: info; ratio: 0.75"></span>
                                <span id="info-asesoris"></span>
                            </span>
                        </div>
                    </div>
                    <div class="uk-margin" id="jenis-kain-lacoste">
                        <form class="uk-grid-small" uk-grid>
                            <div class="uk-width-1-2">
                                <strong>Kerah</strong><br>
                                <input type="number" id="qty-accessories" class="uk-input uk-form-small" placeholder="Pcs">
                                <input type="text" id="pcs_kerah" class="uk-select uk-form-small" required>

                                <input type="hidden" id="harga-accessories" class="uk-input uk-form-small" placeholder="Harga Accessories">

                                <input type="hidden" value="KER" class="uk-input uk-form-small" placeholder="">
                            </div>
                            <div class="uk-width-1-2">
                                <strong>Manset</strong><br>
                                <input type="number" id="qty-accessories" class="uk-input uk-form-small" placeholder="Pcs">
                                <input type="text" id="pcs_manset" class="uk-select uk-form-small" required>

                                <input type="hidden" id="harga-accessories" class="uk-input uk-form-small" placeholder="Harga Accessories">

                                <input type="hidden" value="MAN" class="uk-input uk-form-small" placeholder="">
                            </div>
                        </form>
                        <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                            <label class="uk-text-muted">

                                <input class="uk-checkbox uk-text-small" id="use-max-acs-kermen" type="checkbox"> Gunakan maksmial Aksesoris dari Body

                            </label>
                        </div>
                        <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                            <span class="uk-text-meta">
                                <span class="uk-margin-small-right" uk-icon="icon: info; ratio: 0.75"></span>
                                <span id="info-asesoris-lacoste"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div>
                    <table class="rz-table-vertical">
                        <tr>
                            <th>Total Body</th>
                            <td class="uk-text-right" id="total-qty-body"></td>
                            <td class="uk-text-right" id="total-body"></td>
                            <input type="hidden" id="tot-harga-body" class="uk-input uk-form-small">
                        </tr>
                        <tr>
                            <th>Total Aksesoris</th>
                            <td class="uk-text-right" id="total-qty-asc"></td>
                            <td class="uk-text-right" id="total-harga-asc"></td>
                            <input type="hidden" id="tot-harga-asc" class="uk-input uk-form-small">
                        </tr>
                        <tr>
                            <th>Total Bayar <span uk-icon="icon: info; ratio: 0.75" uk-tooltip="Harga yang tertera masih bersifat estimasi, harga dan berat yang sudah fixed akan diinformasikan pada halaman konfirmasi pesanan"></span></th>
                            <td></td>
                            <td class="uk-text-right uk-text-bold" id="total-bayar"></td>
                            <input type="hidden" id="total-bayar-value" class="uk-input uk-form-small">
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="uk-modal-footer uk-text-right">
            <button class="uk-button uk-button-default uk-modal-close" type="button">Batal</button>
            <button type="button" onclick="storeToCart()" class="uk-button uk-button-primary" id="storeToCartButton">
                Tambah
            </button>
        </div>

    </div>
</div>