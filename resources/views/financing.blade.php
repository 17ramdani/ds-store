<x-app-layout>

    <section id="navbarSecondary" class="uk-flex uk-flex-middle uk-flex-left">
        <div class="uk-width-1-1">
            <div class="uk-container">
                <h2 class="rz-text-pagetitle">Buyer Financing</h2>
            </div>

        </div>

    </section>
    <section class="uk-margin-medium">
        <div class="uk-container">
            <div class="rz-panel">
                <h3>Form Pengajuan Buyer Financing</h3>
                <div class="uk-height-medium uk-cover-container uk-margin-large"><img src="https://source.unsplash.com/Dz-Iij3CrpM/1600x300" alt="" uk-cover></div>
                <div uk-grid>
                    <div class="uk-width-2-3@s">
                        <div uk-grid>
                            <div class="uk-width-1-3@s">
                                <h5>Nama Tertera Pada Kartu</h5>
                            </div>
                            <div class="uk-width-2-3@s">
                                <form class="uk-form-stacked" method="POST" action="{{ route('financing.store') }}">
                                    @csrf


                                    <div class="uk-margin">
                                        <label class="uk-form-label" for="form-stacked-select">Nama Lengkap</label>
                                        <div class="uk-form-controls">
                                            <input type="text" class="uk-input" name="nama" value="{{ $customer->nama }}">

                                            <input type="hidden" class="uk-input" name="pesanan_id" value="{{ $pesanan->id }}">
                                            <input type="hidden" class="uk-input" name="status" value="PENDING">

                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <label class="uk-form-label" for="form-stacked-select">Nama Perusahaan</label>
                                        <div class="uk-form-controls">
                                            <input type="text" class="uk-input" name="nama_perusahaan" value="{{ $customer->nama_perusahaan }}">
                                        </div>
                                    </div>

                            </div>
                        </div>
                        <div uk-grid>
                            <div class="uk-width-1-3@s">
                                <h5>Data Pribadi</h5>
                            </div>
                            <div class="uk-width-2-3@s">

                                    <div class="uk-margin">
                                        <label class="uk-form-label" for="form-stacked-select">Nama Lengkap</label>
                                        <div class="uk-form-controls">
                                            <input type="text" class="uk-input" name="nama" value="{{ $customer->nama }}">
                                        </div>
                                    </div>
                                    <div class="uk-child-width-1-2" uk-grid>
                                        <div>
                                            <label class="uk-form-label" for="form-stacked-select">Tempat</label>
                                            <div class="uk-form-controls">
                                                <input type="text" class="uk-input" name="pob" value="{{ $customer->pob }}">
                                            </div>
                                        </div>
                                        <div>
                                            <label class="uk-form-label" for="form-stacked-select">Tanggal Lahir</label>
                                            <div class="uk-form-controls">
                                                <input type="date" class="uk-input" name="dob" value="{{ $customer->dob }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <label class="uk-form-label" for="form-stacked-select">Alamat Rumah</label>
                                        <div class="uk-form-controls">
                                            <textarea rows="5" class="uk-textarea" name="alamat" value="">{{ $customer->alamat }}</textarea>
                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <label class="uk-form-label" for="form-stacked-select">No HP</label>
                                        <div class="uk-form-controls">
                                            <input type="tel" class="uk-input" name="nohp" value="{{ $customer->nohp }}">
                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <label class="uk-form-label" for="form-stacked-select">Email</label>
                                        <div class="uk-form-controls">
                                            <input type="email" class="uk-input" name="email" value="{{ $customer->email }}">
                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <label class="uk-form-label" for="form-stacked-select">No.KTP</label>
                                        <div class="uk-form-controls">
                                            <input type="text" class="uk-input" name="no_ktp" value="{{ $customer->no_ktp }}">
                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <label class="uk-form-label" for="form-stacked-select">Pekerjaan</label>
                                        <div class="uk-form-controls">
                                            <input type="text" class="uk-input" name="pekerjaan" value="{{ $customer->pekerjaan }}">
                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <label class="uk-form-label" for="form-stacked-select">Lama Berusaha</label>
                                        <div class="uk-form-controls">
                                            <input type="text" class="uk-input" name="lama_berusaha" value="{{ $customer->lama_berusaha }}">
                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <label class="uk-form-label" for="form-stacked-select">Omset per Tahun</label>
                                        <div class="uk-form-controls">
                                            <input type="number" class="uk-input" name="omset" value="{{ $customer->omset }}">
                                        </div>
                                    </div>
                            </div>
                        </div>

                        <div uk-grid>
                            <div class="uk-width-1-3@s">
                                <h5>Data Perusahaan</h5>
                            </div>
                            <div class="uk-width-2-3@s">

                                    <div class="uk-margin">
                                        <label class="uk-form-label" for="form-stacked-select">Nama Perusahaan</label>
                                        <div class="uk-form-controls">
                                            <input type="text" class="uk-input" name="nama_perusahaan" value="{{ $customer->nama_perusahaan }}">
                                        </div>
                                    </div>

                                    <div class="uk-margin">
                                        <label class="uk-form-label" for="form-stacked-select">Alamat Perusahaan</label>
                                        <div class="uk-form-controls">
                                            <textarea rows="5" class="uk-textarea" name="alamat_perusahaan" value="">{{ $customer->alamat_perusahaan }}</textarea>
                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <label class="uk-form-label" for="form-stacked-select">No Telepon</label>
                                        <div class="uk-form-controls">
                                            <input type="tel" class="uk-input" name="tlp_perusahaan" value="{{ $customer->tlp_perusahaan }}">
                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <label class="uk-form-label" for="form-stacked-select">Email</label>
                                        <div class="uk-form-controls">
                                            <input type="email" class="uk-input" name="email" value="{{ $customer->email }}">
                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <label class="uk-form-label" for="form-stacked-select">Jenis Usaha</label>
                                        <div class="uk-form-controls">
                                            <input type="text" class="uk-input" name="jenis_usaha" value="{{ $customer->jenis_usaha }}">
                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <label class="uk-form-label" for="form-stacked-select">Lama Berdiri
                                            Perusahaan</label>
                                        <div class="uk-form-controls">
                                            <input type="number" class="uk-input" name="lama_berusaha" value="{{ $customer->lama_berusaha }}">
                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <label class="uk-form-label" for="form-stacked-select">Omset per Tahun</label>
                                        <div class="uk-form-controls">
                                            <input type="number" class="uk-input" name="omset_perusahaan" value="{{ $customer->omset_perusahaan }}">
                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <label class="uk-form-label" for="form-stacked-select">Kebutuhan Nominal</label>
                                        <div class="uk-form-controls">

                                            <input type="number" class="uk-input" name="kebutuhan_nominal" value="{{ $pesanan->total }}">

                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <label class="uk-form-label" for="form-stacked-select">Referensi</label>
                                        <div class="uk-form-controls">
                                            <input type="text" class="uk-input" name="referensi" value="{{ $customer->referensi }}">
                                        </div>
                                    </div>


                                    <div class="uk-margin-large-top uk-text-right">
                                        <button type="submit" class="uk-button uk-button-primary uk-border-rounded">Submit</button>
                                    </div>


                                </form>
                            </div>
                        </div>

                    </div>
                    <div class="uk-width-1-3@s">
                        <div class="uk-margin-medium">
                            <h5>Syarat dan Ketentuan:</h5>
                            <ol>
                                <li>Sudah menjadi Rekanan Dunia Sandang minimal 6 (enam) bulan</li>
                                <li>Lokasi / Domisili : Pulau Jawa, Pulau Bali, Makassar, Balikpapan, Padang, Pekanbaru,
                                    Jambi,</li>
                            </ol>
                        </div>
                        <div class="uk-margin-medium">
                            <h5>Konsumen Individu</h5>
                            <div>
                                <dl>
                                    <dt>Pinjaman dibawah Rp. 50.000.000,-</dt>
                                    <dd>
                                        <ul>
                                            <li>KTP Pemohon</li>
                                            <li>Histori Transaksi 3 (tiga) bulan terakhir / 3 (tiga) kali Transaksi di
                                                Dunia Sandang</li>
                                            <li>Soft Copy Invoice</li>
                                        </ul>
                                    </dd>
                                </dl>
                            </div>
                            <div>
                                <dl>
                                    <dt>Pinjaman diatas Rp. 50.000.000,-</dt>
                                    <dd>
                                        <ul>
                                            <li>KTP Pemohon</li>
                                            <li>KTP Suami / Istri Pemohon</li>
                                            <li>Histori Transaksi 3 (tiga) bulan terakhir / 3 (tiga) kali Transaksi di
                                                Dunia Sandang</li>
                                            <li>Soft Copy Invoice</li>
                                        </ul>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                        <div class="uk-margin-medium">
                            <h5>Konsumen Perusahaan</h5>
                            <div>
                                <dl>
                                    <dt>Pinjaman dibawah Rp. 500.000.000,-</dt>
                                    <dd>
                                        <ul>
                                            <li>KTP Direksi</li>
                                            <li>NPWP Perusahaan</li>
                                            <li>Legalitas Perusahaan (Akta Pendirian dan Perubahan beserta SK.
                                                Kemenkumham</li>
                                            <li>Histori Transaksi 3 (tiga) bulan terakhir / 3 (tiga) kali Transaksi di
                                                Dunia Sandang</li>
                                            <li>Soft Copy Invoice</li>
                                        </ul>
                                    </dd>
                                </dl>
                            </div>
                            <div>
                                <dl>
                                    <dt>Pinjaman diatas Rp. 500.000.000,-</dt>
                                    <dd>
                                        <ul>
                                            <li>KTP Direktur Utama</li>
                                            <li>NPWP Perusahaan</li>
                                            <li>Legalitas Perusahaan (Akta Pendirian dan Perubahan beserta SK.
                                                Kemenkumham</li>
                                            <li>NIB / SIUP / TDP</li>
                                            <li>Histori Transaksi 3 (tiga) bulan terakhir / 3 (tiga) kali Transaksi di
                                                Dunia Sandang</li>
                                            <li>Soft Copy Invoice</li>
                                            <li>Backed Up Cheque</li>
                                        </ul>
                                    </dd>
                                </dl>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

</x-app-layout>
