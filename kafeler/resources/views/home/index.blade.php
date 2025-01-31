@extends('layouts.home')
@section('title', 'Home')
@section('styles')
    <style>
        .block {
            margin-bottom: 30px;
        }

        .block-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .block-title {
            font-size: 24px;
            font-weight: bold;
        }

        .block-body {
            margin-bottom: 20px;
        }

        .product-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .product-card:hover {
            transform: scale(1.05);
        }

        .card-inner {
            position: relative;
        }

        .swiper-progress {
            height: 200px;
        }

        .swiper-progress img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .card-body {
            padding: 15px;
        }

        .card-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .card-items {
            font-size: 14px;
            color: #666;
        }

        .card-subtitle {
            font-weight: bold;
            color: #333;
        }

        .swiper-pagination {
            bottom: 10px;
        }
    </style>
@endsection
@section('content')
    <div class="block block-products">
        <div class="container">
            <div class="block-inner">

                <div class="block-body">
                    <div class="row">
                        @foreach ($cafes as $cafe)
                            <div class="col-sm-6 col-md-4 col-lg-3 mb-3">
                                <div class="card product-card">
                                    <div class="card-inner">
                                        <div class="swiper swiper-progress swiper-container">
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
                                            <div class="swiper-pagination"></div>
                                        </div>

                                        <a class="product-link" href="{{ route('cafe.show', $cafe->slug) }}">
                                            <div class="card-body">
                                                <div class="card-title">{{ $cafe->cafe_name }}</div>

                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="block-footer"></div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cafeSwipers = document.querySelectorAll('.swiper-progress');
            cafeSwipers.forEach(swiperElement => {
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
@endsection
