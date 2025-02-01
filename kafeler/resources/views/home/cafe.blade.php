@extends('layouts.home')
@section('title', $cafe->cafe_name)
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

                </div>
            </div>
        </div>

    </section>
    <section id="products" class="products section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">

                    <div class="service-box">
                        <h4>Sosyal Medya</h4>
                        <div class="download-catalog">
                            @if ($cafe->socialLinks && $cafe->socialLinks->facebook)
                                <a href="{{ $cafe->socialLinks->facebook }}" target="_blank">
                                    <i class="bi bi-facebook"></i>
                                    <span>Facebook</span>
                                </a>
                                <br>

                            @else
                                <span class="text-muted">
                                    <i class="bi bi-facebook"></i>
                                    <span>Facebook (Bağlantı Yok)</span>
                                </span>
                                <br>

                            @endif
                    
                            @if ($cafe->socialLinks && $cafe->socialLinks->instagram)
                                <a href="{{ $cafe->socialLinks->instagram }}" target="_blank">
                                    <i class="bi bi-instagram"></i>
                                    <span>Instagram</span>
                                </a>
                                <br>

                            @else
                                <span class="text-muted">
                                    <i class="bi bi-instagram"></i>
                                    <span>Instagram (Bağlantı Yok)</span>
                                </span>
                                <br>
                            @endif
                    
                            @if ($cafe->socialLinks && $cafe->socialLinks->phone)
                                <a href="tel:{{ $cafe->socialLinks->phone }}">
                                    <i class="bi bi-telephone"></i>
                                    <span>{{ $cafe->socialLinks->phone }}</span>
                                </a>
                                <br>

                            @else
                                <span class="text-muted">
                                    <i class="bi bi-telephone"></i>
                                    <span>Telefon (Yok)</span>
                                </span>
                                <br>

                            @endif
                        </div>
                    </div>
                </div>


                <div class="col-lg-9">
                    <div class="row" data-aos="fade-up">
                        @forelse ($cafe->categories as $category)
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card products-card">
                                    <div class="card-inner">
                                        <div class="card-body p-0">
                                            <div class="card-object">
                                                <img class="product-img"
                                                    src="{{ asset('storage/category_images/' . $category->image) }}"
                                                    alt="{{ $category->name }}">
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="product-title">{{ $category->name }}</div>
                                            <a href="{{ route('cafe.category.products', ['cafeSlug' => $cafe->slug, 'categorySlug' => $category->slug]) }}"
                                                class="card-btn">İncele</a>
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
    @if ($cafe->location)
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h4>Konum</h4>
                    {!! $cafe->location !!}

                </div>
            </div>
        </div>
    @endif

@endsection
