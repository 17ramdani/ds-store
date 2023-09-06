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