@extends('Common::admin.layout.page')
@section('page')

<div class="row">
    <div class="col-md-5 col-sm-12">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">بياناتي</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>اسم العميل</th>
                            <td>{{ $guest->name }}</td>
                        </tr>
                        <tr>
                            <th>رقم الجوال</th>
                            <td>{{ $guest->mobile }}</td>
                        </tr>
                        <tr>
                            <th>البريد الإلكترونى</th>
                            <td>{{ $guest->email }}</td>
                        </tr>
                        <tr>
                            <th>العنوان</th>
                            <td>{{ $guest->full_address }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <div class="col-md-7 col-sm-12">
        <!-- general form elements -->
        <div class="card card-danger">
            <div class="card-header">
                <h3 class="card-title">الطلبات</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-stripped">
                    <thead>
                        <tr>
                            <th>رقم الطلب</th>
                            <th>التاريخ</th>
                            <th>الحالة</th>
                            <th>عرض</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($guest->orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->created_at }}</td>
                            <td>{{ $order->status }}</td>
                            <td><a class="btn btn-primary mlink" href="{{ route("admin.orders.show" , $order->id) }}"><i
                                        class="fa fa-eye"></i> <span>تفاصيل الطلب</span></a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</form>
@stop
