@extends('layouts.home')
@section('title',$cafe->cafe_name)
@section('styles')
<style>
    .swiper-slide img {
        height: 300px;
        object-fit: cover;
    }
    @media (max-width: 768px) {
        .swiper-slide img {
            height: 200px;
        }
    }
    .card {
        transition: transform 0.3s ease;
    }
    .card:hover {
        transform: scale(1.05);
    }
</style>
@endsection
@section('content')
<h1>{{ $cafe->cafe_name }}</h1>
<p>{{ $cafe->description }}</p>

<h3>Kategoriler</h3>
<div class="row">
    @foreach ($cafe->categories as $category)
        <div class="col-md-4 mb-3">
            <div class="card">
                <img src="{{ asset('storage/category_images/' . $category->image) }}" alt="{{ $category->name }}" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title">{{ $category->name }}</h5>
                    <p class="card-text">{{ Str::limit($category->description, 50) }}</p>
                    <a class="product-link" href="{{ route('cafe.category.products', ['cafeSlug' => $cafe->slug, 'categorySlug' => $category->slug]) }}">
                        {{ $category->name }}
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>
@if ($cafe->location)
<div class="row">

    <div class="mt-4">
        <h4>Konum</h4>
        {!! $cafe->location !!} 
    </div>
</div>

@endif
@endsection