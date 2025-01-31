@extends('userdashboard.template.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Yeni Ürün Ekle</h1>
</div>

<form method="POST" action="{{ route('dashboard.products.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="category_id" class="form-label">Kategori</label>
        <select class="form-select" id="category_id" name="category_id" required>
            <option value="">Seçiniz</option>
            @foreach ($categories as $id => $name)
                <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="name" class="form-label">Ürün Adı</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>

    <div class="mb-3">
        <label for="price" class="form-label">Fiyat</label>
        <input type="number" step="0.01" class="form-control" id="price" name="price" required>
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Açıklama</label>
        <textarea class="form-control" id="description" name="description"></textarea>
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="status" name="status">
        <label class="form-check-label" for="status">Aktif</label>
    </div>
    <div class="mb-3">
        <label for="main_image" class="form-label">Ana Resim</label>
        <input type="file" class="form-control" id="main_image" name="main_image" required>
    </div>

    <div class="mb-3">
        <label for="slider_images" class="form-label">Slider Resimleri (Opsiyonel)</label>
        <input type="file" class="form-control" id="slider_images" name="slider_images[]" multiple>
    </div>

    <button type="submit" class="btn btn-primary">Kaydet</button>
    <a href="{{ route('dashboard.products.index') }}" class="btn btn-secondary">İptal</a>
</form>
@endsection