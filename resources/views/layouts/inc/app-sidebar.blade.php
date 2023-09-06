<div class="uk-width-1-4@s">
    <ul id="pageSidebar" class="uk-nav-default uk-visible@s" uk-nav>
        @foreach ($data as $jk)
            <li class="uk-parent">
                <a class="show-list" id="{{ $jk->id }}">{{ $jk->nama }}<span uk-nav-parent-icon></span></a>
                <ul class="uk-nav-sub" id="tipe_kain{{ $jk->id }}">
                    @foreach ($jk->tipe_kain as $kain)
                        <li>
                            {{-- <a href="{{ route('shop.product', ['id' => $jk->id]) }}/?category-kain={{ Str::slug($jk->nama) }}&kain={{ $kain->slug }}" class="tab-link" data-id="{{ $jk->id }}-{{ $kain->nama }}">{{ $kain->nama }}</a> --}}
                            <a href="{{ route('shop.product', ['id' => $jk->id]) }}/?category-kain={{ $kain->slug }}"
                                class="tab-link">{{ $kain->nama }}</a>
                        </li>
                    @endforeach
                </ul>
            </li>
        @endforeach
        {{-- <li><a href="/acessories">Acsessories</a></li> --}}

        <li><a href="/pesanan-add-fo">Fresh Order</a></li>
        <li><a href="/pesanan-add-dev">Development</a></li>
    </ul>

</div>
