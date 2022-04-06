@extends('Common::admin.layout.page')
@section('page')
<!-- Small boxes (Stat box) -->
<div class="row">
    @foreach($counters as $count)
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-{{ $count['type'] }}">
            <div class="inner">
                <h3>{{ $count['count'] }}</h3>

                <p>{{ $count['title'] }}</p>
            </div>
            <div class="icon">
                <i class="ion fas {{ $count['icon'] }}"></i>
            </div>
            <a href="{{ $count['url'] }}" class="small-box-footer mlink">@lang('More') <i
                    class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    @endforeach
</div>
<!-- /.row -->
<div class="row">
    <div class="col-sm-12">
        <!-- solid sales graph -->
        <div class="card bg-gradient-info">
            <div class="card-header border-0">
                <h3 class="card-title">
                    <i class="fas fa-th mr-1"></i>
                    @lang('Total sales')
                </h3>

                <div class="card-tools">
                    <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn bg-info btn-sm" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <canvas class="chart" id="line-chart"
                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
            <!-- /.card-body -->
            <div class="card-footer bg-transparent">
                <div class="row">
                    <div class="col-4 text-center">
                        <input type="text" class="knob" data-readonly="true" value="{{ $orders['completed'] }}"
                            data-width="60" data-height="60" data-fgColor="#39CCCC">

                        <div class="text-white">@lang('Completed')</div>
                    </div>
                    <!-- ./col -->
                    <div class="col-4 text-center">
                        <input type="text" class="knob" data-readonly="true" value="{{ $orders['pending'] }}"
                            data-width="60" data-height="60" data-fgColor="#39CCCC">

                        <div class="text-white">@lang('Inprogresss')</div>
                    </div>
                    <!-- ./col -->
                    <div class="col-4 text-center">
                        <input type="text" class="knob" data-readonly="true" value="{{ $orders['not'] }}"
                            data-width="60" data-height="60" data-fgColor="#39CCCC">

                        <div class="text-white">@lang('Wait payment')</div>
                    </div>
                    <!-- ./col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.card-footer -->
        </div>
        <!-- /.card -->
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <!-- TABLE: LATEST ORDERS -->
        <div class="card">
            <div class="card-header border-transparent">
                <h3 class="card-title">@lang('Latest orders')</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table m-0">
                        <thead>
                            <tr>
                                <th>@lang('Order ID')</th>
                                <th>@lang('Client')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Total')</th>
                                <th>@lang('Created at')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($latest_orders as $order)
                            <tr>
                                <td><a class="mlink"
                                        href="{{ route('admin.orders.show' , $order->id) }}">{{ $order->id }}#</a></td>
                                <td>{{ $order->myuser->name }}</td>
                                <td><span class="badge badge-{{ $order->badge }}">{{ $order->status }}</span></td>
                                <td>
                                    {{ $order->total }}
                                </td>
                                <td>{{ $order->created_at }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                <a href="{{ route('admin.orders.index') }}"
                    class="mlink btn btn-sm btn-secondary float-right">@lang('Show all')</a>
            </div>
            <!-- /.card-footer -->
        </div>
        <!-- /.card -->
    </div>

    <div class="col-sm-6">
        <!-- PRODUCT LIST -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">@lang('Latest products')</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <ul class="products-list product-list-in-card pl-2 pr-2">
                    @foreach($products as $product)
                    <li class="item">
                        <div class="product-img">
                            <img src="{{ $product->image }}" alt="Product Image" class="img-size-50">
                        </div>
                        <div class="product-info">
                            <a href="{{ route('admin.products.edit' , $product->id) }}"
                                class="product-title mlink">{{ $product->name->{app()->getLocale()} }}
                                <span class="badge badge-warning float-right">{{ $product->price }} @lang('KD')</span></a>
                            <span class="product-description">
                                {{ mb_substr(strip_tags($product->brief->ar) , 0 , 100) }} ...
                            </span>
                        </div>
                    </li>
                    <!-- /.item -->
                    @endforeach
                </ul>
            </div>
            <!-- /.card-body -->
            <div class="card-footer text-center">
                <a href="{{ route('admin.products.index') }}" class="uppercase mlink">@lang("Show all")</a>
            </div>
            <!-- /.card-footer -->
        </div>
        <!-- /.card -->
    </div>
</div>

<script>
    $('.knob').knob();

    // Sales graph chart
    var salesGraphChartCanvas = $('#line-chart').get(0).getContext('2d');
    //$('#revenue-chart').get(0).getContext('2d');
    var sales = JSON.parse("{{ json_encode($sales) }}");
    var salesGraphChartData = {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [{
            label: 'إجمالى المبيعات',
            fill: false,
            borderWidth: 2,
            lineTension: 0,
            spanGaps: true,
            borderColor: '#efefef',
            pointRadius: 3,
            pointHoverRadius: 7,
            pointColor: '#efefef',
            pointBackgroundColor: '#efefef',
            data: sales
        }]
    }

    var salesGraphChartOptions = {
        maintainAspectRatio: false,
        responsive: true,
        legend: {
            display: false,
        },
        scales: {
            xAxes: [{
                ticks: {
                    fontColor: '#efefef',
                },
                gridLines: {
                    display: false,
                    color: '#efefef',
                    drawBorder: false,
                }
            }],
            yAxes: [{
                ticks: {
                    stepSize: 5000,
                    fontColor: '#efefef',
                },
                gridLines: {
                    display: true,
                    color: '#efefef',
                    drawBorder: false,
                }
            }]
        }
    }

    // This will get the first returned node in the jQuery collection.
    var salesGraphChart = new Chart(salesGraphChartCanvas, {
        type: 'line',
        data: salesGraphChartData,
        options: salesGraphChartOptions
    });

</script>
@endsection
