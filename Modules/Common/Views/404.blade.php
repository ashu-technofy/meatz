@extends('welcome')
@section('title' , __('Sorry Page Not Found'))
@section('page')
<!-- content -->
<section class="error-sec">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-12 text-center">
        <img src="{{ url('assets/web') }}/img/404-img.png">
          <h1 class="title text-center mt-5">
            {{ __('Sorry Page Not Found') }}
          </h1>
        </div>
      </div>
    </div>
  </section>
@stop