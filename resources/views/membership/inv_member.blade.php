<x-app-layout>
    <section id="navbarSecondary" class="uk-flex uk-flex-middle uk-flex-left">
        <div class="uk-width-1-1">
            <div class="uk-container">
                <h2 class="rz-text-pagetitle">Membership Invoice</h2>
            </div>
        </div>

    </section>


    <section class="uk-margin-medium">
        <div class="uk-container">
            <div class="rz-panel">
                <!-- <h3>Form Pendaftaran Member</h3> -->

                @if (session()->has('success'))
                    <div class="uk-alert-success" uk-alert>
                        <a class="uk-alert-close" uk-close></a>
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                <div class="rz-panel">
                    <h4>Detail Invoince</h4>
                    <div class="uk-child-width-1-2@s" uk-grid>
                        <div>
                            <table class="rz-table-vertical uk-margin-large">
                                <tbody>
                                    <tr>
                                        <th>Nama Lengkap</th>
                                        <td>{{ $member[0]->customer->nama }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            @if ($member[0]->status_bayar == 1)
                                                <span style="color:green;">Lunas</span>
                                            @else
                                                <span style="color:red;">Prosess Pembayaran</span>
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Tanggal Bergabung</th>
                                        <td>{{ date('d, F Y H:i:s', strtotime($member[0]->join_at)) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Berkahir</th>
                                        <td>
                                            @if ($member[0]->expired_at != null)
                                                {{ date('d, F Y H:i:s', strtotime($member[0]->expired_at)) }}
                                            @else
                                                <span style="color:red">Belum di Approve</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>No Rekening</th>
                                        <td>08123456789</td>
                                    </tr>
                                    <tr>
                                        <th>An.Rekening</th>
                                        <td>Nama Rekening</td>
                                    </tr>
                                    <tr>
                                        <th>Total Bayar</th>
                                        <td>
                                            @if ($member[0]->customer_category_id == 1)
                                                FREE
                                            @elseif($member[0]->customer_category_id == 2)
                                                Rp. 10.000.000
                                            @elseif($member[0]->customer_category_id == 3)
                                                Rp. 12.000.000
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        {{-- <div>
                            <table class="rz-table-vertical uk-margin-large">
                                <caption class="uk-text-left">
                                    <h5>Data Perusahaan</h5>
                                </caption>
                                <tbody>
                                    <tr>
                                        <th>Nama Perusahaan</th>
                                        <td>Budi Clothing</td>
                                    </tr>
                                    <tr>
                                        <th>Alamat Perusahaan</th>
                                        <td>Jalan Raya no 31</td>
                                    </tr>
                                    <tr>
                                        <th>No. Telp</th>
                                        <td>022-123456789</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>budi@gmail.com</td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Usaha</th>
                                        <td>Pakaian jadi</td>
                                    </tr>
                                    <tr>
                                        <th>Lama Berdiri Perusahaan</th>
                                        <td>3 tahun</td>
                                    </tr>
                                    <tr>
                                        <th>Omset per Tahun</th>
                                        <td>Rp. 823,000,000</td>
                                    </tr>
                                    <tr>
                                        <th>Kebutuhan Nominal</th>
                                        <td>Rp. 100,000,000</td>
                                    </tr>
                                    <tr>
                                        <th>Referensi dari</th>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <th>Kategori Member</th>
                                        <td>MEMBER</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div> --}}
                    </div>
                </div>

            </div>
        </div>
    </section>


</x-app-layout>
