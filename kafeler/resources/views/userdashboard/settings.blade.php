@extends('userdashboard.template.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Ayarlar</h1>
</div>

<!-- Status Değiştirme Butonu -->
<div class="mb-3">
    <button id="toggleStatusButton" class="btn btn-{{ $user->status ? 'success' : 'secondary' }}">
        Kafe Sayfasını {{ $user->status ? 'Pasif' : 'Aktif' }} Yap
    </button>
    <span id="statusMessage"></span>
</div>

<form method="POST" action="{{ route('dashboard.settings.update') }}" enctype="multipart/form-data">
    @csrf
    @method('POST')
    <div class="mb-3">
        <label for="name" class="form-label">Ad</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
    </div>
    <div class="mb-3">
        <label for="surname" class="form-label">Soyad</label>
        <input type="text" class="form-control" id="surname" name="surname" value="{{ $user->surname }}" required>
    </div>
    <div class="mb-3">
        <label for="cafe_name" class="form-label">Kafe Adı</label>
        <input type="text" class="form-control" id="cafe_name" name="cafe_name" value="{{ $user->cafe_name }}" required>
    </div>
   
    <div class="mb-3">
        <label for="avatar" class="form-label">Avatar</label>
        <input type="file" class="form-control" id="avatar" name="avatar">
        @if ($user->avatar)
            <div class="mt-2">
                <img src="{{ asset('storage/avatars/' . $user->avatar) }}" alt="Avatar" width="100" class="rounded-circle">
            </div>
        @endif
    </div>
    <div class="mb-3">
        <label for="location" class="form-label">Google Maps İframe</label>
        <textarea class="form-control" id="location" name="location" rows="3">{{ $user->location }}</textarea>
        <small class="text-muted">Google Maps'ten aldığınız iframe kodunu buraya yapıştırın.</small>
    </div>
    <div class="mb-3">
        <label for="instagram" class="form-label">Instagram</label>
        <input type="text" class="form-control" id="instagram" name="instagram" value="{{ $user->socialLinks?->instagram }}">
    </div>
    <div class="mb-3">
        <label for="facebook" class="form-label">Facebook</label>
        <input type="text" class="form-control" id="facebook" name="facebook" value="{{ $user->socialLinks?->facebook }}">
    </div>
    <div class="mb-3">
        <label for="phone" class="form-label">Telefon Numarası</label>
        <input type="text" class="form-control" id="phone" name="phone" value="{{ $user->socialLinks?->phone }}">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Yeni Şifre (İsteğe Bağlı)</label>
        <input type="password" class="form-control" id="password" name="password">
    </div>
    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Şifre Tekrarı</label>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
    </div>
    <button type="submit" class="btn btn-primary">Güncelle</button>
</form>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggleStatusButton = document.getElementById('toggleStatusButton');
    const statusMessage = document.getElementById('statusMessage');

    toggleStatusButton.addEventListener('click', function () {
        fetch("{{ route('dashboard.toggle.status') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Başarılıysa butonu ve mesajı güncelle
                toggleStatusButton.textContent = `Kafe Sayfasını ${data.status === 'aktif' ? 'Pasif' : 'Aktif'} Yap`;
                toggleStatusButton.className = `btn btn-${data.status === 'aktif' ? 'success' : 'secondary'}`;
                statusMessage.textContent = data.message;
                statusMessage.style.color = 'green';
            } else {
                // Hata varsa mesajı göster
                statusMessage.textContent = data.message;
                statusMessage.style.color = 'red';
            }
        })
        .catch(error => {
            console.error('Hata:', error);
            statusMessage.textContent = 'Bir hata oluştu. Lütfen tekrar deneyin.';
            statusMessage.style.color = 'red';
        });
    });
});
</script>
@endsection
