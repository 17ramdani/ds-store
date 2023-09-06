<x-guest-new-layout>
    <main class="uk-margin-medium-bottom">
        <div class="uk-container">
            @include('layouts.inc.slider-new')
            <div id="homeProducts">
                <div class="uk-child-width-1-3@m uk-child-width-1-2 uk-grid-small" uk-grid>
                    @foreach ($data as $jk)
                    <div>
                        <div class="uk-inline">
                            <a href="/product">
                                {{-- <img src="{{ asset('assets/img/guest/kain-cotton.jpg')}}" alt=""> --}}
                                <img src="{{ $jk->gambar }}" alt="">
                                <div class="rz-overlay uk-position-cover"></div>
                                <h5>
                                    {{ $jk->nama }}
                                </h5>                            
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>            
            </div>
            
            <div id="homeFeature" class="uk-section">
                <div class="uk-child-width-1-4" uk-grid>
                    <div>
                        <div class="uk-grid-collapse uk-flex-middle" uk-grid>
                            <div class="uk-width-1-4@m">
                                <div class="rz-icon-padding">
                                <img src="{{ asset('assets/img/guest/icon-money.svg')}}" alt="">    
                                </div>
                                
                            </div>
                            <div class="uk-width-3-4@m">
                                <h5>Harga Terjangkau</h5>
                            </div>
                            
                        </div>
                    </div>
                    <div>
                        <div class="uk-grid-collapse uk-flex-middle" uk-grid>
                            <div class="uk-width-1-4@m">
                                <div class="rz-icon-padding">
                                <img src="{{ asset('assets/img/guest/icon-colors.svg')}}" alt="">    
                                </div>
                                
                            </div>
                            <div class="uk-width-3-4@m">
                                <h5>Warna Lengkap</h5>
                            </div>
                            
                        </div>
                    </div>
                    <div>
                        <div class="uk-grid-collapse uk-flex-middle" uk-grid>
                            <div class="uk-width-1-4@m">
                                <div class="rz-icon-padding">
                                <img src="{{ asset('assets/img/guest/icon-medal.svg')}}" alt="">    
                                </div>
                                
                            </div>
                            <div class="uk-width-3-4@m">
                                <h5>Kualitas Terbaik</h5>
                            </div>
                            
                        </div>
                    </div>
                    <div>
                        <div class="uk-grid-collapse uk-flex-middle" uk-grid>
                            <div class="uk-width-1-4@m">
                                <div class="rz-icon-padding">
                                <img src="{{ asset('assets/img/guest/icon-shield.svg')}}" alt="">    
                                </div>
                                
                            </div>
                            <div class="uk-width-3-4@m">
                                <h5>Garansi Retur</h5>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="homeOrder" class="uk-child-width-1-2@s" uk-grid>
                <div>
                    <div class="rz-card-order">
                        <h3>Fresh Order</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Totam, quis.</p>
                        <div>
                            <a href="/pesanan-add-fo" class="uk-button uk-button-primary">Order</a>    
                        </div>
                        
                    </div>
                </div>
                <div>
                    <div class="rz-card-order">
                        <h3>Development</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Totam, quis.</p>
                        <div>
                            <a href="/pesanan-add-dev" class="uk-button uk-button-primary">Order</a>    
                        </div>
                        
                    </div>
                </div>
            </div>
            
            <div id="homeOffer">
                <div class="uk-flex-bottom" uk-grid>
                    <div class="uk-width-1-2@s">
                        <span class="rz-subtext">Special Offer</span>
                        <h3>Dapatkan Pembiayaan Fleksibel untuk Bisnis Anda</h3>
                        <p>Untuk kamu yang mau membuka usaha pada bidang textile tetapi masih bingung dengan modal yang harus dikeluarkan, jangan khawatir karena Dunia Sandang memberikan solusi dengan program Buyer Financing.</p>
                        <a href="" class="uk-button uk-button-secondary">Info Lengkap</a>
                    </div>
                    <div class="uk-width-1-2@s">
                        <div uk-grid>
                            <div class="uk-width-1-3@s">
                                
                            </div>
                            <div class="uk-width-2-3@s">
                                <img src="{{ asset('assets/img/guest/offer-financing.png')}}" alt="">
                            </div>
                        </div>
                    </div>           
                </div>
    
            </div>
            
            <div id="homeGimmick" class="uk-child-width-1-2@s" uk-grid>
    
                <div class="uk-flex-last@s">
                    <span class="uk-label uk-label-warning uk-text-uppercase">Koleksi Baru</span>
                    <h3>Ballotelly Fabric</h3>
                    <p>Ayo kenali jenis kain ballotelly, kain ini memiliki karakteristik yang begitu khas yaitu memiliki serat unik berbentuk kotak kecil dengan permukaan kain yang licin. Kain Ballotelly pun memiliki serat yang padat dan rapat sehingga tidak khawatir kain ini menerawang.</p>
                    <a href="" class="uk-button uk-button-secondary">Info Lengkap</a>
                </div>
                <div>
                    <img src="{{ asset('assets/img/guest/kain-balotelly.png')}}" alt="">
                </div>
            </div>
            
        </div>
    </main>

</x-guest-new-layout>