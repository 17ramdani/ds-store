<x-app-layout>

    <section id="navbarSecondary" class="uk-flex uk-flex-middle uk-flex-left">
        <div class="uk-width-1-1">
            <div class="uk-container">
                <h2 class="rz-text-pagetitle">Profil</h2>
            </div>

        </div>

    </section>


    <section class="uk-margin-medium">
        <div class="uk-container">
            <div uk-grid>
                <div class="uk-width-1-3@s">
                    <div class="rz-panel">

                        <div class="uk-text-large">{{ $customer->nama }}</div>
                        <div class="uk-text-muted">011397864523</div>
                        <div class="uk-margin-top"><span class="uk-margin-small-right rz-text-primary" uk-icon="star"></span>{{ $customer->customer_category->nama }}</div>
                    </div>
                </div>
                <div class="uk-width-2-3@s">
                    <div class="rz-panel">
                        <div class="uk-margin-medium">
                            <table class="rz-table-vertical">
                                <caption class="uk-text-left">
                                    <h4>Data Pribadi</h4>
                                </caption>
                                <tr>
                                    <th>Nama Lengkap</th>
                                    <td class="uk-table-shrink">:</td>
                                    <td>{{ $customer->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Tempat / Tanggal Lahir</th>
                                    <td class="uk-table-shrink">:</td>
                                    <td>{{ $customer->pob }} {{ $customer->dob }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat Rumah</th>
                                    <td class="uk-table-shrink">:</td>
                                    <td>{{ $customer->alamat }}</td>
                                </tr>
                                <tr>
                                    <th>No HP</th>
                                    <td class="uk-table-shrink">:</td>
                                    <td>{{ $customer->nohp }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td class="uk-table-shrink">:</td>
                                    <td>{{ $customer->email }}</td>
                                </tr>
                                <tr>
                                    <th>No KTP</th>
                                    <td class="uk-table-shrink">:</td>
                                    <td>{{ $customer->no_ktp }}</td>
                                </tr>
                                <tr>
                                    <th>Jenis Kelamin</th>
                                    <td class="uk-table-shrink">:</td>
                                    <td>{{ $customer->jenis_kelamin }}</td>
                                </tr>
                                <tr>
                                    <th>Pekerjaan</th>
                                    <td class="uk-table-shrink">:</td>
                                    <td>{{ $customer->pekerjaan }}</td>
                                </tr>
                                <tr>
                                    <th>Lama Berusaha</th>
                                    <td class="uk-table-shrink">:</td>
                                    <td>{{ $customer->lama_berusaha }}</td>
                                </tr>
                                <tr>
                                    <th>Omset per Tahun</th>
                                    <td class="uk-table-shrink">:</td>
                                    <!-- <td>{{ $customer->omset }}</td> -->
                                    <td>Rp. {{ number_format($customer->omset, 0, ',', '.') }} </td>
                                </tr>
                            </table>
                        </div>
                        <div class="uk-margin-medium">
                            <table class="rz-table-vertical">
                                <caption class="uk-text-left">
                                    <h4>Data Perusahaan</h4>
                                </caption>
                                <tr>
                                    <th>Nama Perusahaan</th>
                                    <td class="uk-table-shrink">:</td>
                                    <td>{{ $customer->nama_perusahaan }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat Perusahaan</th>
                                    <td class="uk-table-shrink">:</td>
                                    <td>{{ $customer->alamat_perusahaan }}</td>
                                </tr>
                                <tr>
                                    <th>No Telepon</th>
                                    <td class="uk-table-shrink">:</td>
                                    <td>{{ $customer->tlp_perusahaan }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td class="uk-table-shrink">:</td>
                                    <td>{{ $customer->email_perusahaan}}</td>
                                </tr>
                                <tr>
                                    <th>Jenis Usaha</th>
                                    <td class="uk-table-shrink">:</td>
                                    <td>{{ $customer->jenis_usaha }}</td>
                                </tr>
                                <tr>
                                    <th>Lama Berdiri Perusahaan</th>
                                    <td class="uk-table-shrink">:</td>
                                    <td>{{ $customer->lama_perusahaan}}</td>
                                </tr>
                                <tr>
                                    <th>Omset per Tahun</th>
                                    <td class="uk-table-shrink">:</td>
                                    <!-- <td>{{ $customer->omset_perusahaan }}</td> -->
                                    <td>Rp. {{ number_format($customer->omset_perusahaan, 0, ',', '.') }} </td>
                                </tr>
                                <tr>
                                    <th>Kebutuhan Nominal</th>
                                    <td class="uk-table-shrink">:</td>
                                    <!-- <td>{{ $customer->kebutuhan_nominal }}</td> -->
                                    <td>Rp. {{ number_format($customer->kebutuhan_nominal, 0, ',', '.') }} </td>
                                </tr>
                                <tr>
                                    <th>Referensi</th>
                                    <td class="uk-table-shrink">:</td>
                                    <td>{{ $customer->referensi }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="uk-text-right">
                            <a href="" class="uk-button uk-button-default uk-border-rounded">Edit Profile</a>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </section>

</x-app-layout>
