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
    <h1 class="h2">Kategoriler</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('dashboard.categories.create') }}" class="btn btn-sm btn-primary">
            <i class="bi bi-plus-circle"></i> Kategori Ekle
        </a>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form id="bulkDeleteForm" method="POST" action="{{ route('dashboard.categories.bulkDelete') }}">
    @csrf
    <table class="table table-bordered">
        <thead>
            <tr>
                <th><input type="checkbox" id="selectAll"></th>
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
                    <td><input type="checkbox" name="ids[]" value="{{ $category->id }}"></td>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $category->name }}</td>
                    <td>
                        <label class="switch">
                            <input type="checkbox" data-id="{{ $category->id }}" {{ $category->status ? 'checked' : '' }}>
                            <span class="slider round"></span>
                        </label>
                    </td>
                    <td>
                        @if ($category->image)
                            <img src="{{ asset('storage/category_images/' . $category->image) }}" alt="{{ $category->name }}" width="50">
                        @else
                            Resim Yok
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('dashboard.categories.edit', $category->id) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="{{ $category->id }}">
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
    // Status Toggle
    document.querySelectorAll('.switch input').forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            const categoryId = this.dataset.id;
            fetch(`/categories/${categoryId}/toggle-status`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
            }).then(response => response.json())
              .then(data => {
                  Swal.fire({
                      icon: 'success',
                      title: 'Başarılı!',
                      text: data.message,
                  });
              });
        });
    });

    // Toplu Silme
    document.getElementById('selectAll').addEventListener('change', function () {
        document.querySelectorAll('tbody input[type="checkbox"]').forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function () {
            const categoryId = this.dataset.id;
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
                    fetch(`/categories/${categoryId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                    }).then(response => response.json())
                      .then(data => {
                          Swal.fire({
                              icon: 'success',
                              title: 'Başarılı!',
                              text: 'Kategori başarıyla silindi.',
                          }).then(() => location.reload());
                      });
                }
            });
        });
    });
</script>
@endsection