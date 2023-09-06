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
                @if (session()->has('success'))
                    <div class="uk-alert-success" uk-alert>
                        <a class="uk-alert-close" uk-close></a>
                        <p>{{ session('success') }}</p>
                    </div>
                @endif
                <div class="uk-margin uk-text-right"><a href="{{ route('complaint.add') }}"
                        class="uk-button uk-button-primary uk-border-rounded"><span class="uk-margin-small-right"
                            uk-icon="plus-circle"></span>Lapor Keluhan</a></div>
                <div class="uk-child-width-1-6@l uk-child-width-1-3 uk-grid-small uk-margin-medium" uk-grid>
                    <div>
                        <div class="rz-cell-alt">
                            <div class="rz-cell-value">{{ $total_pesanan }}</div>
                            <div class="rz-cell-label">Total Pesanan</div>
                        </div>
                    </div>
                    <div>
                        <div class="rz-cell-alt">
                            <div class="rz-cell-value">{{ $total_prosess }}</div>
                            <div class="rz-cell-label">Keluhan Diproses</div>
                        </div>
                    </div>
                    <div>
                        <div class="rz-cell-alt">
                            <div class="rz-cell-value">{{ $total_selesai }}</div>
                            <div class="rz-cell-label">Keluhan Selesai</div>
                        </div>
                    </div>

                </div>
                <div class="uk-overflow-auto uk-margin">
                    <table class="uk-table uk-table-small uk-table-divider">
                        <thead>
                            <tr>
                                <th>No Pesanan</th>
                                <th>Tanggal</th>
                                <th>Jenis Keluhan</th>
                                <th>Deskripsi Keluhan</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($complaint->count() > 0)
                                @foreach ($complaint as $c)
                                    <tr>
                                        <td>{{ $c->no_pesanan }}</td>
                                        <td>{{ date('d-F-Y', strtotime($c->tanggal)) }}</td>
                                        <td>
                                            @if ($c->jenis_keluhan == '1')
                                                {{ 'Kualitas Pesanan' }}
                                            @elseif($c->jenis_keluhan == '2')
                                                {{ 'Kuantitas Pesanan' }}
                                            @elseif($c->jenis_keluhan == '3')
                                                {{ 'Lainnya' }}
                                            @else
                                                {{ 'N/A' }}
                                            @endif
                                        </td>
                                        <td>{{ $c->desc_keluhan }}</td>
                                        <td>
                                            @if ($c->status == '1')
                                                {{ 'Open' }}
                                            @elseif($c->status == '2')
                                                {{ 'On Proses' }}
                                            @elseif($c->status == '3')
                                                {{ 'Done' }}
                                            @elseif($c->status == '4')
                                                {{ 'Closed' }}
                                            @else
                                                {{ 'N/A' }}
                                            @endif
                                        </td>
                                        <td>
                                            <a href="/detail-complaint/{{ $c->id }}">Detail</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                Tidak ada data komplain.
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
