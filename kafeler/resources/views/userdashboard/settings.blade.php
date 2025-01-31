@extends('userdashboard.template.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Ayarlar</h1>
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
    <div class="form-check form-switch mb-3">
        <input class="form-check-input" type="checkbox" id="status" name="status" value="1" {{ $user->status ? 'checked' : '' }}>
        <label class="form-check-label" for="status">Kafe Sayfası Görünürlüğü</label>
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
        <label for="password" class="form-label">Yeni Şifre (İsteğe Bağlı)</label>
        <input type="password" class="form-control" id="password" name="password">
    </div>
    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Şifre Tekrarı</label>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
    </div>

    <button type="submit" class="btn btn-primary">Güncelle</button>
</form>
@endsection