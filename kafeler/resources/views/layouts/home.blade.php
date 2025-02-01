<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ env('APP_META_DESCRIPTION') }}">
    <meta name="keywords" content="{{ env('APP_META_KEYWORDS') }}">
    <meta name="author" content="{{ env('APP_META_AUTHOR') }}">
    <title>{{ env('APP_NAME') }} - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    @yield('styles')
</head>
<body>
    <header class="bg-light shadow-sm py-3">
        <div class="container center">
           
           
            <img src="{{ asset(env('APP_LOGO')) }}" alt="{{ env('APP_NAME') }}" class="img-fluid mx-auto d-block" style="max-width: 200px;">
        
        </div>
    </header>

    <main class="py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <footer class="bg-light text-center py-3 border-top">
        <div class="container">
            &copy; {{ date('Y') }} {{ preg_replace('~^https?://~', '', env('APP_URL')) }}
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    @stack('scripts')
</body>
</html>