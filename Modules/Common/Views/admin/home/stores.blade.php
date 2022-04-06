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
                            <th>@lang('Name')</th>
                            <th>@lang('Created at')</th>
                            <th>@lang('Orders count')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stores as $store)
                        <tr>
                            <td><a href="{{ route('admin.stores.show' , $store->id) }}"
                                    class="mlink">{{ $store->name->{app()->getLocale()} ?? $store->id }}</a></td>
                            <td>{{ $store->created_at }}</td>
                            <td>{{ $store->orders()->count() ?? '' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">
            <a href="{{ route('admin.stores.index') }}" class="mlink btn btn-sm btn-default btn-flat pull-left">@lang('View all')</a>
        </div>
        <!-- /.box-footer -->
    </div>
    <!-- /.box -->
</div>