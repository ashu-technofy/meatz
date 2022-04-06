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
            <nav style="background: #000 !important" class="navbar fixed-top navbar-expand-lg">
                <div class="container">
                    <a class="navbar-brand" href="{{url('/')}}#" title=""><img src="{{ url('assets/web') }}/images/logo.png" alt=""></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto p-0 main">
                            <li class="nav-item current">
                                <a class="nav-link" href="{{url('/')}}#home">@lang('Home')</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{url('/')}}#features">@lang('Features')</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{url('/')}}#screenshots">@lang('Screenshots')</a>
                            </li>
                        </ul>
                        <ul class="navbar-nav navbar-right p-0">
                            <li class="nav-item">
                                <a class="nav-link" href="{{url('/')}}#"><i class="fas fa-search"></i></a>
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

        <section id="features" class="section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <img src="{{ $page->image }}" class="mw-100 wow fadeInLeft" data-wow-delay="0.5s">
                    </div>
                    <div class="col-md-6">
                        <div class="text-block">
                            <h2 class="mt-4 mt-sm-0 wow fadeInDown">{{ $page->title }}</h2>
                            <p>{!! $page->content !!}</p>
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
                            <a href="{{url('/')}}#"><img src="{{ url('assets/web') }}/images/logo.png" class="mw-100" alt=""></a>
                        </div>
                        <div class="col-md-6">
                            <ul class="nav footer-nav p-0">
                                <li class="nav-item current">
                                    <a class="nav-link" href="{{url('/')}}#home">@lang('Home')</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{url('/')}}#features">@lang('Features')</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{url('/')}}#screenshots">@lang('Screenshots')</a>
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
    </body>
</html>