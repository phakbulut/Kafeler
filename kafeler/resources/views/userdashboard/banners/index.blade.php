@extends('userdashboard.template.app')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
<style>
    /* Swiper Stilleri */
    .swiper-container {
        width: 100%;
        height: 300px;
        margin: 20px auto;
        overflow: hidden;
        position: relative;
        border-radius: 8px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.1);
    }

    .swiper-wrapper {
        width: 100%;
        height: 100%;
    }

    .swiper-slide {
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        background: #f8f9fa;
    }

    .swiper-slide img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        padding: 10px;
    }

    /* Switch Stilleri */
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

    /* Tablo ve Checkbox Stilleri */
    .table-container {
        margin-top: 30px;
        overflow-x: auto;
    }

    .form-check-input.custom-checkbox {
        width: 1.2em;
        height: 1.2em;
        border: 2px solid #dee2e6;
        border-radius: 0.35em;
        cursor: pointer;
    }

    .form-check-input.custom-checkbox:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .form-check {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 40px;
    }

    .img-thumbnail {
        background-color: #fff;
        border: 2px solid #dee2e6;
    }

    /* Vuexy Uyumlu Tablo Başlık Stilleri */
  

    .table th, .table td {
        padding: 12px;
        text-align: center;
    }

    .table-bordered {
        border: 1px solid #dee2e6;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Slider Yönetimi</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('dashboard.banners.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i>Yeni Slider Ekle
            </a>
        </div>
    </div>

    <div class="swiper-container">
        <div class="swiper-wrapper">
            @foreach($banners->where('status', 1) as $banner)
            <div class="swiper-slide">
                <img src="{{ asset('storage/'.$banner->image) }}" alt="Banner {{ $loop->iteration }}">
            </div>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
    </div>

    <div class="table-container">
        <form id="bulkDeleteForm" method="POST" action="{{ route('dashboard.banners.bulkDelete') }}">
            @csrf
            <table class="table table-bordered table-hover align-middle">
                <thead>
                    <tr>
                        <th style="width: 50px;">
                            <div class="form-check">
                                <input type="checkbox" id="selectAll" class="form-check-input custom-checkbox">
                            </div>
                        </th>
                        <th style="width: 80px;">#</th>
                        <th>Resim</th>
                        <th style="width: 120px;">Durum</th>
                        <th style="width: 150px;">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($banners as $banner)
                    <tr>
                        <td>
                            <div class="form-check">
                                <input type="checkbox"
                                       name="ids[]"
                                       value="{{ $banner->id }}"
                                       class="form-check-input custom-checkbox">
                            </div>
                        </td>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <img src="{{ asset('storage/'.$banner->image) }}"
                                 alt="Banner {{ $loop->iteration }}"
                                 class="img-thumbnail"
                                 style="max-width: 150px; height: auto;">
                        </td>
                        <td>
                            <label class="switch">
                                <input type="checkbox"
                                       data-id="{{ $banner->id }}"
                                       {{ $banner->status ? 'checked' : '' }}>
                                <span class="slider round"></span>
                            </label>
                        </td>
                        <td>
                            <a href="{{ route('dashboard.banners.edit', $banner->id) }}"
                               class="btn btn-warning btn-sm"
                               title="Düzenle">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <button type="button"
                                    class="btn btn-danger btn-sm delete-btn"
                                    data-id="{{ $banner->id }}"
                                    title="Sil">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <button type="submit" class="btn btn-danger" id="bulkDeleteBtn">
                <i class="bi bi-trash me-1"></i>Seçilenleri Sil
            </button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
    // Swiper Konfigürasyonu
    const swiper = new Swiper('.swiper-container', {
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        loop: true,
        slidesPerView: 1,
        spaceBetween: 10,
        centeredSlides: true,
        breakpoints: {
            768: {
                slidesPerView: 1.2,
                spaceBetween: 20,
            }
        }
    });

    // Route URL'leri
    const toggleStatusUrl = "{{ route('dashboard.banners.toggleStatus', ['banner' => ':id']) }}";
    const deleteUrl = "{{ route('dashboard.banners.destroy', ['banner' => ':id']) }}";

    // Status Toggle İşlemi
    document.querySelectorAll('.switch input').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const bannerId = this.dataset.id;
            const url = toggleStatusUrl.replace(':id', bannerId);

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
            })
            .then(response => {
                if (!response.ok) throw new Error('Durum güncelleme başarısız');
                return response.json();
            })
            .then(data => {
                Swal.fire({
                    icon: 'success',
                    title: 'Başarılı!',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => window.location.reload());
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Hata!',
                    text: error.message
                });
                this.checked = !this.checked;
            });
        });
    });

    // DÜZELTİLMİŞ TOPLU SEÇİM KODU
    document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('tbody input.custom-checkbox[type="checkbox"]');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    });

    // Tekli Silme
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            const bannerId = this.dataset.id;
            const url = deleteUrl.replace(':id', bannerId);

            Swal.fire({
                title: 'Emin misiniz?',
                text: "Bu işlem geri alınamaz!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sil',
                cancelButtonText: 'İptal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                    })
                    .then(response => {
                        if (!response.ok) throw new Error('Silme işlemi başarısız');
                        return response.json();
                    })
                    .then(data => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Başarılı!',
                            text: data.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => window.location.reload());
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Hata!',
                            text: error.message
                        });
                    });
                }
            });
        });
    });

    // Toplu Silme İşlemi
    document.getElementById('bulkDeleteForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const selectedIds = Array.from(document.querySelectorAll('tbody input.custom-checkbox:checked'))
                                  .map(checkbox => checkbox.value);

        if (selectedIds.length === 0) {
            Swal.fire('Uyarı', 'Lütfen silmek için en az bir öğe seçin.', 'warning');
            return;
        }

        Swal.fire({
            title: 'Emin misiniz?',
            text: "Seçilen öğeler silinecek!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sil',
            cancelButtonText: 'İptal'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });
</script>
@endsection
