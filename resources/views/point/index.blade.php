<x-app-layout>

    <section id="navbarSecondary" class="uk-flex uk-flex-middle uk-flex-left">
        <div class="uk-width-1-1">
            <div class="uk-container">
                <h2 class="rz-text-pagetitle">Point Reward</h2>
            </div>

        </div>

    </section>
    <section class="uk-margin-medium">
        <div class="uk-container">
            <div uk-grid>
                <div class="uk-width-1-3@s">
                    <div class="rz-panel">
                        <div>Point Anda</div>
                        <div class="uk-text-large">
                            @if ($point_cust->count() > 0)
                                {{ $total_point; }}
                            @else
                                Belum ada.
                            @endif
                        </div>
                        <div class="uk-margin-medium-top uk-flex uk-flex-between">
                            <a href="{{ route('tukar') }}"
                                class="uk-button uk-border-rounded uk-button-secondary uk-width-1-1 uk-button-small">Tukar
                                Point</a>
                            <a href=""
                                class="uk-button uk-border-rounded uk-button-default uk-width-1-1 uk-button-small">Lihat
                                Merchant</a>
                        </div>

                    </div>
                </div>
                <div class="uk-width-2-3@s">
                    <div class="rz-panel">
                        <div class="uk-margin-large">
                            <h5>Point History</h5>
                            <table class="uk-table uk-table-small uk-table-striped">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Total Transaksi </th>
                                        <th>Total Point</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($point_cust as $p)
                                        <tr>
                                            <td>{{ $p->point_date }}</td>
                                            <td>Rp. {{ number_format($p->transaction_total) }}</td>
                                            <td>{{ $p->point_amount }} pt</td>
                                        </tr>
                                    @endforeach
                                    {{-- <tr>
                                        <td>25-Jan-23</td>
                                        <td> 30,000,000 </td>
                                        <td>300 pt</td>
                                    </tr> --}}
                                </tbody>
                            </table>
                        </div>
                        <div class="uk-margin-large">
                            <h5>Point Redeem History</h5>
                            <table class="uk-table uk-table-small uk-table-striped">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Penukaran Point </th>
                                        <th>Point Ditukar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>2-Jan-23</td>
                                        <td> E-Voucher MAP </td>
                                        <td>250 pt</td>
                                    </tr>
                                    <tr>
                                        <td>25-Jan-23</td>
                                        <td> E-Voucher SOGO </td>
                                        <td>300 pt</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </section>

</x-app-layout>
