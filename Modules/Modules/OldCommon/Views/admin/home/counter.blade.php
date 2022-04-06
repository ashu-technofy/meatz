<div class="col-lg-6">
    @foreach($counters as $counter)
    <!-- Info Boxes Style 2 -->
    <div class="info-box bg-{{{$counter['color'] }}}">
    <span class="info-box-icon push-bottom"><i class="fas {{ $counter['icon'] }}"></i></span>

        <div class="info-box-content">
            <span class="info-box-text">{{ $counter['title'] }}</span>
            <span class="info-box-number">{{ $counter['count'] }}</span>

            <div class="progress">
                <div class="progress-bar" style="width: {{ $counter['width'] }}%"></div>
            </div>
            <span class="progress-description">
                {{ number_format($counter['width'] , 2) }}% @lang("Increase in 30 Days")
            </span>
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
    @endforeach
</div>
<!-- /.col -->