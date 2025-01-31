@extends('userdashboard.template.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Yeni Slider Ekle</h1>
</div>

<form action="{{ route('dashboard.banners.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label>Resim</label>
        <input type="file" name="image" class="form-control" required>
    </div>
    <div class="form-group form-check">
        <input type="checkbox" name="status" class="form-check-input" id="status" checked>
        <label class="form-check-label" for="status">Aktif</label>
    </div>
    <button type="submit" class="btn btn-primary">Kaydet</button>
</form>
@endsection