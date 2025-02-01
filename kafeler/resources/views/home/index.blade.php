@extends('layouts.home')
@section('title', 'Home')
@section('styles')

@endsection
@section('content')
<section class="featured-slider">
    <div class="slider-wrapper">
        <div class="swiper init-swiper">

            <div class="swiper-wrapper">

                    <div class="swiper-slide">
                        <div class="slide-object">
                            <img class="slider-img" src="{{ asset('/slider/ana_slide1.jpg') }}" alt="slider_1">
                        </div>

                    </div>
                    <div class="swiper-slide">
                        <div class="slide-object">
                            <img class="slider-img" src="{{ asset('/slider/ana_slide2.jpg') }}" alt="slider_2">
                        </div>

                    </div>
            </div>

            <div class="swiper-pagination"></div>
        </div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>
</section>

<section id="products" class="products section">
    <!-- Bölüm Başlığı -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Bizimle Çalışan kafeler</h2>
        <p>İhtiyacınıza Uygun Çözümlerle, Kaliteden Ödün Vermeyen Seçimler.</p>
    </div>

    <div class="container">
        <div class="row" data-aos="fade-up">
            @foreach ($cafes as $cafe)
                <div class="col-md-6 col-lg-3 mb-3">
                    <div class="card products-card">
                        <div class="card-inner">
                            <div class="card-body p-0">
                                <div class="card-object">
                                    <div class="swiper productSwiper swiper-container">
                                    <div class="swiper-wrapper">
                                        @if ($cafe->cafebanners && $cafe->cafebanners->isNotEmpty())
                                            @foreach ($cafe->cafebanners as $banner)
                                                <div class="swiper-slide">
                                                    <img class="card-img"
                                                        src="{{ asset('storage/' . $banner->image) }}"
                                                        alt="{{ $cafe->cafe_name }}" />
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="swiper-slide">
                                                <img class="card-img"
                                                    src="{{ asset('storage/banner_images/default-banner.jpg') }}"
                                                    alt="{{ $cafe->cafe_name }}" />
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                    <div class="swiper-pagination"></div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="product-title">{{ $cafe->cafe_name }}</div>
                                <a href="{{ route('cafe.show', $cafe->slug) }}" class="card-btn">İncele</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


</section>

@endsection
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const productSwipers = document.querySelectorAll('.init-swiper');
    productSwipers.forEach(swiperElement => {
        new Swiper(swiperElement, {
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
        });
    });
        const searchInput = document.getElementById('searchInput');
        const searchResults = document.getElementById('searchResults');

        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            if (query.length > 2) {
                fetch(`/search-cafes?query=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        searchResults.innerHTML = '';
                        if (data.length > 0) {
                            data.forEach(cafe => {
                                const div = document.createElement('div');
                                div.className = 'bg-light p-2 mb-1 rounded';
                                div.innerHTML =
                                    `<a href="/cafe/${cafe.slug}" class="text-decoration-none">${cafe.cafe_name}</a>`;
                                searchResults.appendChild(div);
                            });
                        } else {
                            searchResults.innerHTML = '<div class="p-2">Sonuç bulunamadı.</div>';
                        }
                    });
            } else {
                searchResults.innerHTML = '';
            }
        });
    });
</script>
<script type="application/json" class="swiper-config">
    {
    "loop": true,
    "speed": 600,
    "autoplay": {
        "delay": 5000
    },
    "slidesPerView": "auto",
    "centeredSlides": true,
    "pagination": {
        "el": ".swiper-pagination",
        "type": "bullets",
        "clickable": true
    },
    "navigation": {
        "nextEl": ".swiper-button-next",
        "prevEl": ".swiper-button-prev"
    }
    }


</script>
@endsection
