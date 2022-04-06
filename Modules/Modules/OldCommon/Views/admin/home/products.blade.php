<div class="col-lg-12 col-xl-6">
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">@lang('New Products')</h3>

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
                            <th>@lang('Type')</th>
                            <th>@lang('Orders count')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td><a href="{{ route('admin.products.show' , $product->id) }}"
                                    class="mlink">{{ $product->name->{app()->getLocale()} }}</a></td>
                            <td>{{ $product->category->name->{app()->getLocale()} ?? '' }}</td>
                            <td>{{ $product->orders()->count() ?? '' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">
            <a href="{{ isset($store) ? route('admin.products.index' , ['store_id' => $store->id]) : route('admin.products.index') }}" class="mlink btn btn-sm btn-default btn-flat pull-left">@lang('View all')</a>
        </div>
        <!-- /.box-footer -->
    </div>
    <!-- /.box -->
</div>