<x-app-layout>
    <section id="pageContent" class="uk-section" uk-height-viewport="offset-bottom: 20">
        <div class="uk-container uk-container-small">
            <div class="rz-panel uk-margin-large-bottom">
                <div id="regForm" class="uk-child-width-1-2@s uk-grid-large" uk-grid>
                    <div>
                        <ul>
                            <li>
                                <i class="ph-2x ph-fill ph-check-circle"></i>
                                <div>Verifikasi Identitas</div>
                            </li>
                            <li>
                                <i class="ph-2x ph-fill ph-check-circle"></i>
                                <div>Informasi Pribadi</div>
                            </li>
                            <li>
                                <i class="ph-2x ph-light ph-check-circle"></i>
                                <div>Tinjauan</div>
                            </li>
                        </ul>
                        <div class="uk-margin-medium-top">
                           <h5>Informasi Pribadi</h5>
                           <p>Pastikan foto KTP Anda jelas dan informasi Anda sesuai</p>
                           
                        </div>
                        <div class="uk-margin-large">
                            <img src="{{ asset('storage/upload-ktp/' . $filename) }}" alt="">
                        </div>
                        {{-- @dd($ktpData) --}}
                        <div class="uk-margin-medium-top">
                            <form id="uploadForm" action="/register-dua" method="POST" class="uk-form-stacked">
                                @csrf
                                <div class="uk-margin">
                                    <label class="uk-form-label">Nama Lengkap</label>
                                    <div class="uk-form-controls">
                                        <input name="nama" value="{{ $ktpData['nama']['value'] }}" class="uk-input uk-form-small" type="text" placeholder="">
                                    </div>
                                </div>
                                <div class="uk-margin">
                                    <label class="uk-form-label">NIK</label>
                                    <div class="uk-form-controls">
                                        <input name="no_ktp" value="{{ $ktpData['nik']['value'] }}" class="uk-input uk-form-small" type="number" placeholder="3204081234560001">
                                    </div>
                                </div>
                                <div class="uk-margin">
                                    <label class="uk-form-label">Tempat Lahir</label>
                                    <div class="uk-form-controls">
                                        <input name="pob" value="{{ $ktpData['tempatLahir']['value'] }}" class="uk-input uk-form-small" type="text" placeholder="Bandung">
                                    </div>
                                </div>
                                <div class="uk-margin">
                                    <label class="uk-form-label">Tanggal Lahir</label>
                                    <div class="uk-form-controls">
                                        <input name="dob" value="{{ date('Y-m-d', strtotime($ktpData['tanggalLahir']['value'])) }}" class="uk-input uk-form-small" type="date" placeholder="17 - 04 - 1989">
                                    </div>
                                </div>
                                <div class="uk-margin">
                                    <label class="uk-form-label">Jenis Kelamin</label>
                                    <div class="uk-form-controls">
                                        <input name="jenis_kelamin" value="{{ $ktpData['jenisKelamin']['value'] }}" class="uk-input uk-form-small" type="text" placeholder="Laki-laki">
                                    </div>
                                </div>
                                <div class="uk-margin">
                                    <label class="uk-form-label">Alamat sesuai KTP</label>
                                    <div class="uk-form-controls">
                                        <textarea rows="4" name="alamat" class="uk-textarea uk-form-small" placeholder="Jl. Terusan Pasirkoja No.250, Babakan, Kec. Babakan Ciparay, Kota Bandung, Jawa Barat 40222">{{ $ktpData['alamat']['value'] }}</textarea>
                                    </div>
                                </div>
                                <div class="uk-child-width-1-2" uk-grid>
                                    <div>
                                        <label class="uk-form-label">RT</label>
                                        <div class="uk-form-controls">
                                            <input name="rt" value="{{ $ktpData['rt']['value'] }}" class="uk-input uk-form-small" type="text" placeholder="001">
                                        </div>    
                                    </div>
                                    <div>
                                        <label class="uk-form-label">RW</label>
                                        <div class="uk-form-controls">
                                            <input name="rw" value="{{ $ktpData['rw']['value'] }}" class="uk-input uk-form-small" type="text" placeholder="001">
                                        </div>    
                                    </div>
                                    
                                </div>
                                <div class="uk-margin">
                                    <label class="uk-form-label">Kel/Desa</label>
                                    <div class="uk-form-controls">
                                        <input name="desa_kelurahan" value="{{ $ktpData['kelurahanDesa']['value'] }}" class="uk-input uk-form-small" type="text" placeholder="Babakan Tarogong">
                                    </div>
                                </div>
                                <div class="uk-margin">
                                    <label class="uk-form-label">Kecamatan</label>
                                    <div class="uk-form-controls">
                                        <input name="kecamatan" value="{{ $ktpData['kecamatan']['value'] }}" class="uk-input uk-form-small" type="text" placeholder="Bojongloa Kaler">
                                    </div>
                                </div>
                                <div class="uk-margin">
                                    <label class="uk-form-label">Agama</label>
                                    <div class="uk-form-controls">
                                        <input name="agama" value="{{ $ktpData['agama']['value'] }}" class="uk-input uk-form-small" type="text" placeholder="Islam">
                                    </div>
                                </div>
                                <div class="uk-margin">
                                    <label class="uk-form-label">Status Perkawinan</label>
                                    <div class="uk-form-controls">
                                        <input name="status_perkawinan" value="{{ $ktpData['statusPerkawinan']['value'] }}" class="uk-input uk-form-small" type="text" placeholder="Kawin">
                                    </div>
                                </div>
                                <div class="uk-margin">
                                    <label class="uk-form-label">Pekerjaan</label>
                                    <div class="uk-form-controls">
                                        <input name="pekerjaan" value="{{ $ktpData['pekerjaan']['value'] }}" class="uk-input uk-form-small" type="text" placeholder="Kawin">
                                    </div>
                                </div>
                                <div class="uk-margin">
                                    <label class="uk-form-label">Kewarganegaraan</label>
                                    <div class="uk-form-controls">
                                        <input name="kewarganegaraan" value="{{ $ktpData['kewarganegaraan']['value'] }}" class="uk-input uk-form-small" type="text" placeholder="Kawin">
                                    </div>
                                </div>
                                <div class="uk-margin">
                                    <label class="uk-form-label">No.HP</label>
                                    <div class="uk-form-controls">
                                        <input name="no_hp" class="uk-input uk-form-small" type="tel">
                                    </div>
                                </div>
                                <div class="uk-margin">
                                    <label class="uk-form-label">Email</label>
                                    <div class="uk-form-controls">
                                        <input name="email" class="uk-input uk-form-small" type="email">
                                        <x-input-error :messages="$errors->get('email')" />
                                    </div>
                                </div>
                                <div class="uk-margin">
                                    <label class="uk-form-label">Password</label>
                                    <div class="uk-inline uk-width-1-1">
                                        <a class="uk-form-icon uk-form-icon-flip" href="" id="togglePassword" uk-icon="icon: eye-slash"></a>
                                        <input name="password" class="uk-input uk-form-small" type="password" id="passwordInput">
                                        <x-input-error :messages="$errors->get('password')" />
                                    </div>
                                </div>
                                <div class="uk-margin">
                                    <label class="uk-form-label">Konfirmasi Password</label>
                                    <div class="uk-inline uk-width-1-1">
                                        <a class="uk-form-icon uk-form-icon-flip" href="" id="ConfrmtogglePassword" uk-icon="icon: eye-slash"></a>
                                        <input name="password_confirmation" class="uk-input uk-form-small" type="password" id="passwordInputConfrm">
                                    </div>
                                </div>
                                <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                                    <label class="uk-text-small"><input class="uk-checkbox uk-margin-small-right" type="checkbox" checked>Dengan ini saya menyatakan bahwa semua data yang diisikan adalah benar.</label>
                                </div>
                                <div class="uk-margin-medium-top">
                                    <div class="uk-child-width-1-2 uk-grid-small" uk-grid>
                                        <div>
                                            <a href="/register" class="uk-button uk-button-default uk-width-1-1">Ulangi</a>
                                        </div>
                                        <div>
                                            <button id="confirmButton" type="submit" class="uk-button uk-button-primary uk-width-1-1">Konfirmasi</button>        
                                        </div>
                                    </div>
                                </div>
    
                            </form>
                            
                            
                        </div>
                    </div>
                    <div>
                        <p>PT Dunia Sandang Pratama menjamin bahwa data dan informasi yang diberikan pengguna bersifat rahasia, tidak akan disebarluaskan, dan hanya dipergunakan untuk keperluan transaksi antara customer dan PT Dunia Sandang Pratama.</p>
                    </div>
                </div>
            </div>
            
        </div>
    </section>

    @if(session('success'))
        @push('script')
            <script>
                notif('success', '{{ session('success') }}');
            </script>
        @endpush
    @endif

    @if($errors->any())
        @push('script')
            <script>
                notif('error', '{{ $errors->first() }}');
            </script>
        @endpush
    @endif

    @push('script')
    <script>
        document.getElementById('uploadForm').addEventListener('submit', function(event) {
            var confirmButton = document.getElementById('confirmButton');
            var originalButtonText = confirmButton.innerHTML;

            confirmButton.innerHTML = 'Loading...';
            confirmButton.disabled = true;
            // event.preventDefault(); // Mencegah submit form secara default
            // uploadImage();
        });

        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('passwordInput');
        const ConfrmtogglePassword = document.getElementById('ConfrmtogglePassword');
        const passwordInputConfirm = document.getElementById('passwordInputConfrm');

        togglePassword.addEventListener('click', function (e) {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.setAttribute('uk-icon', type === 'text' ? 'icon: eye' : 'icon: eye-slash');
            e.preventDefault();
        });

        ConfrmtogglePassword.addEventListener('click', function (e) {
            const type = passwordInputConfirm.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInputConfirm.setAttribute('type', type);
            this.setAttribute('uk-icon', type === 'text' ? 'icon: eye' : 'icon: eye-slash');
            e.preventDefault();
        });
    </script>
    @endpush
</x-app-layout>