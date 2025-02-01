@extends('userdashboard.template.app')

@section('content')
<div class="container">
    <h1>Dashboard</h1>

    <div id="chart"></div>

    <div class="mt-4">
        <label for="routeLink">Kafe Linki:</label>
        <div class="input-group">
            <input type="text" id="routeLink" class="form-control" value="{{ route('cafe.show',  Auth::user()->slug) }}" readonly>
            <button class="btn btn-primary" onclick="copyToClipboard()">Kopyala</button>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('generate.qr', Auth::user()->slug) }}" class="btn btn-success">
            QR Kod İndir
        </a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const chartData = {!! $chartData !!};

        var options = {
            chart: {
                type: 'line',
                height: 350,
            },
            series: chartData,
            xaxis: {
                categories: ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
            },
            yaxis: {
                title: {
                    text: 'Tıklama Sayısı',
                },
            },
            title: {
                text: '{{ $year }} Yılı Aylık Tıklanma İstatistikleri',
                align: 'center',
            },
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    });

    function copyToClipboard() {
        const routeLink = document.getElementById('routeLink');
        routeLink.select();
        document.execCommand('copy');
        alert('Link kopyalandı!');
    }
</script>
@endsection