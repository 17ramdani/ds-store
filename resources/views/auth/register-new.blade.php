<x-guest-new-layout>
    <section id="pageContent" class="uk-section" uk-height-viewport="offset-bottom: 20">
        <div class="uk-container uk-container-small">
            <div class="rz-panel">
               <h3><i class="ph-light ph-clipboard-text rz-icon"></i>Daftar</h3>
                <div id="regForm" class="uk-child-width-1-2@s uk-grid-large" uk-grid>
                    <div>
                        <ul>
                            <li>
                                <i class="ph-2x ph-fill ph-check-circle"></i>
                                <div>Verifikasi Identitas</div>
                            </li>
                            <li>
                                <i class="ph-2x ph-light ph-check-circle"></i>
                                <div>Informasi Pribadi</div>
                            </li>
                            <li>
                                <i class="ph-2x ph-light ph-check-circle"></i>
                                <div>Tinjauan</div>
                            </li>
                        </ul>
                        <div class="uk-margin-medium-top">
                           <h5>Foto KTP</h5>
                           <p>Pastikan foto KTP Anda jelas dan informasi Anda sesuai</p>
                        </div>
                        <form action="/upload-ktp" method="POST" enctype="multipart/form-data" id="uploadForm">
                        @csrf
                        <div class="uk-margin-large">
                              <label class="cameraButton">
                                   <i class="ph-thin ph-camera-plus"></i>
                                Klik di sini untuk mengambil foto KTP Anda
                                <input id="fileInput" name="fileInput" class="rz-input-camera" type="file" accept="image/*;capture=camera" onchange="previewFile(this)">
                              </label>
                              <img id="previewImage" src="#" alt="Pratinjau gambar" />
                        </div>
                        <div class="uk-margin-medium-top">
                            <div class="uk-child-width-1-2 uk-grid-small" uk-grid>
                                <div>
                                    <button onClick="resetForm()" class="uk-button uk-button-default uk-width-1-1">Ulangi</button>        
                                </div>
                                <div>
                                    <button id="confirmButton" class="uk-button uk-button-primary uk-width-1-1">Konfirmasi</button>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                    <div>
                        <p>Petunjuk pengisian:</p>
                        <ol>
                            <li>Pastikan KTP yang Anda input adalah KTP <strong>Anda sendiri!</strong></li>
                            <li>Jangan gunakan KTP milik orang lain</li>
                            <li>Jangan gunakan kartu ATM, kartu keluarga, apalagi kartu Domino</li>
                        </ol>
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
    @if(session('error'))
        @push('script')
            <script>
                @if(is_array(session('error')))
                    notif('error', '{{ implode(', ', session('error')) }}');
                @else
                    notif('error', '{{ session('error') }}');
                @endif
            </script>
        @endpush
    @endif

    
    @push('script')
    <script>
        function previewFile(input) {
            var preview = document.getElementById('previewImage');
            var file = input.files[0];
            var reader = new FileReader();

            reader.onloadend = function() {
                preview.src = reader.result;
                preview.style.display = 'block';
                var cameraButton = input.parentElement; // Mengakses elemen parent dari input
                cameraButton.style.display = 'none';
            }

            if (file) {
                reader.readAsDataURL(file);
                var cameraButton = input.parentElement; // Mengakses elemen parent dari input
                cameraButton.style.display = 'none';
            } else {
                preview.src = '#';
                preview.style.display = 'none';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            var preview = document.getElementById('previewImage');
            preview.style.display = 'none';
        });

        function resetForm() {
            event.preventDefault();
            var preview = document.getElementById('previewImage');
            var cameraButton = document.querySelector('.cameraButton');
            preview.src = '#';
            preview.style.display = 'none';
            cameraButton.style.display = 'inline-block';
        }

        document.getElementById('uploadForm').addEventListener('submit', function(event) {
            var confirmButton = document.getElementById('confirmButton');
            var originalButtonText = confirmButton.innerHTML;

            confirmButton.innerHTML = 'Loading...';
            confirmButton.disabled = true;
            // event.preventDefault(); // Mencegah submit form secara default
            // uploadImage();
        });

    </script>
    @endpush
</x-guest-new-layout>