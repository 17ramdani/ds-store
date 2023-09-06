                        <li><a href="{{ url('/dashboard') }}">Beranda</a></li>
                        <li class="uk-parent">
                            <a href="{{ route('pesanan.index') }}">Pesanan</a>
                            <div class="uk-navbar-dropdown">
                                <ul class="uk-nav uk-navbar-dropdown-nav">
                                    <li><a href="{{ route('pesanan.add') }}">Buat Baru</a></li>
                                    <li><a href="{{ route('pesanan.index') }}">History</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="uk-parent">
                            <a href="#">Membership</a>
                            <div class="uk-navbar-dropdown">
                                <ul class="uk-nav uk-navbar-dropdown-nav">
                                    <li><a href="{{ route('membership.add') }}">Daftar
                                            Membership</a></li>
                                    {{-- <li><a href="{{ route('financing.add') }}">Daftar Buyer Financing</a></li> --}}
                                    <li><a href="#">Cicilan</a></li>
                                </ul>
                            </div>
                        </li>
                        <li><a href="{{ route('tukar.index') }}">Point Reward</a></li>
                        <li><a href="{{ route('complaint.index') }}">Keluhan</a></li>
                        <li class="uk-parent">
                            <a href="">Pengaturan</a>
                            <div class="uk-navbar-dropdown">
                                <ul class="uk-nav uk-navbar-dropdown-nav">
                                    <li><a href="{{ route('profil.index') }}">Profil</a></li>
                                    <li><a href="">Email &amp; Password</a></li>
                                </ul>
                            </div>
                        </li>
