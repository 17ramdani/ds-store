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
            <div uk-grid>
                <div class="uk-width-1-3@s">
                    <div class="rz-panel">
                        <div>Nomor Pesanan</div>
                        <div class="uk-text-large">{{ $pesanan[0]->nomor }}</div>

                    </div>
                </div>
                <div class="uk-width-2-3@s">
                    <div class="rz-panel">
                        <div class="uk-margin-large">
                            <form class="uk-form-stacked" action="/complaint" method="POST">
                                @csrf
                                <div class="uk-margin">
                                    <label class="uk-form-label">Jenis Keluhan</label>
                                    <div class="uk-form-controls">
                                        <select class="uk-select" name="jenis_keluhan">
                                            <option value="1">Kualitas Pesanan</option>
                                            <option value="2">Kuantitas Pesanan</option>
                                            <option value="3">Lainnya</option>
                                        </select>
                                        <input type="hidden" name="customer_id" value="{{ $pesanan[0]->customer_id }}">
                                        <input type="hidden" name="cat_customer"
                                            value="{{ $pesanan[0]->customer->costumer_category_id }}">
                                        <input type="hidden" name="no_pesanan" value="{{ $pesanan[0]->nomor }}">
                                        <input type="hidden" name="status_pesanan"
                                            value="{{ $pesanan[0]->status_pesanan_id }}">
                                    </div>
                                </div>

                                <div class="uk-margin">
                                    <label class="uk-form-label">Deskrpsi Keluhan</label>
                                    <div class="uk-form-controls">
                                        <textarea name="desc_keluhan" id="" cols="30" rows="10" class="uk-textarea"></textarea>
                                    </div>
                                </div>
                                <div>
                                    <button type="submit"
                                        class="uk-button uk-button-primary uk-border-rounded">Laporkan
                                        Keluhan</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</x-app-layout>
