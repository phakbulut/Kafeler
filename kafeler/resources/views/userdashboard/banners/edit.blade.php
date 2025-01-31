@extends('userdashboard.template.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Slider Düzenle</h1>
</div>

<form action="{{ route('dashboard.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label>Mevcut Resim</label><br>
        <img src="{{ asset('storage/'.$banner->image) }}" alt="Banner" width="200" class="mb-2">
        <input type="file" name="image" class="form-control">
    </div>
    <div class="form-group form-check">
        <input type="checkbox" name="status" class="form-check-input" id="status" {{ $banner->status ? 'checked' : '' }}>
        <label class="form-check-label" for="status">Aktif</label>
    </div>
    <button type="submit" class="btn btn-primary">Güncelle</button>
</form>
@endsection