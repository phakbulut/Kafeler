@extends('layouts.home')
@section('title',$category->name)
@section('styles')

@endsection
@section('content')
<section id="hero" class="hero section dark-background">

    <img src="{{ asset('assets/img/hero-bg.jpg') }}" alt="" data-aos="fade-in">

    <div class="container">
        <div class="row">
            <div class="col-xl-4">
                <h1 data-aos="fade-up">{{ $cafe->cafe_name }}</h1>
                <blockquote data-aos="fade-up" data-aos-delay="100">
                    <p>{{ $cafe->description }}</p>
                </blockquote>
                <div class="d-flex" data-aos="fade-up" data-aos-delay="200">
                    <a href="{{ route('cafe.show', $cafe->slug) }}" class="btn-get-started">{{$cafe->cafe_name}} Kategorilerine Geri Dön</a>
           
                </div>
            </div>
        </div>
    </div>

</section>
<section id="products" class="products section">
    <div class="container">
        <div class="row">
            

            <div class="col-lg-9">
                <div class="row" data-aos="fade-up">
                    @forelse ($products as $product)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card products-card">
                                <div class="card-inner">
                                    <div class="card-body p-0">
                                        <div class="card-object">
                                            <img class="product-img"
                                                src="{{ asset('storage/product_main_images/' . $product->main_image) }}"
                                                alt="{{ $product->name }}">
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="product-title">{{ $product->name }}</div>
                                        
                                            <button class=" card-btn" data-bs-toggle="modal" data-bs-target="#productModal{{ $product->id }}">
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
                    @empty
                        <p class="text-center">Bu kategoride ürün bulunmamaktadır.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>
  


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