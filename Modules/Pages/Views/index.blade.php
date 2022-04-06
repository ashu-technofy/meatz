@extends('Common::web.layout.index')
@section('title' , $info->title)
@section('page')
<!-- content -->
<section class="sec-padd">
    <div class="container">
        <div class="row div-dir-pp">
            <div class="col-lg-10 offset-lg-1">
                <div class="privacy-policy">
                    {!! $info->content !!}
                </div>
            </div>
        </div>
    </div>
</section>

@stop