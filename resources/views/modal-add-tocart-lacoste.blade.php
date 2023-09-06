<div id="modalAddToCartLacoste" uk-modal>
    <div class="uk-modal-dialog">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h4 id="judulmodal-fo-lacoste"></h4>
            <dl>
                <dt><span id="judullebar-fo-lacoste"></span> / <span id="judulgramasi-fo-lacoste"></span></dt>
                <dd><span id="judulwarna-fo-lacoste"></span></dd>
            </dl>
        </div>
        <div class="uk-modal-body" uk-overflow-auto>
            <div class="uk-child-width-1-2@s" uk-grid>
                <div>
                    <div class="uk-margin">
                        <strong>Body</strong>
                        <form class="uk-grid-small" uk-grid>
                            <div class="uk-width-1-2">
                                <select id="satuan-body-lacoste" class="uk-select uk-form-small" required></select>
                            </div>
                            <div class="uk-width-1-2">
                                <input type="number" step="0.1" id="qty-body-lacoste"
                                    class="uk-input uk-form-small" min="0" value="0"
                                    placeholder="Masukkan qty" required>
                                <input type="hidden" id="id-product-lacoste">
                                <input type="hidden" id="harga-product-lacoste">
                                <input type="hidden" id="qty-roll-lacoste">
                                <input type="hidden" id="bagian-lacoste">
                                <input type="hidden" id="warna_id-lacoste">
                                <input type="hidden" id="satuan-db-lacoste">
                                <input type="hidden" id="paket-lacoste">
                            </div>
                        </form>
                    </div>
                    <div class="uk-margin" id="jenis-kain-lacoste">
                        <div class="uk-grid-small" uk-grid id="acc-lacoste"></div>
                        <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                            <label class="uk-text-muted">
                                <input class="uk-checkbox uk-text-small" id="use-max-acs-lacoste" type="checkbox">
                                Gunakan maksmial Aksesoris dari Body
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
                            <td class="uk-text-right" id="total-qty-body-lacoste">0 KG</td>
                            <td class="uk-text-right" id="total-body-lacoste">Rp.0</td>
                            <input type="hidden" id="tot-harga-body-lacoste">
                        </tr>
                        <tr>
                            <th colspan="3">Total Aksesoris</th>
                        </tr>
                        <tbody id="tbody-acc">
                            <tr>
                                <td>Kerah</td>
                                <td class="uk-text-right uk-text-small" id="total-qty-asc-lacoste-kerah">0 KG</td>
                                <td class="uk-text-right" id="total-harga-asc-lacoste-kerah">Rp.0</td>
                            </tr>
                            <tr>
                                <td>Manset</td>
                                <td class="uk-text-right" id="total-qty-asc-lacoste-manset">0 KG</td>
                                <td class="uk-text-right" id="total-harga-asc-lacoste-manset">Rp 0</td>
                            </tr>
                        </tbody>

                        <tr>
                            <th colspan="2">Total Bayar <span uk-icon="icon: info; ratio: 0.75"
                                    uk-tooltip="Harga yang tertera masih bersifat estimasi, harga dan berat yang sudah fixed akan diinformasikan pada halaman konfirmasi pesanan"></span>
                            </th>
                            <td class="uk-text-right uk-text-bold" id="total-bayar-lacoste"></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="uk-modal-footer uk-text-right">
            <button class="uk-button uk-button-default uk-modal-close" type="button">Batal</button>
            <button type="button" onclick="storeToCarLacoste()" class="uk-button uk-button-primary"
                id="storeToCartButtonLacoste">
                Tambah
            </button>
        </div>

    </div>
</div>
@push('script')
    <script>
        function countingPrice(qty, satuan, price, actQty, satuanDB) {
            let total = 0;
            let stn = "ROLL";
            if (satuan == "ROLL") {
                total = (qty * actQty) * price;
            } else {
                total = qty * price;
                stn = satuanDB;
            }
            $('#tot-harga-body-lacoste').val(total);
            $('#total-qty-body-lacoste').text(qty + ' ' + stn);
            $('#total-body-lacoste').text('Rp.' + total.toLocaleString())
            grandTotalCartLacoste();
        }
    </script>
@endpush
