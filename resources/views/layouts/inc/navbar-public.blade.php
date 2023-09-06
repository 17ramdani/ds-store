<section id="navbarPrimary" class="uk-light">
    <!-- NAV -->
    <div class="rz-navbar rz-bg-primary" uk-sticky="top: 300; animation: uk-animation-slide-top">
        <div class="uk-container">
            <nav class="" uk-navbar>
                <div class="uk-navbar-left">
                    <div><a href="{{ route('index') }}"><img src="{{ asset('assets/img/logo.png') }}" alt=""
                                class="rz-logo-medium"></a></div>
                </div>
                <div class="uk-navbar-right">
                    <ul class="uk-navbar-nav uk-visible@m">
                        <li>
                            <a href="{{ url('/login') }}"><span uk-icon="user"></span>&nbsp; Login</a>
                        </li>
                    </ul>
                    <a href="{{ route('login') }}" class="uk-hidden@m"><i class="ph-user-circle-fill ph-xl"></i></a>
                    <a class="uk-navbar-toggle uk-navbar-item uk-hidden@m" data-uk-toggle data-uk-navbar-toggle-icon
                        href="#offcanvas-nav"></a>
                </div>
            </nav>
        </div>
    </div>
    <!-- /NAV -->
</section>
