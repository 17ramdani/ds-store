<x-app-layout>
    <section class="uk-margin-medium">
        <div class="uk-container">
            <div class="rz-panel">
               <h3>Sales Order - Draft</h3>
                <div class="uk-child-width-1-2@s uk-grid-large" uk-grid>
                    <div>
                        <table class="rz-table-vertical">
                          <tr>
                            <th>No. Invoice</th>
                            <td class="uk-table-shrink">:</td>
                            <td>INV.123456789</td>
                          </tr>
                          <tr>
                            <th>Customer</th>
                            <td class="uk-table-shrink">:</td>
                            <td>Ahmad</td>
                          </tr>
                          <tr>
                            <th>Sales</th>
                            <td class="uk-table-shrink">:</td>
                            <td>Syarif</td>
                          </tr>
                          <tr>
                            <th>Catatan Pembayaran</th>
                            <td>:</td>
                            <td>Transfer BCA</td>
                          </tr>
                        </table>
                    </div>
                    <div>
                        <table class="rz-table-vertical">
                          <tr>
                            <th>Jatuh Tempo</th>
                            <td class="uk-table-shrink">:</td>
                            <td>Feb 25, 2023</td>
                          </tr>
                          <tr>
                            <th>Status</th>
                            <td class="uk-table-shrink">:</td>
                            <td>Tunggu Pembayaran
                            </td>
                          </tr>
    
                        </table>
                    </div>
    
    
                </div>
                <div class="uk-overflow-auto uk-margin-medium-top">
                   <h4>Detail Barang</h4>
                    <table class="uk-table uk-table-small uk-table-striped">
                    <thead>
                      <tr>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Grm</th>
                        <th>Lbr</th>
                        <th>Warna</th>
                        <th>Qty Est.</th>
    
                        <th>Stn</th>
                        <th>Harga</th>
                        <th>Total</th>
                      </tr>
                    </thead>
                    <tbody class="uk-text-small">
                      <tr>
                        <td>ABC</td>
                        <td>SK.CARDED 24'S</td>
                        <td>42" /150-160</td>
                        <td>10</td>
                        <td>PUTIH</td>
                        <td>10</td>
    
                        <td>Roll
                        </td>
                        <td>2,000,000</td>
                        <td class="uk-text-right">20,000,000</td>
                      </tr>
    
                    </tbody>
                    <tfoot>
                        <tr><td colspan="7"></td>
                            <td>Total</td>
                            <td class="uk-text-right">22,200,000</td>
                        </tr>
                        <tr><td colspan="7"></td>
                            <td>DP</td>
                            <td class="uk-text-right">500,000</td>
                        </tr>
                        <tr><td colspan="7"></td>
                            <td>Grand Total</td>
                            <td class="uk-text-right">21,700,000</td>
                        </tr>
                    </tfoot>
                    </table>                        
                </div>
                
                <div class="uk-margin-medium uk-width-1-2@m">
                    <label class="uk-form-label">Jenis Pesanan:</label>
                    <div class="uk-form-controls">
                        Khusus
                    </div>
                    <div id="pesanan2" class="uk-margin">
                        <div class="uk-margin-medium-top">
                            <canvas id="sig-canvas" width="620" height="160">
                                Please get a better browser.
                            </canvas>
                            <a href="{{ route('pesanan.checkout') }}" class="uk-button uk-border-rounded uk-button-primary uk-margin-top">Approve Draft</a>
                        </div>
                    </div>             
                </div>
            </div>
        </div>
    </section>
</x-app-layout>