<x-app-layout>
    <section id="pageContent" class="uk-section" uk-height-viewport="offset-bottom: 20">
        <div class="uk-container">
            <div class="uk-margin-large uk-grid-large" uk-grid>
                @include('layouts.inc.sidebar')
                <!-- Contains uk-width-1-4@s. Don't screw up! -->
                <div class="uk-width-3-4@s">

                    <div class="rz-detail-order">
                        <h3><i class="ph-light ph-chats rz-icon"></i>Komplain</h3>


                        <x-alert />
                        <div class="uk-margin-medium-top" uk-grid>
                            <div class="uk-width-1-2@s">
                                <div class="rz-order-container uk-margin-medium">
                                    <h5>No. Sales Order</h5>
                                    <div class="uk-text-bold uk-text-large">
                                        {{ $pesanan->nomor }}
                                    </div>


                                </div>

                            </div>
                            <div class="uk-width-1-2@s">
                                <div class="rz-order-container">
                                    <h5>Pengajuan Komplain</h5>

                                    <form class="uk-form-stacked" action="{{ route('komplain.store', $pesanan->id) }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="uk-margin">
                                            <label class="uk-form-label">Deskripsi Keluhan *</label>
                                            <div class="uk-form-controls">
                                                <textarea name="deskripsi" id="deskripsi" cols="30" rows="10" class="uk-textarea" required>{{ $pesanan->komplain->keterangan ?? '' }}</textarea>
                                            </div>
                                        </div>
                                        <div class="uk-margin">
                                            <label class="uk-form-label">Foto Barang Pesanan</label>
                                            <div class="js-upload" uk-form-custom>
                                                <input type="file" name="file" id="file"
                                                    accept=".png,.jpg,.jpeg" onchange="getFileData()">
                                                <button class="uk-button uk-button-default" type="button"
                                                    tabindex="-1">Select</button>
                                            </div>
                                            <span class="uk-margin" id="filename"></span>
                                            <div class="uk-margin" id="image-preview">
                                                @if (isset($pesanan->komplain->photos))
                                                    <img src="{{ $pesanan->komplain->photos }}"
                                                        class="uk-object-cover uk-margin" width="200" height="200"
                                                        style="aspect-ratio: 1 / 1" alt="phoro">
                                                @endif
                                            </div>
                                        </div>

                                        <div class="uk-margin-large-top uk-text-right">
                                            <button type="submit" class="uk-button uk-button-primary">Submit</button>
                                        </div>
                                    </form>
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
