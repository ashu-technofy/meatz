@extends('Common::web.layout.index')
@section('title' , __('Contact us'))
@section('js_files')
<script type="text/javascript" src='https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_APP_KEY') }}&sensor=false&language={{ app()->getLocale() }}'>
                    </script>
@if($errors->count() || session('sent') == 'success')
<script>
    $(document).ready(function(){
        $('body').animate({
            scrollTop: $(".contact-row").offset().top
        }, 1000);
    });
</script>
@endif
@stop
@section('page')
@foreach($offices as $office)
<!-- content -->
<section class="sec-padd">
    <div class="container">
        <div class="row m-0 contact-info">
            <div class="col-lg-4">
                <div class="contact-widget">
                    <div class="contact-box d-flex">
                        <i class="fa fa-map-marker"></i>
                        <div class="contact-data">
                            <h4>{{ $office->name }}</h4>
                            <span>
                                {{ $office->address }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="contact-widget">
                    <div class="contact-box d-flex">
                        <i class="fas fa-envelope-open-text"></i>
                        <div class="contact-data">
                            <h4>@lang('Email Address')</h4>
                            <span>
                                <a href="mailto:{{ $office->email }}">{{ $office->email }}</a>
                            </span>
                        </div>
                    </div>
                    <div class="contact-box d-flex">
                        <i class="fas fa-address-book"></i>
                        <div class="contact-data">
                            <h4>@lang('Mobile Number')</h4>
                            <span>
                                <a href="tel:{{ $office->mobile }}">{{ $office->mobile }}</a>
                            </span>
                        </div>
                    </div>
                    <div class="contact-box d-flex">
                        <i class="fa fa-whatsapp"></i>
                        <div class="contact-data">
                            <h4>@lang('Whatsapp Number')</h4>
                            <span>
                                <a href="https://wa.me/{{ $office->whatsapp }}">{{ $office->whatsapp }}</a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="contact-widget border-0">
                    <div class="contact-box d-flex">
                        <i class="fas fa-business-time"></i>
                        <div class="contact-data">
                            <h4>@lang('Working Days')</h4>
                            <span>
                                @foreach(week_days() as $day)
                                @lang($day) : @lang('From') {{ hours()[$office->working_from] }} @lang('To')
                                {{ hours()[$office->working_to] }} <br>
                                @endforeach
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- content -->
<section class="map">
    <div class="container-fluid">
        <div class="row">
            <div id="mymap{{ $office->id }}" style="width: 100%; height:500px;"></div>
            <script>
                function initMap() {
                    const myLatLng = { lat: parseFloat("{{ $office->location->lat ?? '' }}"), lng: parseFloat("{{ $office->location->lng ?? '' }}") };
                    console.log(myLatLng);
                    const map = new google.maps.Map(document.getElementById("mymap{{ $office->id }}"), {
                        zoom: 8,
                        center: myLatLng,
                    });
                    new google.maps.Marker({
                        position: myLatLng,
                        map,
                        title: "Hello World!",
                    });
                }
                $(document).ready(function(){
                    initMap();
                });
            </script>
        </div>
    </div>
</section>
@endforeach

<!-- content -->
<section class="sec-padd">
    <div class="container">
        <div class="row contact-row">
            @if(session('sent') == 'success')
            <div class="col-lg-12 text-center">
                <img class="success-img" src="{{ url('assets/web/') }}/img/contact-success.png">
            </div>
            @else
            <div class="col-lg-12">
                <h1 class="title text-center text-dark">@lang('Get In Touch')</h1>
            </div>
            <div class="col-lg-7 mx-auto">
                <form class="checkout-form" id="contact" method="post" action="{{ route('contactus.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <input value="{{ old('first_name') }}" type="text" name="first_name" id="contact_name"
                                    class="form-control" placeholder="{{ __('First Name') }}*" required>
                                <i class="fas fa-user"></i>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <input value="{{ old('last_name') }}" type="text" id="contact_lname" name="last_name"
                                    class="form-control" placeholder="{{ __('Last Name') }}*" required>
                                <i class="fas fa-user"></i>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <input value="{{ old('email') }}" type="text" name="email" id="contact_email"
                                    class="form-control" placeholder="{{ __('Email') }}({{ __('optional') }})">
                                <i class="fas fa-at"></i>
                                @if($errors->has('email'))
                                <span class="error">{{ $errors->get('email')[0] }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <input value="{{ old('mobile') }}" type="text" class="form-control" id="contact_number"
                                    name="mobile" placeholder="{{ __('Phone Number') }}*" required>
                                <i class="fas fa-phone-alt"></i>
                                                @if($errors->has('mobile'))
                                                <span class="error">{{ $errors->get('mobile')[0] }}</span>
                                                @endif
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group text-area">
                                <textarea name="message" cols="4" rows="4" required class="form-control"
                                    placeholder="{{ __('Type Your Message') }}">{{ old('message') }}</textarea>
                                <i class="fas fa-comments-alt"></i>
                            </div>
                        </div>
                        <script src="//www.google.com/recaptcha/api.js" async defer></script>
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <div class="g-recaptcha" data-sitekey="6Lfh_94ZAAAAAF0iWTxIPuR-gT0EN5ZhL_yrfYcP"></div>
                            </div>
                        </div>
                    </div>
                    <div id="contact_submit">
                        <button class="border-btn" type="submit" onsubmit="">@lang('send message')</button>
                    </div>
                </form>
            </div>
            @endif
        </div>
    </div>
</section>

@stop