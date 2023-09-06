<div id="pagePromoLine" uk-alert>
    <div class="uk-container uk-text-center">

        <a class="uk-alert-close" uk-close></a>
        <strong>Turun harga!</strong> Cotton Combed &amp; Carded Rp. 2,000/kg. <a href="https://wa.me/6281222776523">Info
            lengkap</a>

    </div>
</div>

<section id="navbarPrimary">

    <div class="rz-navbar" uk-sticky="cls-active: rz-bg-white; top: 300; animation: uk-animation-slide-top">
        <div class="uk-container">
            <nav class="" uk-navbar>
                <div class="uk-navbar-left">
                    <a href="{{ route('index') }}"><img src="{{ asset('assets/img/guest/logo-temp-dark4.png') }}"
                            alt="" class="rz-logo-medium uk-margin-right"></a>
                    <ul class="uk-navbar-nav uk-visible@s">
                        <li>
                            <a href="{{ route('shop') }}">Belanja</a>
                        </li>
                        <li>
                            <a href="#">Promo</a>
                        </li>
                    </ul>
                </div>
                <div class="uk-navbar-item uk-visible@s">
                    <form class="uk-search uk-search-navbar">
                        <span uk-search-icon></span>
                        <input class="uk-search-input" type="search" placeholder="Search" aria-label="Search">
                    </form>

                </div>
                <div class="uk-navbar-right">
                    <ul class="uk-navbar-nav uk-visible@m">
                        <li>
                            <a href="/dashboard"><i class="ph-light ph-basket uk-margin-left"></i>Pesanan</a>
                        </li>
                        @if (Auth::check())
                            <li>
                                <a href="#"><i class="ph-light ph-user-circle uk-margin-left"></i>Account</a>
                                <div uk-dropdown="pos: bottom-right; offset: -20">
                                    <div id="dropdownUser">
                                        <ul>
                                            <li>
                                                <div class="uk-grid-small uk-flex-middle" uk-grid>
                                                    <div class="uk-width-auto">
                                                        <h2><i class="ph-fill ph-user-circle"></i></h2>
                                                    </div>
                                                    <div class="uk-width-expand uk-text-bold">
                                                        <a href="/account-detail"
                                                            style="text-decoration:none">{{ auth()->user()->name }}</a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="uk-flex uk-flex-between">
                                                    <div>
                                                        <a href="/dashboard">
                                                            <dl>
                                                                <dt>{{ app('App\Http\Controllers\Member\DashboardController')->getUserOrders() }}
                                                                </dt>
                                                                <dd>Orders</dd>
                                                            </dl>
                                                        </a>
                                                    </div>
                                                    <div>
                                                        <a href="/index-whitelist">
                                                            <dl>
                                                                <dt>{{ count(app('App\Http\Controllers\Whitelist\WhitelistController')->getWishlist()) }}
                                                                </dt>
                                                                <dd>Wishlist</dd>
                                                            </dl>
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="uk-flex uk-flex-between">
                                                    <div>
                                                        <a href="deposit-index.php">
                                                            <dl>
                                                                <dt>Rp. 0</dt>
                                                                <dd>Deposit</dd>
                                                            </dl>
                                                        </a>
                                                    </div>
                                                    <div>

                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="uk-flex uk-flex-between">
                                                    <div>
                                                        <a href="">
                                                            <dl>
                                                                <dt>{{ app('App\Http\Controllers\Member\DashboardController')->getUserPoints() }}
                                                                </dt>
                                                                <dd>Points</dd>
                                                            </dl>
                                                        </a>
                                                    </div>
                                                    <div>

                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button
                                                class="uk-button uk-button-small uk-button-default uk-width-1-1">Logout</button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('login') }}"><i
                                        class="ph-light ph-user-circle uk-margin-left"></i>Account</a>
                                <div uk-dropdown="pos: bottom-right; offset: -20">
                                    <div id="dropdownUser">
                                        <div class="uk-margin uk-text-center">
                                            <a href="/index-whitelist" class="uk-button"><i
                                                    class="ph-fill ph-heart uk-margin-small-right"></i>Wishlist</a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endif
                        <li>
                            <a href="#" class="cart-icon-container"><i
                                    class="ph-light ph-shopping-cart uk-margin-left"></i>
                                <span id="notificationBadge" class="notification-badge" style="display: none"></span>
                                Cart
                            </a>
                            <div uk-dropdown="pos: bottom-right; offset: -20">
                                <div id="dropdownCart" class="uk-text-right">

                                    <dl>
                                        <dt id="nav-qty-total"></dt>
                                        <dd>Total Item</dd>
                                    </dl>

                                    <dl>
                                        <dt id="totalHarga-nav"></dt>
                                        <dd>Total Amount</dd>
                                    </dl>

                                    <a href="/cart" class="uk-button uk-button-secondary uk-width-1-1">View Cart</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <a href="#modalCart" class="uk-hidden@m" uk-toggle>
                        <span class="uk-margin-small-right" uk-icon="cart"></span>
                        <span class="notification-badge" id="notificationBadgeMobile" style="display: none"></span>
                    </a>
                    <a class="uk-navbar-toggle uk-navbar-item uk-hidden@m" data-uk-toggle data-uk-navbar-toggle-icon
                        href="#offcanvas-nav"></a>
                </div>
            </nav>
        </div>
    </div>

</section>

@push('script')
    <script>
        // Fungsi untuk memperbarui nilai notificationBadge pada elemen DOM
        function updateNotificationBadge() {
            $.ajax({
                url: '/get-notification-badge',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    console.log(data)
                    const notificationBadge = $('#notificationBadge');
                    const notificationBadgeMobile = $('#notificationBadgeMobile');

                    const totalQty = $('#nav-qty-total');
                    const totalHarga = $('#totalHarga-nav');

                    if (data.notifbadge) {
                        notificationBadge.css('display', 'inline-block');
                        notificationBadge.text(data.notifbadge);
                        notificationBadgeMobile.css('display', 'inline-block');
                        notificationBadgeMobile.text(data.notifbadge);

                        // console.log(totalHarga)

                        totalQty.text(data.total_qty + 'Kg');
                        totalHarga.text('Rp .' + data.total_harga.toLocaleString());
                    } else {
                        notificationBadge.css('display', 'none');
                        notificationBadgeMobile.css('display', 'none');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
        updateNotificationBadge();
    </script>
@endpush
