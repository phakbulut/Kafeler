@extends('userdashboard.template.app')
@section('styles')
<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 34px;
    }
    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }
    input:checked + .slider {
        background-color: #28a745;
    }
    input:checked + .slider:before {
        transform: translateX(26px);
    }
</style>
@endsection
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kategori Düzenle: {{ $category->name }}</h1>
</div>


<form method="POST" action="{{ route('dashboard.categories.update', $category->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="name" class="form-label">Kategori Adı</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $category->name) }}" required>
    </div>

    <div class="mb-3">
        <label for="image" class="form-label">Resim Yükle</label>
        <input type="file" class="form-control" id="image" name="image">
        @if ($category->image)
            <div class="mt-2">
                <img src="{{ asset('storage/category_images/' . $category->image) }}" alt="{{ $category->name }}" width="100">
            </div>
        @endif
    </div>

    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="status" name="status" {{ $category->status ? 'checked' : '' }}>
        <label class="form-check-label" for="status">Aktif</label>
    </div>

    <button type="submit" class="btn btn-primary">Güncelle</button>
    <a href="{{ route('dashboard.categories.index') }}" class="btn btn-secondary">İptal</a>
</form>
@endsection