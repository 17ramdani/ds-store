<footer id="homeFooter" class="uk-visible@m">
    <div class="uk-container">
        <div id="mainFooter" class="uk-light">
            <div class="uk-grid-small" uk-grid>
                <div class="uk-width-1-4@s">
                    <div class="uk-margin-medium">
                        <h5>Dunia Sandang</h5>
                        <ul class="uk-list uk-list-collapse">
                            <li><a href="https://duniasandang.com/tentang-kami/">Tentang Kami</a></li>
                            <li><a href="https://duniasandang.com/bahan-kain/">Bahan Kain</a></li>
                            <li><a href="https://amertasandang.com/pola-dan-aksesoris/">Pola dan Aksesoris</a></li>
                            <li><a href="https://amertasandang.com/custom-print/">Printing Sublime</a></li>
                            <li><a href="https://duniasandang.com/faq/">FAQ</a></li>
                        </ul>                  
                    </div>
                    <div class="uk-margin">
                        <h5>Follow Us</h5>
                        <ul class="uk-iconnav">
                            <li><a href="https://bit.ly/DuniaSandang" uk-icon="icon: whatsapp"></a></li>
                            <li><a href="https://instagram.com/duniasandangpratama" uk-icon="icon: instagram"></a></li>
                            <li><a href="https://www.facebook.com/CvDuniaSandang/" uk-icon="icon: facebook"></a></li>
                            <li><a href="https://twitter.com/duniasandang" uk-icon="icon: twitter"></a></li>
                            <li><a href="https://www.youtube.com/channel/UCMo4lqYNGqF-37nihMWsHOw" uk-icon="icon: youtube"></a></li>
                            <li><a href="https://www.tiktok.com/@duniasandang?" uk-icon="icon: tiktok"></a></li>
                        </ul>                  
                    </div>
                </div>
                <div class="uk-width-1-4@s">
                    <div class="uk-margin-large">
                        <h5>Produk Kami</h5>
                        <ul class="uk-list uk-list-collapse">
                            <li><a href="product-index.php">Cotton Single Knit</a></li>
                            <li><a href="product-index.php">Misty Single Knit</a></li>
                            <li><a href="product-index.php">Lacoste</a></li>
                            <li><a href="product-index.php">Fleece</a></li>
                            <li><a href="product-index.php">Babyterry</a></li>
                            <li><a href="product-index.php">Dryfit</a></li>
                            <li><a href="product-index.php">Polyester</a></li>
                            <li><a href="product-index.php">Merino</a></li>
                            <li><a href="product-index.php">Woven</a></li>
                        </ul>                  
                    </div>
                </div>
                <div class="uk-width-1-4@s">
                    <div class="uk-margin-large">
                        <h5>Account</h5>
                        <ul class="uk-list uk-list-collapse">
                            <li><a href="pesanan-index.php">Daftar Pesanan</a></li>
                            <li><a href="profil-detail.php">Keanggotaan</a></li>
                            <li><a href="complaint-index.php">Keluhan Pelanggan</a></li>
                            <li><a href="wishlist.php">Wishlist</a></li>
                        </ul>                  
                    </div>
                </div>
                <div class="uk-width-1-4@s">
                    <div class="uk-margin-large">
                        <div class="uk-margin-small-bottom"><img src="{{ asset('assets/img/logo-old-white.png') }}" alt="" class="rz-logo-medium"></div>
                        <div class="uk-text-bold uk-text-small">PT. DUNIA SANDANG PRATAMA</div>
                        <address class="uk-margin-remove uk-text-small">
                            Jl. Terusan Pasirkoja No.250, Babakan, Kec. Babakan Ciparay, Kota Bandung, Jawa Barat 40222
                        </address>             
                    </div>
                </div>
                                
                
            </div>
            <div class="uk-text-small uk-text-meta uk-margin-top">
                &copy; <?php echo date('Y');?> PT. Dunia Sandang Pratama
            </div>

                      
        </div>
    </div>

</footer>


<div class="uk-hidden@m rz-nav-bottom">
	<div class="uk-child-width-1-3" uk-grid>
		<div class="uk-text-center">
			<a href="#">
                <i class="ph-fill ph-smiley"></i>
                <span class="rz-tab-label">Keluhan</span>
			</a>
		</div>
		<div class="uk-text-center">
			<a href="/shop">
                <i class="ph-fill ph-basket"></i>
                <span class="rz-tab-label">Belanja</span>
			</a>
		</div>
	
		<div class="uk-text-center">
			<a href="https://api.whatsapp.com/send/?phone=6281222776523&text&type=phone_number&app_absent=0">
			<i class="ph-fill ph-whatsapp-logo"></i>
			<span class="rz-tab-label">CS</span>                    
			</a>
		</div>
	</div>

</div>

