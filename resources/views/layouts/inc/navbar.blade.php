<section id="navbarPrimary" class="uk-light">

    <div class="rz-navbar rz-bg-primary" uk-sticky="top: 300; animation: uk-animation-slide-top">
        <div class="uk-container">
            <nav class="" uk-navbar>
                <div class="uk-navbar-left">
                    <div><a href="index.php"><img src="{{ asset('assets/img/admin/logo_toko.png') }}" alt="logo" class="rz-logo-medium" style="width: 100px"></a></div>
                </div>
                <div class="uk-navbar-center">
                    <ul class="uk-navbar-nav uk-visible@m">
                        @include('layouts.inc.menu')
                    </ul>

                </div>
                <div class="uk-navbar-right">
                    <ul class="uk-navbar-nav uk-visible@m">
                        <li>
                            <a href="#"><span uk-icon="user"></span>&nbsp; {{ auth()->user()->name }}</a>
                            <div class="uk-navbar-dropdown">
                                <ul class="uk-nav uk-navbar-dropdown-nav">
                                    <li><a href="{{route('profil.index')}}">Profil</a></li>
                                    <li><a onclick="logout()">Logout</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                    <a href="#modalCart" class="uk-hidden@m uk-button" uk-toggle>
                        <span class="uk-margin-small-right" uk-icon="cart"></span>
                        <small style="margin-left:-15px !important" id="label_keranjang_count_nav" class="uk-badge">0</small>
                    </a>
                    <a class="uk-navbar-toggle uk-navbar-item uk-hidden@m" data-uk-toggle data-uk-navbar-toggle-icon href="#offcanvas-nav"></a>

                </div>
            </nav>
        </div>
    </div>

</section>
