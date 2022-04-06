<div class="col-lg-12 col-xl-6">
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">@lang('New Orders')</h3>

            <div class="box-tools pull-left">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-responsive no-margin" style="height: 515px">
                    <thead>
                        <tr>
                            <th>@lang('ID')</th>
                            <th>@lang('Client')</th>
                            <th>@lang('Total')</th>
                            <th>@lang('Status')</th>
                            <th>@lang('Created at')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td><a href="{{ route('admin.orders.show', $order->id) }}"
                                        class="mlink">{{ $order->id }}</a></td>
                                <td>{{ $order->myuser->username ?? '' }}</td>
                                <td>{{ $order->total ?? '' }}</td>
                                <td>{!! $order->badge !!}</td>
                                <td>{{ $order->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">
            <a href="{{ route('admin.orders.index') }}"
                class="mlink btn btn-sm btn-default btn-flat pull-left">@lang('View all')</a>
        </div>
        <!-- /.box-footer -->
    </div>
    <!-- /.box -->
</div>
