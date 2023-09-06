<x-app-layout>
    <section id="navbarSecondary" class="uk-flex uk-flex-middle uk-flex-left">
        <div class="uk-width-1-1">
            <div class="uk-container">
                <h2 class="rz-text-pagetitle">Membership Registration</h2>
            </div>
        </div>

    </section>


    <section class="uk-margin-medium">
        <div class="uk-container">
            <div class="rz-panel">
                <!-- <h3>Form Pendaftaran Member</h3> -->
                <div class="uk-height-medium uk-cover-container uk-margin-large">
                    <img src="{{ asset('assets/img/guest/sample.jpeg') }}" alt="banner" uk-cover>
                </div>
                <x-alert />
                <form class="uk-form-stacked" method="POST" action="{{ route('membership.update', $customer->id) }}">
                    @csrf
                    @method('PATCH')
                    <div uk-grid>
                        <div class="uk-width-2-3@s">
                            <div uk-grid>
                                <div class="uk-width-1-3@s">
                                    <h5>Nama Tertera Pada Kartu</h5>
                                </div>
                                <div class="uk-width-2-3@s">
                                    {{-- <form class="uk-form-stacked"> --}}

                                    <div class="uk-margin">
                                        <label class="uk-form-label" for="form-stacked-select">Nama Lengkap *</label>
                                        <div class="uk-form-controls">
                                            <input type="text" class="uk-input" name="nama" value="{{ $customer->nama }}" required placeholder="">
                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <label class="uk-form-label" for="form-stacked-select">Nama Perusahaan*</label>
                                        <div class="uk-form-controls">
                                            <input type="text" class="uk-input" name="nama_perusahaan" value="{{ $customer->nama_perusahaan }}" required placeholder="">
                                        </div>
                                    </div>


                                    {{-- </form> --}}
                                </div>
                            </div>
                            <div uk-grid>
                                <div class="uk-width-1-3@s">
                                    <h5>Data Pribadi</h5>
                                </div>
                                <div class="uk-width-2-3@s">
                                    {{-- <form class="uk-form-stacked"> --}}

                                    <div class="uk-margin">
                                        <label class="uk-form-label" for="form-stacked-select">Nama Lengkap*</label>
                                        <div class="uk-form-controls">
                                            <input type="text" class="uk-input" name="nama_lengkap2" value="{{ auth()->user()->name }}" required placeholder="">
                                        </div>
                                    </div>
                                    <div class="uk-child-width-1-2" uk-grid>
                                        <div>
                                            <label class="uk-form-label" for="form-stacked-select">Tempat</label>
                                            <div class="uk-form-controls">
                                                <input type="text" class="uk-input" name="pob" value="{{ old('pob',$customer->pob) }}" placeholder="">
                                            </div>
                                        </div>
                                        <div>
                                            <label class="uk-form-label" for="form-stacked-select">Tanggal Lahir</label>
                                            <div class="uk-form-controls">
                                                <input type="date" class="uk-input" name="dob" value="{{ old('dob',$customer->dob) }}" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <label class="uk-form-label" for="form-stacked-select">Alamat Rumah</label>
                                        <div class="uk-form-controls">
                                            <textarea rows="5" class="uk-textarea" name="alamat">{{ old('alamat', $customer->alamat) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <label class="uk-form-label" for="form-stacked-select">No HP*</label>
                                        <div class="uk-form-controls">

                                            <input type="tel" class="uk-input" name="nohp" value="{{ $customer->nohp }}" required placeholder="">

                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <label class="uk-form-label" for="form-stacked-select">Email*</label>
                                        <div class="uk-form-controls">

                                            <input type="email" class="uk-input" name="email" value="{{ $customer->email }}" required placeholder="">

                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <label class="uk-form-label" for="form-stacked-select">No.KTP</label>
                                        <div class="uk-form-controls">
                                            <input type="text" class="uk-input" name="no_ktp" placeholder="" value="{{ old('no_ktp',$customer->no_ktp) }}">
                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <label class="uk-form-label" for="form-stacked-select">Pekerjaan</label>
                                        <div class="uk-form-controls">
                                            <input type="text" class="uk-input" name="pekerjaan" value="{{ old('pekerjaan',$customer->pekerjaan) }}" placeholder="">
                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <label class="uk-form-label" for="form-stacked-select">Lama Berusaha</label>
                                        <div class="uk-form-controls">
                                            <input type="text" class="uk-input" name="lama_berusaha" value="{{ old('lama_berusaha',$customer->lama_berusaha) }}" placeholder="">
                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <label class="uk-form-label" for="form-stacked-select">Omset per Tahun</label>
                                        <div class="uk-form-controls">
                                            <input type="number" class="uk-input" id name="omset" placeholder="" value="{{ old('omset',$customer->omset) }}">
                                        </div>
                                    </div>
                                    {{-- </form> --}}
                                </div>
                            </div>

                            <div uk-grid>
                                <div class="uk-width-1-3@s">
                                    <h5>Data Perusahaan</h5>
                                </div>
                                <div class="uk-width-2-3@s">
                                    {{-- <form class="uk-form-stacked"> --}}


                                    <div class="uk-margin">
                                        <label class="uk-form-label" for="form-stacked-select">Nama
                                            Perusahaan*</label>
                                        <div class="uk-form-controls">
                                            <input type="text" class="uk-input" name="nama_perusahaan2" value="{{ $customer->nama_perusahaan }}" required placeholder="">

                                        </div>
                                    </div>

                                    <div class="uk-margin">
                                        <label class="uk-form-label" for="form-stacked-select">Alamat
                                            Perusahaan* </label>
                                        <div class="uk-form-controls">
                                            <textarea rows="5" class="uk-textarea" name="alamat_perusahaan" required>{{ old('alamat_perusahaan',$customer->alamat_perusahaan) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <label class="uk-form-label" for="form-stacked-select">No Telepon*</label>
                                        <div class="uk-form-controls">
                                            <input type="tel" class="uk-input" name="tlp_perusahaan" value="{{ old('tlp_perusahaan',$customer->tlp_perusahaan) }}" required placeholder="">
                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <label class="uk-form-label" for="form-stacked-select">Email Perusahaan*</label>
                                        <div class="uk-form-controls">
                                            <input type="email" class="uk-input" name="email_perusahaan" value="{{ old('email_perusahaan',$customer->email_perusahaan) }}" required placeholder="">
                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <label class="uk-form-label" for="form-stacked-select">Jenis Usaha</label>
                                        <div class="uk-form-controls">
                                            <input type="text" class="uk-input" name="jenis_usaha" value="{{ old('jenis_usaha',$customer->jenis_usaha) }}" placeholder="">
                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <label class="uk-form-label" for="form-stacked-select">Lama Berdiri
                                            Perusahaan</label>
                                        <div class="uk-form-controls">
                                            <input type="number" class="uk-input" name="lama_berusaha" value="{{ old('lama_berusaha',$customer->lama_berusaha) }}" placeholder="">
                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <label class="uk-form-label" for="form-stacked-select">Omset per Tahun</label>
                                        <div class="uk-form-controls">
                                            <input type="number" class="uk-input" name="omset_perusahaan" value="{{ old('omset_perusahaan',$customer->omset_perusahaan) }}" placeholder="">
                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <label class="uk-form-label" for="form-stacked-select">Kebutuhan
                                            Nominal</label>
                                        <div class="uk-form-controls">
                                            <input type="number" class="uk-input" name="kebutuhan_nominal" value="{{ old('kebutuhan_nominal',$customer->kebutuhan_nominal) }}" placeholder="">
                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <label class="uk-form-label" for="form-stacked-select">Referensi</label>
                                        <div class="uk-form-controls">
                                            <input type="text" class="uk-input" name="referensi" value="{{ old('referensi',$customer->referensi) }}" placeholder="">
                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <fieldset id="optionMembership">
                                            <div class="uk-flex uk-flex-between@s uk-flex-center">
                                                <div class="rz-option">
                                                    <input class="uk-radio" type="radio" id="Reguler" name="paket" name="customer_category_id" value="1" {{ $customer->customer_category_id == 1 ? 'checked' : '' }}>
                                                    <br>

                                                    <label for="huey">Reguler</label>
                                                    <div>Free</div>
                                                </div>

                                                <!-- <div class="rz-option">
                                                    <input class="uk-radio" type="radio" id="Distributor" name="paket" name="customer_category_id" value="2" {{ $customer->customer_category_id == 2 ? 'checked' : '' }}>
                                                    <br>

                                                    <label for="dewey">Distributor</label>
                                                    <div>Rp. 10,000,000 <span class="uk-text-small uk-text-meta">/tahun</span></div>
                                                </div> -->

                                                <div class="rz-option">
                                                    <input class="uk-radio" type="radio" id="Member" name="paket" value="3" {{ $customer->customer_category_id == 3 ? 'checked' : '' }}>
                                                    <br>

                                                    <label for="louie">Member</label>
                                                    <div>Rp. 12,000,000 <span class="uk-text-small uk-text-meta">/tahun</span></div>
                                                </div>
                                            </div>
                                        </fieldset>

                                        <a href="#modalMemberPaket" class="uk-button uk-button-default uk-border-rounded" uk-toggle><span class="uk-margin-small-right" uk-icon="info"></span>Bandingkan
                                            Paket</a>

                                    </div>

                                    <div class="uk-margin-large-top uk-text-right">
                                        <button type="submit" class="uk-button uk-button-primary uk-border-rounded">Daftar</button>
                                    </div>


                                    {{-- </form> --}}
                                </div>
                            </div>

                        </div>
                        <div class="uk-width-1-3@s">

                            <div><img src="https://duniasandang.com/wp-content/uploads/2022/06/Untitled-design-8-768x1370.png" alt=""></div>
                            <div><img src="https://duniasandang.com/wp-content/uploads/2022/06/Untitled-design-9-1-576x1024.png" alt=""></div>

                            <div class="uk-margin">
                                <img src="https://duniasandang.com/wp-content/uploads/2022/06/KEUNTUNGAN-MEMBERSHIP-1024x576.png" alt="">
                            </div>
                            Syarat menjadi Member:
                            <ol>
                                <li>Biaya Pendaftaran Rp. 12.000.000,-</li>
                                <li>Masa Berlaku Selama 12 Bulan</li>
                                <li>Biaya Perpanjangan Rp. 10.000.000,-
                                    <br>
                                    <span class="uk-text-meta uk-text-small">Perpanjangan tidak dapat dilakukan jika
                                        telah
                                        melewati masa berlaku membership</span>
                                </li>
                                <li>Metode Pembayaran Transfer</li>
                            </ol>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <div id="modalMemberPaket" class="uk-modal-container" uk-modal>
        <div class="uk-modal-dialog uk-modal-body">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <h3>Paket Keanggotaan</h3>
            <div class="uk-overflow-auto">
                <table class="uk-table uk-table-small uk-table-striped">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Reguler</th>
                            <th>Distributor</th>
                            <th>Member</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Fasilitas 1</td>
                            <td><i class="ph-lg ph-check-circle-fill"></i></td>
                            <td><i class="ph-lg ph-check-circle-fill"></i></td>
                            <td><i class="ph-lg ph-check-circle-fill"></i></td>
                        </tr>
                        <tr>
                            <td>Fasilitas 2</td>
                            <td><i class="ph-lg ph-check-circle-fill"></i></td>
                            <td><i class="ph-lg ph-check-circle-fill"></i></td>
                            <td><i class="ph-lg ph-check-circle-fill"></i></td>
                        </tr>
                        <tr>
                            <td>Fasilitas 3</td>
                            <td></td>
                            <td><i class="ph-lg ph-check-circle-fill"></i></td>
                            <td><i class="ph-lg ph-check-circle-fill"></i></td>
                        </tr>
                        <tr>
                            <td>Fasilitas 4</td>
                            <td></td>
                            <td></td>
                            <td><i class="ph-lg ph-check-circle-fill"></i></td>
                        </tr>

                        <tr>
                            <td>Harga</td>
                            <td>Free</td>
                            <td>10,000,000 <br>/tahun</td>
                            <td>12,000,000 <br>/tahun</td>
                        </tr>
                        <tr>
                            <td>Terms &amp; Conditions</td>
                            <td>
                                <ul class="uk-text-small">
                                    <li>Consectetur adipisicing elit. Dolorem, at.</li>
                                    <li>Tempora molestiae, velit, aliquam et impedit sapiente nulla.</li>
                                </ul>
                            </td>
                            <td>
                                <ul class="uk-text-small">
                                    <li>Tempora molestiae, velit, aliquam et impedit sapiente nulla.</li>
                                    <li>Unde illo ipsam natus veniam itaque.</li>
                                </ul>
                            </td>
                            <td>
                                <ul class="uk-text-small">
                                    <li>Unde illo ipsam natus veniam itaque.</li>
                                </ul>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
