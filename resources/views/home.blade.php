<x-app-layout>
    <main class="uk-margin-medium-bottom">
        <div class="uk-container">
            @include('layouts.inc.slider-new')
            <div id="homeProducts">
                <div class="uk-child-width-1-3@m uk-child-width-1-2 uk-grid-small" uk-grid>
                    @foreach ($data as $jk)
                        <div>
                            <div class="uk-inline">

                                <a href="{{ route('shop.jenis', $jk->id) . '?category-kain=' . Str::slug($jk->nama) }}">
                                    <img src="{{ $jk->gambar }}" alt="{{ $jk->nama }}">
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
                                    <img src="{{ asset('assets/img/guest/icon-money.svg') }}" alt="">
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
                                    <img src="{{ asset('assets/img/guest/icon-colors.svg') }}" alt="">
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
                                    <img src="{{ asset('assets/img/guest/icon-medal.svg') }}" alt="">
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
                                    <img src="{{ asset('assets/img/guest/icon-shield.svg') }}" alt="">
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
                        <p>Untuk kamu yang mau membuka usaha pada bidang textile tetapi masih bingung dengan modal yang
                            harus dikeluarkan, jangan khawatir karena Dunia Sandang memberikan solusi dengan program
                            Buyer Financing.</p>
                        <a href="" class="uk-button uk-button-secondary">Info Lengkap</a>
                    </div>
                    <div class="uk-width-1-2@s">
                        <div uk-grid>
                            <div class="uk-width-1-3@s">

                            </div>
                            <div class="uk-width-2-3@s">
                                <img src="{{ asset('assets/img/guest/offer-financing.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div id="homeBlog" class="uk-child-width-1-3@s" uk-grid></div>

        </div>
    </main>
    @push('script')
        <script>
            const base_url = 'https://duniasandang.com/wp-json/wp/v2/posts?per_page=3';

            fetch(base_url)
                .then(response => response.json())
                .then(posts => {
                    const postsContainer = document.getElementById('homeBlog');

                    posts.forEach(post => {
                        const title = post.title.rendered;
                        const metaDescription = post.yoast_head_json.og_description || '';
                        const snippet = metaDescription.substring(0, 160) + '...';
                        const permalink = post.link;
                        const postDate = new Date(post.date).toLocaleDateString('id-ID', {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        });

                        // Get the featured image URL
                        const featuredMedia = post.featured_media;
                        let mediaUrl = '';

                        if (featuredMedia) {
                            fetch(`https://duniasandang.com/wp-json/wp/v2/media/${featuredMedia}`)
                                .then(response => response.json())
                                .then(mediaData => {
                                    mediaUrl = mediaData.source_url;

                                    const card = document.createElement('div');
                                    //card.classList.add()

                                    card.innerHTML = `
                                            <div class="rz-blogPost">
                                            <a href="${permalink}" target="_blank">
                                                <div class="rz-blogPost-Image"><img src="${mediaUrl}" alt="${title}" class="uk-cover"></div>
                                            </a>
                                                <div class="rz-blogPost-Title"><span class="uk-text-small uk-text-meta">${postDate}</span><h5><a href="${permalink}" target="_blank">${title}</a></h5><p>${snippet}</p></div>
                                            </div>

                                        `;

                                    postsContainer.appendChild(card);
                                });
                        }
                    });
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        </script>
    @endpush
</x-app-layout>
