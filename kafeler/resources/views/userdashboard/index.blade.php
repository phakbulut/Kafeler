@extends('userdashboard.template.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Kafe İstatistikleri</h5>
                <p class="card-text">Burada kafe ile ilgili istatistikler yer alacak.</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Son Etkinlikler</h5>
                <p class="card-text">Son eklenen ürünler veya yapılan değişiklikler burada listelenecek.</p>
            </div>
        </div>
    </div>
</div>
@endsection