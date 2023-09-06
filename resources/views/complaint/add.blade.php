<x-app-layout>

    <section id="navbarSecondary" class="uk-flex uk-flex-middle uk-flex-left">
        <div class="uk-width-1-1">
            <div class="uk-container">
                <h2 class="rz-text-pagetitle">Keluhan</h2>
            </div>
        </div>
    </section>

    <section class="uk-margin-medium">
        <div class="uk-container">
            <div class="rz-panel">

                <form class="uk-form-horizontal">
                    <div class="uk-margin-large">
                        <label class="uk-form-label">Status Pesanan</label>
                        <div class="uk-form-controls">
                            <select class="uk-select">
                                <option>Tunggu Konfirmasi</option>
                                <option>Tunggu Pembayaran</option>
                                <option>Pesanan Diproses</option>
                                <option>Pesanan Diantar</option>
                                <option>Pesanan Selesai</option>
                            </select>
                        </div>
                    </div>
                </form>

                <div class="uk-overflow-auto uk-margin">
                    <table class="uk-table uk-table-small uk-table-divider">
                        <thead>
                            <tr>
                                <th>No Pesanan</th>
                                <th>Tanggal</th>
                                <th>Status Pesanan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pesanan as $pes)
                                <tr>
                                    <td>{{ $pes['nomor'] }}</td>
                                    <td>{{ $pes['tanggal_pesanan'] }}</td>
                                    <td>{{ $pes['status']['keterangan'] }}</td>
                                    <td><a href="/add-detail/{{ $pes['id'] }}"><span class="uk-margin-small-right"
                                                uk-icon="icon: plus-circle; ratio:0.75"></span>Keluhan</a></td>
                                </tr>
                            @endforeach
                            {{-- <tr>
                                <td>SO0123456</td>
                                <td>15-Feb-23</td>
                                <td>Tunggu Konfirmasi</td>
                                <td><a href="{{ route('add.detail') }}"><span class="uk-margin-small-right"
                                            uk-icon="icon: plus-circle; ratio:0.75"></span>Keluhan</a></td>
                            </tr>
                            <tr>
                                <td>SO0789456</td>
                                <td>25-Feb-23</td>
                                <td>Pesanan Diproses</td>
                                <td><a href="complaint-add-detail.php"><span class="uk-margin-small-right"
                                            uk-icon="icon: plus-circle; ratio:0.75"></span>Keluhan</a></td>
                            </tr> --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
