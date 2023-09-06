<footer class="uk-padding uk-background-secondary uk-light">
    <div class="uk-container uk-text-center">
        <span class="uk-text-small uk-text-meta">
            &copy; {{ date('Y') }} PT. Dunia Sandang Pratama
        </span>
    </div>
</footer>


<div class="uk-background-secondary uk-hidden@m rz-nav-bottom">
    <div class="uk-child-width-1-2" uk-grid>
        <div class="uk-text-center">
            <a href="{{ route('complaint.index') }}">
                <i class="ph-smiley-fill ph-2x"></i>
                <span class="rz-tab-label">Keluhan Pelanggan</span>
            </a>
        </div>

        <div class="uk-text-center">
            <a href="https://api.whatsapp.com/send/?phone=6281222776523&text&type=phone_number&app_absent=0">
                <i class="ph-chat-circle-text-fill ph-2x"></i>
                <span class="rz-tab-label">Customer Service</span>
            </a>
        </div>
    </div>
    <div class="rz-plus-button">
        <div>
            <a href="{{ route('pesanan.add') }}" class="uk-flex uk-flex-center uk-flex-middle">
                <div>
                    <i class="ph-plus-fill"></i>

                </div>
            </a>
        </div>
    </div>
</div>

<!-- OFFCANVAS -->
<div id="offcanvas-nav" data-uk-offcanvas="flip: true; overlay: false">
    <div class="uk-offcanvas-bar uk-offcanvas-bar-animation uk-offcanvas-slide">
        <button class="uk-offcanvas-close uk-close uk-icon" type="button" data-uk-close></button>

        @if (Auth::check())
        <ul class="" uk-nav>
            <li><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="uk-parent">
                <a href="#">Pesanan <span uk-nav-parent-icon></span></a>
                <ul class="uk-nav-sub">
                    <li><a href="{{ route('pesanan.add') }}">Buat Baru</a></li>
                    <li><a href="{{ route('pesanan.index') }}">History</a></li>
                </ul>
            </li>
            <li class="uk-parent">
                <a href="{{ route('membership.add') }}">Membership <span uk-nav-parent-icon></span></a>
                <ul class="uk-nav-sub">
                    {{-- <li><a href="{{ route('financing.add') }}">Daftar Buyer Financing</a></li> --}}
                    <li><a href="#">Cicilan</a></li>
                </ul>
            </li>
            <li><a href="{{ route('tukar.index') }}">Point Reward</a></li>
            <li class="uk-parent">
                <a href="#">Pengaturan <span uk-nav-parent-icon></span></a>
                <ul class="uk-nav-sub">
                    <li><a href="{{ route('profil.index') }}">Profil</a></li>
                    <li><a href="#">Email &amp; Password</a></li>
                </ul>
            </li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            </li>
        </ul>
        @else
        <ul class="" uk-nav>
            <li class="nav-item">
                <a href="{{ route('login') }}">Login</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('register') }}">Daftar</a>
            </li>
        </ul>
        @endif

    </div>
</div>
<!-- /OFFCANVAS -->
