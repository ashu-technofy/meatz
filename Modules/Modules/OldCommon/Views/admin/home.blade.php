@extends('Common::admin.layout.page')
@section('page')
<link rel="stylesheet" href="{{ url('/') }}/assets/admin/vendor_components/Ionicons/css/ionicons.css">
<!-- ChartJS -->
<script src="{{ url('/') }}/assets/admin/vendor_components/chart-js/chart.js"></script>
<script src="{{ url('/') }}/assets/admin/js/pages/dashboard2.js"></script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="margin:0px">
    <!-- Main content -->
    <section class="content">
        @include('Common::admin.home.boxes')
        @if(1 != 1)
        @include('Common::admin.home.monthly_orders')
        @endif
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <div class="col-sm-12">
                <div class="row">
                    @if(isset($orders))
                    @include('Common::admin.home.orders')
                    @endif

                    @if(isset($products))
                    @include('Common::admin.home.products')
                    @endif
                </div>
                <!-- /.row -->
            
                <div class="col-ms-12">
                    <div class="row">
                        @if(isset($stores))
                        @include('Common::admin.home.stores')
                        @endif

                        @if(isset($counters))
                        @include('Common::admin.home.counter')
                        @endif
                    </div>
                </div>
            </div>
            <!-- /.col -->

        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>

@endsection