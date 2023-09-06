@include('layouts.app-public');
{{-- <section id="navbarPrimary" class="uk-light">
        <!-- NAV -->
        <div class="rz-navbar rz-bg-primary" uk-sticky="top: 300; animation: uk-animation-slide-top">
            <div class="uk-container">
                <nav class="" uk-navbar>
                    <div class="uk-navbar-left">
                        <div><a href="index.php"><img src="img/logo.png" alt="" class="rz-logo-medium"></a></div>
                    </div>
                    <div class="uk-navbar-right">
                        <ul class="uk-navbar-nav uk-visible@m">
                            <li>
                                <a href="login.php"><span uk-icon="user"></span>&nbsp; Login</a>
                            </li>
                        </ul>
                        <a href="login.php" class="uk-hidden@m"><i class="ph-user-circle-fill ph-xl"></i></a>
                         <a class="uk-navbar-toggle uk-navbar-item uk-hidden@m" data-uk-toggle data-uk-navbar-toggle-icon href="#offcanvas-nav"></a>
                    </div>
                </nav>
            </div>
        </div>
        <!-- /NAV -->
    </section> --}}

<section id="navbarSecondary" class="uk-flex uk-flex-middle uk-flex-left">
    <div class="uk-width-1-1">
        <div class="uk-container">
            <div class="uk-flex uk-flex-between uk-flex-middle">
                <div>
                    <h2 class="rz-text-pagetitle uk-margin-remove">Welcome</h2>
                </div>
                <div>
                    <a href="membership-add.php" class="uk-button uk-button-primary uk-button-small uk-border-rounded">Daftar</a>
                </div>
            </div>
        </div>
    </div>
</section>


<main class="uk-margin-medium">
    <div class="uk-container uk-container-small">
        <div class="rz-panel">

            <div class="uk-child-width-1-2@s" uk-grid>
                <div>
                    <form>
                        <h3>Login</h3>

                        <div class="uk-margin">
                            <input class="uk-input" type="text" placeholder="Member ID">
                        </div>

                        <div class="uk-margin">
                            <input class="uk-input" type="password" placeholder="Password">
                        </div>


                        <div class="uk-margin">
                            <a href="{{url ('dashboard') }}" class="uk-button uk-button-primary uk-border-rounded">Login</a>
                        </div>

                    </form>
                </div>
                <div>
                    <img src="https://duniasandang.com/wp-content/uploads/2022/06/kartu.png" alt="" class="uk-border-rounded">
                </div>
            </div>

        </div>
    </div>
</main>
@include('layouts.inc.footer')
