<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{ url('assets/web') }}/css/bootstrap.min.css">
        <link href="{{ url('assets/web') }}/fonts/fontawesome/css/all.min.css" rel="stylesheet">
        <link href="{{ url('assets/web') }}/css/owl.carousel.min.css" rel="stylesheet">
        <link href="{{ url('assets/web') }}/css/owl.theme.default.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ url('assets/web') }}/css/prettyPhoto.css">
        <link href="{{ url('assets/web') }}/css/animate.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ url('assets/web') }}/css/main.css">
        @if(app()->getLocale() == 'ar')
        <link rel="stylesheet" href="{{ url('assets/web') }}/css/rtl.css?ver=1.0">
        <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet"> 
<style>
    *{
        font-family: "Cairo";
    }
</style>
        @endif
        <title>{{ app_setting('title') }}</title>
        <link rel="icon" href="{{ url('assets/web') }}/images/logo.png" type="image/png" sizes="16x16"> 
    </head>
    <body>
        <header>
            <nav class="navbar fixed-top navbar-expand-lg">
                <div class="container">
                    <a class="navbar-brand" href="#" title=""><img src="{{ url('assets/web') }}/images/logo.png" alt=""></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto p-0 main">
                            <li class="nav-item current">
                                <a class="nav-link" href="#home">@lang('Home')</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#features">@lang('Features')</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#screenshots">@lang('Screenshots')</a>
                            </li>
                        </ul>
                        <ul class="navbar-nav navbar-right p-0">
                            <li class="nav-item">
                                <a class="nav-link" href="#"><i class="fas fa-search"></i></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('change_locale') }}"><i class="fas fa-globe-americas"></i> 
                                    <span>{{ app()->getLocale() == 'ar' ? 'EN' : "عربي" }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        
        <div class="cover" id="home">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 cover-caption">
                        <h1 class="wow fadeInUp" data-wow-delay="0.5s">@lang("Get ZWARAH App Now!")</h1>
                        <p class="wow fadeInUp" data-wow-delay="1s">@lang('Available Now on Google Play And App Store')</p>
                        <div class="download-btns wow fadeInUp" data-wow-delay="1.5s">
                            <a href="{{ app_setting('ios') ?? '#' }}" target="_blank" class="mr-sm-4"><img src="{{ url('assets/web') }}/images/app-store-btn.png"></a>
                            <a href="{{ app_setting('android') ?? '#' }}" target="_blank"><img src="{{ url('assets/web') }}/images/google-play-btn.png"></a>
                        </div>
                    </div>
                    <div class="col-sm-6 cover-img text-center">
                        <div class="circle zoomed wow zoomIn" data-wow-delay="0.5s"></div>
                        <div class="circle rotated wow rotateIn" data-wow-delay="1.5s"></div>
                        <img src="{{ url('assets/web') }}/images/cover-screen.png" class="wow rollIn" data-wow-delay="2.5s">
                    </div>
                </div>
            </div>
        </div>
        @if(isset($sections))
        @foreach($sections as  $section)
        <section id="features" class="section {{ $loop->iteration != 1 ? 'bg' : '' }}">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <img src="{{ $section->image }}" class="mw-100 wow {{ $loop->iteration == 1 ? 'fadeIn' : 'fadeInLeft' }}" data-wow-delay="0.5s">
                    </div>
                    <div class="col-md-6">
                        <div class="text-block">
                            <h2 class="mt-4 mt-sm-0 wow fadeInDown">{{ $section->title }}</h2>
                            <p>{!! $section->content !!}</p>
                            <a href="#" class="btn btn-default mt-4">@lang('Discover Now')</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @endforeach
        @endif
        
        <section id="screenshots" class="section">
            <div class="container">
                <div class="text-block">
                    <h2>@lang('Zwarah Screens')</h2>
                </div>
                <div class="owl-carousel owl-theme">
                    <div class="item">
                        <div class="app-image">
    		                <img src="{{ url('assets/web') }}/images/gal-scr1.png" alt="" class="">
                            <div class="preview-icon">
      		                    <a href="images/gal-scr1.png" rel="prettyPhoto[imgs]"><i class="far fa-image"></i></a>
    		                </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="app-image">
    		                <img src="{{ url('assets/web') }}/images/gal-scr2.png" alt="" class="">
                            <div class="preview-icon">
      		                    <a href="images/gal-scr2.png" rel="prettyPhoto[imgs]"><i class="far fa-image"></i></a>
    		                </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="app-image">
    		                <img src="{{ url('assets/web') }}/images/gal-scr3.png" alt="" class="">
                            <div class="preview-icon">
      		                    <a href="images/gal-scr3.png" rel="prettyPhoto[imgs]"><i class="far fa-image"></i></a>
    		                </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="app-image">
    		                <img src="{{ url('assets/web') }}/images/gal-scr4.png" alt="" class="">
                            <div class="preview-icon">
      		                    <a href="images/gal-scr4.png" rel="prettyPhoto[imgs]"><i class="far fa-image"></i></a>
    		                </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="app-image">
    		                <img src="{{ url('assets/web') }}/images/gal-scr2.png" alt="" class="">
                            <div class="preview-icon">
      		                    <a href="images/gal-scr2.png" rel="prettyPhoto[imgs]"><i class="far fa-image"></i></a>
    		                </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="app-image">
    		                <img src="{{ url('assets/web') }}/images/gal-scr3.png" alt="" class="">
                            <div class="preview-icon">
      		                    <a href="images/gal-scr3.png" rel="prettyPhoto[imgs]"><i class="far fa-image"></i></a>
    		                </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="app-image">
    		                <img src="{{ url('assets/web') }}/images/gal-scr1.png" alt="" class="">
                            <div class="preview-icon">
      		                    <a href="images/gal-scr1.png" rel="prettyPhoto[imgs]"><i class="far fa-image"></i></a>
    		                </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="app-image">
    		                <img src="{{ url('assets/web') }}/images/gal-scr4.png" alt="" class="">
                            <div class="preview-icon">
      		                    <a href="images/gal-scr4.png" rel="prettyPhoto[imgs]"><i class="far fa-image"></i></a>
    		                </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="app-image">
    		                <img src="{{ url('assets/web') }}/images/gal-scr3.png" alt="" class="">
                            <div class="preview-icon">
      		                    <a href="images/gal-scr3.png" rel="prettyPhoto[imgs]"><i class="far fa-image"></i></a>
    		                </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="app-image">
    		                <img src="{{ url('assets/web') }}/images/gal-scr2.png" alt="" class="">
                            <div class="preview-icon">
      		                    <a href="images/gal-scr2.png" rel="prettyPhoto[imgs]"><i class="far fa-image"></i></a>
    		                </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <footer>
            <div class="container wow fadeIn" data-wow-delay="1s">
                <div class="footer-top">
                    <div class="row align-items-center">
                        <div class="col-md-4 text-center">
                            <a href="#"><img src="{{ url('assets/web') }}/images/logo.png" class="mw-100" alt=""></a>
                        </div>
                        <div class="col-md-6">
                            <ul class="nav footer-nav p-0">
                                <li class="nav-item current">
                                    <a class="nav-link" href="#home">@lang('Home')</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#features">@lang('Features')</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#screenshots">@lang('Screenshots')</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-2 text-sm-right text-center">
                            <ul class="list-unstyled mb-0 p-0 footer-social">
                                @foreach(socials() as $row)
                                @if(strpos($row->value , 'http') !== false)
                                    <li class="d-inline-block"><a href="{{ $row->value }}" target="_blank"><i class="fab fa-{{ $row->key }} {{ $row->key }}-f"></i></a></li>
                                @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            
                <div class="footer-bottom">
                    <p class="text-white text-center mb-0">@lang('All rights reserved') © {{ date('Y') }} </p>    
                </div>
            </div>
        </footer>
        
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
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
            
            $('.owl-carousel').owlCarousel({
                rtl:true,
                loop:true,
                margin:20,
                autoplay:true,
                nav:false,
                navText: ["<i class='fa fa-chevron-right' aria-hidden='true'>", "<i class='fa fa-chevron-left' aria-hidden='true'>"],
                responsive:{
                    0:{
                        items:1
                    },
                    600:{
                        items:3
                    },
                    1000:{
                        items:4
                    }
                }
            })
            $("a[rel^='prettyPhoto']").prettyPhoto({
        		opacity:'0.95',
        		slideshow:'5000'
        	});
            
            $('.navbar-nav.main').onePageNav();
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