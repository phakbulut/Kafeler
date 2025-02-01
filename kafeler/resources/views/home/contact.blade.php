@extends('layouts.home')
@section('title', 'İletişim')
@section('content')
    <main class="main">

        <div class="page-title dark-background" data-aos="fade" style="background-image: url(assets/img/page-title-bg.jpg);">

            <div class="container">
                <h1>İletişim</h1>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="{{route('home')}}">Anasayfa</a></li>
                        <li class="current">İletişim</li>
                    </ol>
                </nav>
            </div>
        </div>

        <section id="contact" class="contact section">

            <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">

                <div class="row gy-4">

                    <div class="col-lg-5">
                        <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="200">
                            <i class="bi bi-geo-alt flex-shrink-0"></i>
                            <div>
                                <h3>Adres</h3>
                                <p>

                                    
                                </p>
                            </div>
                        </div>

                        <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                            <i class="bi bi-telephone flex-shrink-0"></i>
                            <div>
                                <h3>Telefon</h3>
                                <p>+90 533 533 33 33</p>
                            </div>
                        </div>

                        <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
                            <i class="bi bi-envelope flex-shrink-0"></i>
                            <div>
                                <h3>E-posta</h3>
                                <p>info@kafeler.test</p>
                            </div>
                        </div>

                    </div>
                    
                    <div class="col-lg-7">
                        <form action="#" method="post" 
                        class="php-email-form" data-aos="fade-up" data-aos-delay="500">
                      @csrf
                      <div class="row gy-4">
                          <div class="col-md-6">
                              <input type="text" name="name" class="form-control" 
                                     placeholder="Adınız" required="">
                          </div>

                          <div class="col-md-6">
                              <input type="email" class="form-control" name="email" 
                                     placeholder="E-posta Adresiniz" required="">
                          </div>

                          <div class="col-md-12">
                              <input type="text" class="form-control" name="subject" 
                                     placeholder="Konu" required="">
                          </div>

                          <div class="col-md-12">
                              <textarea class="form-control" name="message" rows="6" required=""></textarea>
                          </div>

                          <div class="col-md-12 text-center">
                              <button type="submit" class="btn btn-primary">Gönder</button>
                          </div>
                      </div>
                  </form>

                    </div>

                </div>

            </div>

        </section>

    </main>
@endsection