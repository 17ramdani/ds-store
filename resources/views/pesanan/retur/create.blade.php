<x-app-layout>
    <section id="pageContent" class="uk-section" uk-height-viewport="offset-bottom: 20">
        <div class="uk-container">
            <div class="uk-margin-large uk-grid-large" uk-grid>
                @include('layouts.inc.sidebar')
                <!-- Contains uk-width-1-4@s. Don't screw up! -->
                <div class="uk-width-3-4@s">

                    <div class="rz-detail-order">
                        <h3><i class="ph-light ph-package rz-icon"></i>Retur</h3>
                        <x-alert />
                        <div class="uk-margin-medium-top" uk-grid>
                            <div class="uk-width-1-2@s">
                                <div class="rz-order-container">
                                    <h5>Pengajuan Retur</h5>

                                    <form class="uk-form-stacked" method="post"
                                        action="{{ route('retur.store', $pesanan_id) }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="uk-margin">
                                            <label class="uk-form-label">Follow Up</label>
                                            <div class="uk-form-controls">
                                                <select class="uk-select" name="follow_up">
                                                    <option value="Deposit" @selected($jenis_retur == 'Deposit')>Refund Deposit
                                                    </option>
                                                    <option @selected($jenis_retur == 'Ganti Barang')>Ganti Barang</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="uk-margin">
                                            <label class="uk-form-label">Alasan Retur</label>
                                            <div class="uk-form-controls">
                                                <select class="uk-select" name="alasan_retur">
                                                    <option @selected($alasan_retur == 'Barang tidak sesuai/cacat')>Barang tidak sesuai/cacat
                                                    </option>
                                                    <option @selected($alasan_retur == 'Lainnya')>Lainnya</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="uk-margin">
                                            <label class="uk-form-label">Deskripsi</label>
                                            <div class="uk-form-controls">
                                                <textarea rows="3" class="uk-textarea" name="deskripsi">{{ $deskripsi ?? old('deskripsi') }}</textarea>
                                            </div>
                                        </div>
                                        {{-- <div class="uk-child-width-1-2" uk-grid>
                                            <div>
                                                <label class="uk-form-label">Qty</label>
                                                <div class="uk-form-controls">
                                                    <input type="number" class="uk-input">
                                                </div>
                                            </div>
                                            <div>
                                                <label class="uk-form-label">Satuan</label>
                                                <div class="uk-form-controls">
                                                    <select class="uk-select">
                                                        <option>Kg</option>
                                                        <option>Roll</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div> --}}
                                        <div class="uk-margin">
                                            <label class="uk-form-label">Foto Produk</label>
                                            <div class="js-upload" uk-form-custom>
                                                <input type="file" name="files[]" id="file" multiple
                                                    onchange="getFileData()">
                                                <button class="uk-button uk-button-default" type="button"
                                                    tabindex="-1">Select</button>
                                            </div>
                                            <div class="uk-margin-small">
                                                <span id="filename"></span>
                                                <br>
                                                <div class="uk-child-width-1-2@s" uk-grid>
                                                    @foreach ($files as $file)
                                                        @if ($file != '-')
                                                            <div>
                                                                <img src="{{ $file }}"
                                                                    class="uk-object-cover uk-margin" width="200"
                                                                    height="200" style="aspect-ratio: 1 / 1"
                                                                    alt="phoro">
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="uk-margin-top uk-text-right">
                                            <button type="submit" class="uk-button uk-button-primary">Submit</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                            <div class="uk-width-1-2@s">
                                <div class="rz-order-container">
                                    <h5>Syarat &amp; Ketentuan</h5>
                                    <ol class="uk-text-meta">
                                        <li>Untuk eceran, Kain yang sudah dibeli, tidak dapat diretur atau dibatalkan
                                        </li>
                                        <li>Untuk Roll-an, tidak terima retur berupa kain yang sudah di-cutting</li>
                                        <li>Batas Maksimal retur 3 hari setelah penerimaan barang, S.JLn retur dari
                                            Customer terlampir</li>
                                    </ol>
                                </div>

                            </div>
                        </div>

                    </div>





                </div>
            </div>
        </div>
    </section>
    @push('script')
        <script>
            // function getFileData(myFile) {
            //     var file = myFile.files[0];
            //     var filename = file.name;
            //     $('#filename').text(filename);
            // }
            function getFileData() {
                const fileInput = document.getElementById('file');
                const fileNamesContainer = document.getElementById('filename');

                // Clear previous file names (if any)
                fileNamesContainer.innerHTML = '';

                // Get the selected files
                const files = fileInput.files;

                // Display each file name
                for (let i = 0; i < files.length; i++) {
                    const fileName = files[i].name;
                    const fileNameElement = document.createElement('p');
                    fileNameElement.textContent = fileName;
                    fileNamesContainer.appendChild(fileNameElement);
                }
            }
        </script>
    @endpush
</x-app-layout>
