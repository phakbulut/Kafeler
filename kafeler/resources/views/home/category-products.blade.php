@extends('layouts.home')
@section('title',$category->name)
@section('styles')
<style>
    .product-card {
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        transition: transform 0.3s ease;
    }
    .product-card:hover {
        transform: scale(1.05);
    }
    .card-img-top {
        height: 200px;
        object-fit: cover;
    }
    .card-title {
        font-size: 18px;
        font-weight: bold;
    }
    .card-text {
        font-size: 16px;
        color: #333;
    }
    .productSwiper {
        height: 400px;
    }
    .productSwiper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>
@endsection
@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1>{{ $cafe->cafe_name }} - {{ $category->name }}</h1>
            <p>{{ $category->description }}</p>
        </div>
    </div>

    <!-- Ürün Kartları -->
    <div class="row">
        @foreach ($products as $product)
            <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card product-card">
                    <div class="card-inner">
                        <img src="{{ asset('storage/product_main_images/' . $product->main_image) }}" alt="{{ $product->name }}" class="card-img-top img-fluid">

                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ $product->price }} ₺</p>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#productModal{{ $product->id }}">
                                Detayları Gör
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="productModal{{ $product->id }}" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="productModalLabel">{{ $product->name }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="swiper productSwiper">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <img src="{{ asset('storage/product_main_images/' . $product->main_image) }}" alt="{{ $product->name }}" class="img-fluid">
                                    </div>
                                    @foreach ($product->images as $image)
                                        <div class="swiper-slide">
                                            <img src="{{ asset('storage/product_slider_images/' . $image->image) }}" alt="{{ $product->name }}" class="img-fluid">
                                        </div>
                                    @endforeach
                                </div>
                                <div class="swiper-pagination"></div>
                            </div>

                            <div class="mt-3">
                                <p><strong>Fiyat:</strong> {{ $product->price }} ₺</p>
                                <p><strong>Açıklama:</strong> {{ $product->description }}</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const productSwipers = document.querySelectorAll('.productSwiper');
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
});
</script>
@endsection