<!-- OFFCANVAS -->
<div id="offcanvas-nav" data-uk-offcanvas="flip: true; overlay: true">
    <div class="uk-offcanvas-bar uk-offcanvas-bar-animation uk-offcanvas-slide">
        <button class="uk-offcanvas-close uk-close uk-icon" type="button" data-uk-close></button>
            <div class="uk-margin-top uk-grid-small uk-flex-middle" uk-grid>
                
                @if (Auth::check())
                <div class="uk-width-auto">
                    <h2><i class="ph-fill ph-user-circle"></i></h2>
                </div>
                    <div class="uk-width-expand uk-text-bold">
                        <a href="/account-detail" style="text-decoration:none">{{ auth()->user()->name }}</a>
                    </div>
                @else
                    <div class="uk-width-auto">
                        <h3><i class="ph-fill ph-sign-in"></i></h3>
                    </div>
                    <div class="uk-width-expand uk-text-bold">
                        <a href="{{ route('login') }}">Login</a>
                    </div>
                @endif
            </div>
            <ul id="rz-mobile-nav" class="uk-child-width-1-2 uk-grid-small" uk-grid>
                <li>
                    <a href="/"><i class="ph-light ph-house-line"></i>Beranda</a>
                </li>
                <li>
                    <a href="/shop"><i class="ph-light ph-book-open-text"></i>Katalog</a>
                </li>
                <li>
                    <a href="/dashboard"><i class="ph-light ph-basket"></i>Pesanan</a>
                </li>
                <li>
                    <a href="/index-whitelist"><i class="ph-light ph-heart"></i>Wishlist</a>
                </li>
                <li>
                    <a href="https://bit.ly/DuniaSandang"><i class="ph-light ph-chats"></i>Layanan</a>
                </li>
                <li>
                    <a href="#"><i class="ph-light ph-gear"></i>Pengaturan</a>
                </li>
                
                
            </ul>
            <div class="uk-position-bottom-right uk-position-small">
                @if (Auth::check())
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="uk-button uk-button-default">Logout</button>
                </form>
                @endif
            </div>

    </div>
</div>
<!-- /OFFCANVAS -->

<div id="modalCart" class="uk-modal-full" uk-modal>
    <div class="uk-modal-dialog" uk-height-viewport>
        <button class="uk-modal-close-full uk-close-large" type="button" uk-close></button>
        <div class="uk-padding">
            <div class="rz-checkout-container">
                <h4>Cart</h4>

                <article id="cart-mobile">

                </article>
                <article class="rz-values-horizontal uk-text-small" id="footer-cart-mobile">
                    
                </article>

                <div class="uk-margin-top uk-align-right@s">
                    <a href="/cart" class="uk-button uk-button-secondary">Lihat Keranjang</a>
                </div>                
            </div>
        </div>

    </div>
</div>

@push('script')
    <script>
        getDataForCartMobile();

        function getDataForCartMobile() {
            $.ajax({
                url: '/get-cart-mobile',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    var subTotall = 0;
                    var totalHarga = 0;
                    if (Array.isArray(response)) {
                        response.forEach(function(item) {
                            console.log(item)
                            var bagian = item.bagian;
                            if(bagian == "accessories"){
                                var harga_bdy = item.harga_body;
                                var harga_asc = item.harga_asc;
                                var harga   = parseInt(harga_bdy) + parseInt(harga_asc)
                            }else{
                                var harga   = item.harga_body;
                            }
                            var subTotal = item.qty * harga;
                            var html = `
                                <article id="cart-mobile">
                                    <div class="rz-checkout-item">
                                    <dl>
                                        <dt>${item.nama}</dt>
                                        <dd>${item.nama} - ${item.qty} ${item.satuan}</dd>
                                    </dl>
                                    <div class="uk-flex uk-flex-between">
                                        <div class="uk-text-small">${item.qty} ${item.satuan}</div>
                                        <div class="uk-text-bold">Rp. ${subTotal.toLocaleString()}</div>
                                    </div>
                                    </div>
                                </article>
                                `;
                            $("#cart-mobile").append(html);

                            subTotall += subTotal;
                            // $('#sub-total-mobile').text('Rp .' + subTotall.toLocaleString());
                            // $('#total-mobile-cart').text('Rp .' + subTotall.toLocaleString());
                        });
                        var footercartmobile = `
                                <dl>
                                    <dt>Subtotal</dt>
                                    <dd>${subTotall.toLocaleString()}</dd>
                                </dl>
                                <dl>
                                    <dt>Diskon</dt>
                                    <dd>Rp. 0</dd>
                                </dl>
                                <dl>
                                    <dt>Ongkos Kirim</dt>
                                    <dd></dd>
                                </dl>
                                <dl>
                                    <dt>TOTAL</dt>
                                    <dd class="uk-text-bold">${subTotall.toLocaleString()}</dd>
                                </dl>
                                `
                                $("#footer-cart-mobile").append(footercartmobile);
                    } else {
                        console.error("Response is not an array:", response);
                    }
                },
                error: function(xhr, status, error) {
                console.error(xhr.responseText);
                }
            });
            }

    </script>
@endpush