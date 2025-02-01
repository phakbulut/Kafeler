@extends('userdashboard.template.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Ürün Düzenle: {{ $product->name }}</h1>
</div>
<form method="POST" action="{{ route('dashboard.products.update', $product->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="category_id" class="form-label">Kategori</label>
        <select class="form-select" id="category_id" name="category_id" required>
            <option value="">Seçiniz</option>
            @foreach ($categories as $id => $name)
                <option value="{{ $id }}" {{ $product->category_id == $id ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="name" class="form-label">Ürün Adı</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $product->name) }}" required>
    </div>

    <div class="mb-3">
        <label for="price" class="form-label">Fiyat</label>
        <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ old('price', $product->price) }}" required>
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Açıklama</label>
        <textarea class="form-control" id="description" name="description">{{ old('description', $product->description) }}</textarea>
    </div>

    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="status" name="status" {{ $product->status ? 'checked' : '' }}>
        <label class="form-check-label" for="status">Aktif</label>
    </div>
    <div class="mb-3">
        <label for="main_image" class="form-label">Ana Resim</label>
        <input type="file" class="form-control" id="main_image" name="main_image">
        @if ($product->main_image)
            <div class="mt-2">
                <img src="{{ asset('storage/product_main_images/' . $product->main_image) }}" alt="{{ $product->name }}" width="100">
            </div>
        @endif
    </div>

    <div class="mb-3">
        <label for="slider_images" class="form-label">Mevcut Slider Resimleri</label>
        <div class="d-flex flex-wrap gap-2">
            @foreach ($product->images as $image)
                <div class="position-relative">
                    <img src="{{ asset('storage/product_slider_images/' . $image->image) }}" alt="{{ $product->name }}" width="100" class="img-thumbnail">
                    <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-image" data-id="{{ $image->id }}">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            @endforeach
        </div>
    </div>

    <div class="mb-3">
        <label for="slider_images" class="form-label">Yeni Slider Resimleri Ekle (Opsiyonel)</label>
        <input type="file" class="form-control" id="slider_images" name="slider_images[]" multiple>
        <small class="text-muted">Seçilen dosyalar: <span id="selectedFiles"></span></small>
    </div>

    <button type="submit" class="btn btn-primary">Güncelle</button>
    <a href="{{ route('dashboard.products.index') }}" class="btn btn-secondary">İptal</a>
</form>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
<script>
document.addEventListener('DOMContentLoaded', function () {
    var swiper = new Swiper(".mySwiper", {
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
    });

    document.querySelectorAll('.remove-image').forEach(button => {
        button.addEventListener('click', function () {
            const imageId = this.dataset.id;
            Swal.fire({
                title: 'Emin misiniz?',
                text: "Bu resmi kalıcı olarak sileceksiniz!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sil',
                cancelButtonText: 'İptal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/products/remove-image/${imageId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Başarılı!',
                            text: data.message,
                        }).then(() => location.reload());
                    });
                }
            });
        });
    });

    const fileInput = document.getElementById('slider_images');
    const selectedFilesSpan = document.getElementById('selectedFiles');
    fileInput.addEventListener('change', function () {
        const files = Array.from(fileInput.files).map(file => file.name);
        selectedFilesSpan.textContent = files.join(', ');
    });

    document.querySelectorAll('.switch input').forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            const productId = this.dataset.id;
            fetch(`/products/${productId}/toggle-status`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.missing) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Hata!',
                        text: data.message,
                        footer: `<ul>${Object.values(data.missing).filter(Boolean).map(msg => `<li>${msg}</li>`).join('')}</ul>`,
                    });
                    this.checked = !this.checked;
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Başarılı!',
                        text: data.message,
                    });
                }
            })
            .catch(error => {
                console.error('Hata:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Hata!',
                    text: 'Bir hata oluştu. Lütfen tekrar deneyin.',
                });
                this.checked = !this.checked;
            });
        });
    });
});
</script>
@endsection
