<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="icon" href="{{ app_setting('favicon') }}">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{ url('assets/web') }}/css/bootstrap.min.css">
        @if(app()->getLocale() == 'ar')
        <link rel="stylesheet" href="{{ url('assets/web') }}/css/bootstrap-rtl.css">
        @endif
        <script src="https://kit.fontawesome.com/6b5da72e5f.js" crossorigin="anonymous"></script>
        <link href="{{ url('assets/web') }}/css/animate.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ url('assets/web') }}/css/main.css">
        @if(app()->getLocale() == 'ar')
        <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ url('assets/web') }}/css/rtl.css">
        <style>
            *{
                font-family: 'Cairo', sans-serif;
            }
        </style>
        @endif
        <title>Meatz App</title>
    </head>
    <body>
        <header>
            <nav class="navbar fixed-top navbar-expand-md">
                <div class="container px-0">
                    <div class="col-md-4">
                        <a class="navbar-brand" href="#" title=""><img src="{{ url('assets/web') }}/images/logo.png" alt=""></a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>
                    <div class="col-md-8">
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav mr-auto p-0">
                                <li class="nav-item current">
                                    <a class="nav-link" href="#home">@lang('Home')</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#features">@lang('Features')</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#about">@lang('About Us')</a>
                                </li>
                            </ul>
                            <div class="lang"><a href="{{ route('change_locale') }}" title="العربية"><i class="fas fa-globe"></i> العربية</a></div>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        
        <div class="cover" id="home">
            <div class="container">
                <div class="row align-items-start flex-sm-row flex-column-reverse">
                    <div class="col-lg-5 col-sm-7 text-block">
                        <h2 class="wow fadeInUp" data-wow-delay="0.5s">@lang('Get Meatz App Now!')</h2>
                        <p class="mb-5 wow fadeInUp" data-wow-delay="1s">@lang('Available on Google Play and App Store')</p>
                        <div class="download-btns wow fadeInUp" data-wow-delay="1.5s">
                            <a href="{{ app_setting('ios') }}" class="mr-sm-4"><img src="{{ url('assets/web') }}/images/app-store-btn.png"></a>
                            <a href="{{ app_setting('android') }}"><img src="{{ url('assets/web') }}/images/google-play-btn.png"></a>
                        </div>
                    </div>
                    <div class="col-lg-7 col-sm-5">
                        <div class="image-wrapper text-center">
                            <img src="{{ url('assets/web') }}/images/splash.png" class="mw-100 wow fadeInLeft" data-wow-delay="0.5s">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <section id="features" class="mt-sm-0 mt-4">
            <div class="container">
                @foreach($features as $row)
                <div class="row align-items-center text-sm-left text-center">
                    <h2 class="title left">@lang('Features')</h2>
                    <div class="col-lg-6 col-sm-5 text-center">
                        <div class="image-wrapper text-center">
                            <img src="{{ $row->image }}" class="mw-100 wow {{ $loop->iteration % 2 == 0 ? 'fadeInRight' : 'fadeInLeft' }}" data-wow-delay="0.5s">
                        </div>
                    </div>
                    <div class="col-lg-5 col-sm-7 offset-lg-1 mt-sm-0 mt-4">
                        <div class="text-block">
                            <h2>{{ $row->title }}</h2>
                            <p>{!! $row->content !!}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        
        <section id="about">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-block">
                            <h2 class="text-white">@lang('About Meatz')</h2>
                            <p class="text-white">{!! $about !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <section class="phone-vertical text-center">
            <div class="container">
                <div class="image-wrapper">
                    <img src="{{ url('assets/web') }}/images/phone-vertical.png" class="mw-100 wow fadeInUp" data-wow-delay="0.5s">
                </div>
                <div class="download-btns wow fadeInUp" data-wow-delay="0.5s">
                    <a href="#" class="mr-sm-4"><img src="{{ url('assets/web') }}/images/app-store-btn.png"></a>
                    <a href="#"><img src="{{ url('assets/web') }}/images/google-play-btn.png"></a>
                </div>
            </div>
        </section>
        
        <footer>
            <div class="container wow fadeIn" data-wow-delay="0.5s">
                <div class="footer-top">
                    <div class="row align-items-center">
                        <div class="col-lg-4 col-md-2 text-center text-sm-left">
                            <a href="#"><img src="{{ url('assets/web') }}/images/logo.png" class="footer-logo" alt=""></a>
                        </div>
                        <div class="col-lg-6 col-md-7">
                            <ul class="nav footer-nav p-0">
                                <li class="nav-item current">
                                    <a class="nav-link" href="#">@lang('Home')</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">@lang('Features')</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">@lang('About Us')</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-2 col-md-3 text-center">
                            <ul class="list-unstyled mb-0 mt-sm-0 mt-4 p-0 footer-social">
                                <li class="d-inline-block"><a href="{{ app_setting('twitter') }}"><i class="fab fa-twitter"></i></a></li>
                                <li class="d-inline-block"><a href="{{ app_setting('instagram') }}"><i class="fab fa-instagram"></i></a></li>
                                <li class="d-inline-block"><a href="{{ app_setting('facebook') }}"><i class="fab fa-facebook-square"></i></a></li>
                            </ul>
                        </div>
                        
                        
                    </div>
                </div>
                
                <div class="footer-bottom">
                    <div class="container wow fadeIn" data-wow-delay="0.5s">
                        <p class="text-center mb-0">@lang('All rights reserved to') Meatz © 2021</p>
                    </div>
                </div>
            </div>
        </footer>
        
        <!-- Optional JavaScript -->
        <script src="{{ url('assets/web') }}/js/jquery.min.js"></script>
        <script src="{{ url('assets/web') }}/js/popper.min.js"></script>
        <script src="{{ url('assets/web') }}/js/bootstrap.min.js"></script>
        <script src="{{ url('assets/web') }}/js/owl.carousel.min.js"></script>
        <script src="{{ url('assets/web') }}/js/jquery.prettyPhoto.js"></script>	
        <script src="{{ url('assets/web') }}/js/pace.min.js"></script>
        <script src="{{ url('assets/web') }}/js/wow.min.js"></script>
        <script src="{{ url('assets/web') }}/js/jquery.nav.js"></script>
        <script>
            new WOW().init();
            $('[data-toggle="tooltip"]').tooltip();
            
            $('.navbar-nav').onePageNav();
            
            $(window).scroll(function (event) {
                var scroll = $(window).scrollTop();
                if(scroll > 0){
                    $('.navbar').addClass("navbar-sticky");
                }
                else{
                    $('.navbar').removeClass("navbar-sticky");
                }
            });
        </script>
    </body>
</html>