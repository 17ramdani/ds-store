<x-app-layout>
    <section class="uk-margin-medium">
        <div class="uk-container">
            <div class="rz-panel">
                <h4>Sales Order Draft</h4>
                <div class="uk-overflow-auto uk-margin">
                    <table class="uk-table uk-table-small uk-table-divider">
                        <thead>
                              <tr>
                                <th>NO</th>
                                <th>TANGGAL PESAN</th>
                                <th>NAMA BARANG</th>
                                <th>L/GSM</th>
                                <th>QTY</th>
                                <th>HARGA</th>
    
                                <th>ACTION</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>1</td>
                                <td>6-Feb-23</td>
                                <td>SK.CARDED 24'S</td>
                                <td>42" /170-180 &amp; 42"/180-190</td>
                                <td>25.8</td>
                                <td>Rp.2,523,498.00</td>
    
                                <td><a href="{{ route('so.draft') }}">Detail</a></td>
                              </tr>
    
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>