
<x-app-layout>

    <section id="pageContent" class="uk-section" uk-height-viewport="offset-bottom: 20">
        <div class="uk-container">
            <div class="uk-margin-large uk-grid-large" uk-grid>
                @include('layouts.inc.sidebar')
                <!-- Contains uk-width-1-4@s. Don't screw up! -->
                <div class="uk-width-3-4@s">
                   
                    <div class="rz-detail-product">
                        <div uk-grid>
                            <div class="uk-width-2-5@s">
                                <h3><i class="ph-light ph-user-circle rz-icon"></i>Account</h3>
                            </div>
                            <div class="uk-width-3-5@s">
                                <ul class="uk-child-width-expand" uk-switcher uk-tab>
                                    <li><a href="#">Biodata</a></li>
                                    <li><a href="#">Alamat</a></li>
                                    <li><a href="#">Keamanan</a></li>
                                </ul>
    
                                <div class="uk-switcher uk-margin-large-bottom">
                                    <div>
                                        <table class="rz-table-vertical">
                                          <tr>
                                            <th>Nama</th>
                                            <td class="uk-table-shrink">:</td>
                                            <td>{{ $customer['nama'] }}</td>
                                          </tr>
                                          <tr>
                                            <th>No KTP</th>
                                            <td class="uk-table-shrink">:</td>
                                            <td>{{ $customer['no_ktp'] }}</td>
                                          </tr>
                                          <tr>
                                            <th>Tempat / Tanggal lahir</th>
                                            <td class="uk-table-shrink">:</td>
                                            <td>{{ $customer['pob'] }} / {{ \Carbon\Carbon::parse($customer['dob'])->locale('id')->translatedFormat('d F Y') }}</td>
                                          </tr>
                                          <tr>
                                            <th>Email</th>
                                            <td class="uk-table-shrink">:</td>
                                            <td>{{ $customer['email'] }}</td>
                                          </tr>
                                          <tr>
                                            <th>No. HP</th>
                                            <td class="uk-table-shrink">:</td>
                                            <td>{{ $customer['nohp'] }}</td>
                                          </tr>
                                          <tr>
                                            <th>Alamat</th>
                                            <td class="uk-table-shrink">:</td>
                                            <td>{{ $customer['alamat'] }}</td>
                                          </tr>
                                          <tr>
                                            <th></th>
                                            <td class="uk-table-shrink"></td>
                                            <td>
                                               <div>
                                                    <img src="https://i.pravatar.cc/150?img=52" alt="" class="uk-margin-top uk-border-circle">
                                                </div>
                                                <a href="" class="uk-button uk-button-small uk-button-default uk-margin">Pilih Foto</a>
                                                <div class="uk-text-small uk-text-meta">
                                                    Ukuran foto maks. 1 MB dengan format gambar JPG, PNG
                                                </div>
                                            </td>
                                          </tr>
                                          
    
                                        </table>
                                    </div>
                                    <div>
                                        <ul class="uk-list uk-list-divider">
                                            <li>
                                                <div class="uk-flex uk-flex-between" uk-grid>
                                                    <div class="uk-width-expand">
                                                        <dl>
                                                            <dt>Rumah</dt>
                                                            <dd>{{ $customer['alamat'] }}</dd>
                                                        </dl>                        
                                                    </div>
    
                                                    <div class="uk-width-auto">
                                                        <ul class="uk-iconnav">
                                                            <li><a href="#" uk-icon="icon: file-edit"></a></li>
                                                            <li><a href="#" uk-icon="icon: trash"></a></li>
                                                        </ul>
                                                    </div>                    
                                                </div>
                                            </li>
                                            <li>
                                                <div class="uk-flex uk-flex-between" uk-grid>
                                                    <div class="uk-width-expand">
                                                        <dl>
                                                            <dt>Kantor</dt>
                                                            <dd>{{ $customer['alamat_perusahaan'] }}</dd>
                                                        </dl>                        
                                                    </div>
    
                                                    <div class="uk-width-auto">
                                                        <ul class="uk-iconnav">
                                                            <li><a href="#" uk-icon="icon: file-edit"></a></li>
                                                            <li><a href="#" uk-icon="icon: trash"></a></li>
                                                        </ul>
                                                    </div>                    
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div>
                                        <span><i class="ph-light ph-shield-check uk-text-large rz-text-primary"></i></span>
                                        <p>Untuk keamanan, gunakan link konfirmasi akan dikirim ke emailmu yang terdaftar</p>
                                        <a href="" class="uk-button uk-button-primary">Konfirmasi</a>
                                    </div>
                                </div>
    
    
                                
                                
                            </div>
                        </div>
    
                    </div>
                    
    
                    
                    
                    
                </div>         
            </div>
        </div>
    </section>

</x-app-layout>

