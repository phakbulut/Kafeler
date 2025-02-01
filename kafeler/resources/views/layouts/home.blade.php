<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ env('APP_META_DESCRIPTION') }}">
    <meta name="keywords" content="{{ env('APP_META_KEYWORDS') }}">
    <meta name="author" content="{{ env('APP_META_AUTHOR') }}">
    <title>{{ env('APP_NAME') }} - @yield('title')</title>
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap"
        rel="stylesheet">

    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    @yield('styles')
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">

</head>
<body class="index-page">

    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

            <div class="container center">

                <a href="{{route('home')}}">
                <img src="{{ asset(env('APP_LOGO')) }}" alt="{{ env('APP_NAME') }}" class="img-fluid mx-auto d-block" style="max-width: 200px; height: 100px;">
            </a>
            </div>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="#">Kafeler</a></li>



                    <li><a href="{{route('contact')}}">İletişim</a></li>
                    <li><a href="{{route('login')}}">Giriş Yap</a></li>
                    <li><a href="{{route('register')}}">Kaydol</a></li>

                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

        </div>
    </header>
    <main class="main">

            @yield('content')

    </main>

    <footer id="footer" class="footer light-background">

        <div class="footer-top">
            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-4 col-md-12 footer-about">
                        <a href="index.html" class="logo d-flex align-items-center">
                            <span class="sitename">Kafeler</span>
                        </a>
                        <p>{{env('APP_META_DESCRIPTION')}}</p>
                        <div class="social-links d-flex mt-4">
                            <a href=""><i class="bi bi-twitter-x"></i></a>
                            <a href=""><i class="bi bi-facebook"></i></a>
                            <a href=""><i class="bi bi-instagram"></i></a>
                            <a href=""><i class="bi bi-linkedin"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-10 footer-links text-center">
                       <br>
                        <h4>Sizinde kafeniz burada gözüksün istemez misiniz</h4>

                    </div>

                    <div class="col-lg-2 col-6 footer-links">

                    </div>

                    <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
                        <h4>Bizimle İletişime Geçin</h4>
                        <p>Musalla Bağları Mah Kule Cad</p>
                        <p>Musalla Mezarlığı</p>
                        <p>Tahtalıköy / Dünya</p>
                        <p class="mt-4"><strong>Telefon:</strong> <span>+90 533 533 33 33</span></p>
                        <p><strong>E-posta:</strong> <span>info@kafeler.test</span></p>
                    </div>

                </div>
            </div>
        </div>

        <div class="container copyright text-center">
            <p>© <span>Telif Hakkı</span> <strong class="px-1 sitename">Kafeler®</strong> <span>Tüm Hakları
                    Saklıdır</span></p>
            <div class="credits">
               Tasarım: <a href="https://greensky.com.tr/">İbrahim Akbulut</a>
            </div>
        </div>

    </footer>

    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
        class="bi bi-arrow-up-short"></i></a>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    @yield('scripts')
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
<script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
<script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
<script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
<script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>

</body>
</html>
