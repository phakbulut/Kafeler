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

    /* Yeni Eklenen Checkbox Stilleri */
    .bulk-checkbox {
        width: 1.2em;
        height: 1.2em;
        border: 2px solid #dee2e6;
        border-radius: 0.35em;
        cursor: pointer;
    }

    .bulk-checkbox:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill='none' stroke='%23fff' stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='M6 10l3 3l6-6'/%3e%3c/svg%3e");
    }
</style>
@endsection

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kategoriler</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('dashboard.categories.create') }}" class="btn btn-sm btn-primary">
            <i class="bi bi-plus-circle"></i> Kategori Ekle
        </a>
    </div>
</div>

<form id="bulkDeleteForm" method="POST" action="{{ route('dashboard.categories.bulkDelete') }}">
    @csrf
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>
                    <input type="checkbox" id="selectAll" class="bulk-checkbox">
                </th>
                <th>Kategori Id</th>
                <th>Kategori Adı</th>
                <th>Status</th>
                <th>Resim</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td>
                        <input type="checkbox" 
                               name="ids[]" 
                               value="{{ $category->id }}" 
                               class="bulk-checkbox">
                    </td>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $category->name }}</td>
                    <td>
                        <label class="switch">
                            <input type="checkbox" 
                                   data-id="{{ $category->id }}"
                                   {{ $category->status ? 'checked' : '' }}>
                            <span class="slider round"></span>
                        </label>
                    </td>
                    <td>
                        @if ($category->image)
                            <img src="{{ asset('storage/category_images/' . $category->image) }}"
                                alt="{{ $category->name }}" 
                                style="width: 50px; height: 50px; object-fit: cover;">
                        @else
                            Resim Yok
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('dashboard.categories.edit', $category->id) }}"
                            class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <button type="button" 
                                class="btn btn-sm btn-danger delete-btn" 
                                data-id="{{ $category->id }}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <button type="submit" class="btn btn-danger" id="bulkDeleteBtn">Seçilenleri Sil</button>
</form>
@endsection

@section('scripts')
<script>
    // Route URL'leri
    const toggleStatusUrl = "{{ route('dashboard.categories.toggleStatus', ['category' => ':id']) }}";
    const deleteUrl = "{{ route('dashboard.categories.destroy', ['category' => ':id']) }}";

    // Status Toggle
    document.querySelectorAll('.switch input').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const categoryId = this.dataset.id;
            const url = toggleStatusUrl.replace(':id', categoryId);

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
                });
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

    // DÜZELTİLMİŞ TOPLU SEÇİM
    document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('tbody input.bulk-checkbox[type="checkbox"]');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    });

    // Tekli Silme
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            const categoryId = this.dataset.id;
            const url = deleteUrl.replace(':id', categoryId);

            Swal.fire({
                title: 'Emin misiniz?',
                text: "Bu işlem geri alınamaz!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
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
                        }).then(() => location.reload());
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
        
        const selectedIds = Array.from(document.querySelectorAll('input.bulk-checkbox[name="ids[]"]:checked'))
                                .map(checkbox => checkbox.value);

        if(selectedIds.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Uyarı!',
                text: 'Lütfen silmek istediğiniz kategorileri seçiniz!'
            });
            return;
        }

        Swal.fire({
            title: 'Emin misiniz?',
            text: `Seçilen ${selectedIds.length} kategori kalıcı olarak silinecek!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sil',
            cancelButtonText: 'İptal'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ ids: selectedIds })
                })
                .then(response => {
                    if (!response.ok) throw new Error('Toplu silme işlemi başarısız');
                    return response.json();
                })
                .then(data => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Başarılı!',
                        text: data.message,
                    }).then(() => location.reload());
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
</script>
@endsection