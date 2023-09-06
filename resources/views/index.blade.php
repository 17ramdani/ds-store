<x-app-layout>
    <section id="navbarSecondary" class="uk-flex uk-flex-middle uk-flex-left">
        <div class="uk-width-1-1">
            <div class="uk-container">
                <div class="uk-flex uk-flex-between uk-flex-middle">
                    <div>
                        <h2 class="rz-text-pagetitle uk-margin-remove">Welcome</h2>
                    </div>
                    <div>
                        <a href="{{ route('register') }}" class="uk-button uk-button-primary uk-button-small uk-border-rounded">Daftar</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <main class="uk-margin-medium">
        <div class="uk-container uk-container-small">
            <div class="rz-panel">
                @include('layouts.inc.slider-short')
                <div class="uk-margin">
                    <div id="sliderProduct" class="uk-position-relative uk-visible-toggle" tabindex="-1" uk-slider>

                        <ul class="uk-slider-items uk-child-width-1-2 uk-child-width-1-5@m uk-grid-small uk-grid">
                            @foreach ($data as $jk)
                            <li>
                                <div class="uk-panel">
                                    <img src="{{ $jk->gambar }}" width="400" height="600" alt="">
                                    <div class="uk-panel">
                                        <h5>{{ $jk->nama }}</h5>
                                        <p>{{ $jk->keterangan }}</p>
                                        @if (Auth::check())
                                        <a href="{{ $jk->katalog }}" class="uk-button uk-button-default uk-button-small">Katalog</a>
                                        @else
                                        <a href="{{ route('login', ['url' => $jk->katalog]) }}" class="uk-button uk-button-default uk-button-small">Katalog</a>
                                        @endif
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>

                        <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
                        <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slider-item="next"></a>

                    </div>
                </div>

            </div>
        </div>
    </main>
</x-app-layout>
