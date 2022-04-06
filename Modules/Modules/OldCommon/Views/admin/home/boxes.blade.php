<!-- Info boxes -->
<div class="row">
    @foreach($boxes as $box)
    <div class="col-12 col-md-6 col-lg-3">
        <a class="mlink" href="{{ $box['url'] }}">
            <div class="info-box">
                <span class="info-box-icon bg-{{ $box['type'] }}"><i class="fa {{ $box['icon'] }}"></i></span>

                <div class="info-box-content">
                    <span class="info-box-number">{{ $box['count'] }}<small></small></span>
                    <span class="info-box-text">{{ $box['title'] }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </a>
    </div>
    @endforeach
</div>
<!-- /.row -->