<div id="modalAddressList" class="uk-flex-top" uk-modal>
    <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">

        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-flex uk-flex-between">
            <h5>Daftar Alamat</h5>
            <a href="#modalAddressAdd" uk-toggle><span uk-icon="icon: plus"></span> Tambah Alamat</a>
        </div>

        <ul class="uk-list uk-list-divider" id="list-address">
            @foreach ($address as $adr)
                <li>
                    <div class="uk-flex uk-flex-between">
                        <dl>
                            <dt>{{ $adr->name }}</dt>
                            <dd>{{ $adr->full_address }}</dd>
                            <div class="uk-margin-small-top">
                                <button data-alamat="{{ $adr->full_address }}" data-penerima="{{ $adr->name }}"
                                    data-addrid="{{ $adr->id }}"
                                    class="uk-button uk-button-small uk-button-primary uk-modal-close change-address"
                                    type="button" onclick="changeAddress(this)">Pilih alamat</button>
                            </div>
                        </dl>
                        <div>
                            <ul class="uk-iconnav">
                                <li><a onclick="editAddress(this)" data-addrid="{{ $adr->id }}"
                                        data-penerima="{{ $adr->name }}" data-category="{{ $adr->category }}"
                                        data-fulladdress="{{ $adr->full_address }}" uk-icon="icon: file-edit"></a></li>
                                <li><a onclick="deleteAddress(this)" data-addrid="{{ $adr->id }}"
                                        uk-icon="icon: trash"></a></li>
                            </ul>
                        </div>
                    </div>
                </li>
            @endforeach


        </ul>

    </div>
</div>
{{-- ADD ADDRESS MODAL --}}
<div id="modalAddressAdd" class="uk-flex-top" uk-modal>
    <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">

        <button class="uk-modal-close-default" type="button" uk-close></button>
        <h5>Tambah Alamat</h5>
        <form method="post" id="form-add-address">
            @csrf
            <div class="uk-margin">
                <label for="">Nama Penerima</label>
                <div class="uk-form-controls">
                    <input type="text" name="nama_penerima" id="nama_penerima" class="uk-input" required>
                </div>
            </div>
            <div class="uk-margin">
                <label for="">Kategori Alamat</label>
                <div class="uk-form-controls">
                    <select name="kategori_alamat" id="kategori_alamat" class="uk-select" required>
                        <option>Rumah</option>
                        <option>Kantor</option>
                    </select>
                </div>
            </div>
            <div class="uk-margin">
                <label for="">Alamat Lengkap</label>
                <div class="uk-form-controls">
                    <textarea name="alamat_lengkap" id="alamat_lengkap" rows="3" class="uk-textarea" required></textarea>
                </div>
            </div>

            <div class="uk-margin">
                <a href="#modalAddressList" class="uk-button uk-button-default" uk-toggle>Batal</a>
                <button type="submit" class="uk-button uk-button-primary">Simpan</button>
            </div>
        </form>


    </div>
</div>

{{-- EDIT ADDRESS MODAL --}}
<div id="modalAddressEdit" class="uk-flex-top" uk-modal>
    <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">

        <button class="uk-modal-close-default" type="button" uk-close></button>
        <h5>Edit Alamat</h5>
        <form method="post" id="form-edit-address">
            @csrf
            @method('PATCH')
            <div class="uk-margin">
                <label for="">Nama Penerima</label>
                <div class="uk-form-controls">
                    <input type="text" name="nama_penerima" id="edit_nama_penerima" class="uk-input" required>
                </div>
            </div>
            <div class="uk-margin">
                <label for="">Kategori Alamat</label>
                <div class="uk-form-controls">
                    <select name="kategori_alamat" id="edit_kategori_alamat" class="uk-select" required>
                        <option>Rumah</option>
                        <option>Kantor</option>
                    </select>
                </div>
            </div>
            <div class="uk-margin">
                <label for="">Alamat Lengkap</label>
                <div class="uk-form-controls">
                    <textarea name="alamat_lengkap" id="edit_alamat_lengkap" rows="3" class="uk-textarea" required></textarea>
                </div>
            </div>

            <div class="uk-margin">
                <a href="#modalAddressList" class="uk-button uk-button-default" uk-toggle>Batal</a>
                <button type="submit" class="uk-button uk-button-primary">Simpan</button>
            </div>
        </form>


    </div>
</div>
