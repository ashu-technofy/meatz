@extends('Common::admin.layout.page')
@section('page')
<style>
    @media print {
        body {
            -webkit-print-color-adjust: exact;
        }
    }

    .order_bill th {
        width: 35%;
    }
</style>
<div class="row">
    <div class="col-md-6 col-sm-12">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">@lang('Order Details')</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-stripped">
                    <tbody>
                        <tr>
                            <th>@lang("Order ID")</th>
                            <td>{{ $order->code ?? "MZ".$order->id }}</td>
                        </tr>
                        @if($order->status == 'Canceled')
                        <tr>
                            <th>@lang('Status')</th>
                            <td>
                                @lang('Canceled')
                            </td>
                        </tr>
                        @else
                        <tr>
                            <th>@lang('Status')</th>
                            <td>
                                <select {{ $order->status == 'cancel_request' ? 'readonly' : '' }} name="status" class="form-control" id="order_status" data-id="{{ $order->id }}">
                                    @php $statuses = order_statuses(); if(auth('stores')->check()) { unset($statuses[3]);} @endphp
                                    @foreach($statuses as $status)
                                    <option {{ $order->current_status == $status ? 'selected' : '' }} value="{{ $status }}">
                                        @lang($status)
                                    </option>
                                    @endforeach
                                    @if($order->status == 'cancel_request')
                                        <option selected disabled>@lang('Cancel Request')</option>
                                    @endif
                                </select>
                            </td>
                        </tr>
                        @endif
                        @if($order->cancel_request == 1 && auth()->user())
                        <tr>
                            <th>@lang('Cancellation Request')</th>
                            <td>
                                <div class="row">
                                    <div class="col-sm-12">
                                        @if($order->user)
                                        <a class="btn btn-success accept_request" href="{{ route('admin.orders.cancel_request' , [$order->id , 'accept']) }}">
                                            <i class="fa fa-check"></i>
                                            {{ __('Refund to wallet') }}
                                        </a>
                                        <a class="btn btn-primary accept_request" href="{{ route('admin.orders.cancel_request' , [$order->id , 'accept' , 'refund' => 1]) }}">
                                            <i class="fa fa-check"></i>
                                            {{ __('Refund to bank') }}
                                        </a>
                                        @else
                                        <a class="btn btn-primary accept_request" href="{{ route('admin.orders.cancel_request' , [$order->id , 'accept' , 'refund' => 1]) }}">
                                            <i class="fa fa-check"></i>
                                            {{ __('Refund to bank') }}
                                        </a>
                                        @endif
                                        <a class="btn btn-danger accept_request" href="{{ route('admin.orders.cancel_request' , [$order->id , 'reject']) }}">
                                            <i class="fa fa-times"></i>
                                            @lang('Reject')
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <th>@lang('Order Type')</th>
                            <td>{{ $order->type != 'now' ? __("Deliver Later") : __("Deliver Now") }}</td>
                        </tr>
                        <tr>
                            <th>@lang('Vendor')</th>
                            <td>{{ $order->store->name->ar ?? 'Meatz' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('Payment method')</th>
                            <td>{{ __(ucfirst($order->payment_method)) }}</td>
                        </tr>
                        @if($order->payment_method != 'cash')
                            <tr>
                                <th>@lang('Paid')</th>
                                <td>{{ $order->payment_method != 'cash' ? __('Yes') : __('No') }}</td>
                            </tr>
                            @if($order->payment_id)
                            <tr>
                                <th>@lang('Payment ID')</th>
                                <td>{{ $order->payment_id }}</td>
                            </tr>
                            @endif
                            @if($order->transaction_id)
                            <tr>
                                <th>@lang('Transaction ID')</th>
                                <td>{{ $order->transaction_id }}</td>
                            </tr>
                            @endif
                            @if($order->refund_refrence)
                            <tr>
                                <th>@lang('Refund Ref')</th>
                                <td>{{ $order->refund_refrence }}</td>
                            </tr>
                            @endif
                        @endif
                        <tr>
                            <th>@lang('Total')</th>
                            <td>{{ $order->total }}</td>
                        </tr>
                        <tr>
                            <th>@lang('Sub total')</th>
                            <td>{{ $order->subtotal }}</td>
                        </tr>
                        <tr>
                            <th>@lang('Delivery type')</th>
                            <td>{{ $order->delivery_type == 'express' ? __('Express') : __('Normal') }}</td>
                        </tr>
                        <tr>
                            <th>@lang('Delivery')</th>
                            <td>{{ $order->delivery }}</td>
                        </tr>
                        @if($order->delivery_date)
                        <tr>
                            <th>@lang('Delivery date')</th>
                            <td>{{ $order->delivery_date }}</td>
                        </tr>
                        @endif
                        @if($order->delivery_time && $order->delivery_type != 'express')
                        <tr>
                            <th>@lang('Delivery time')</th>
                            <td>{{ $order->delivery_time }}</td>
                        </tr>
                        @endif
                        @if($order->copon)
                        <tr>
                            <th>@lang('Copon')</th>
                            <td>{{ $order->copon->code ?? "" }}</td>
                        </tr>
                        @endif
                        <tr>
                            <th>@lang('Notes')</th>
                            <td>{{ $order->notes }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-12">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">@lang('Client information')</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>@lang('Client name')</th>
                            <td>{{ $order->myuser->username }}</td>
                        </tr>
                        <tr>
                            <th>@lang('Phone') </th>
                            <td>{{ $order->myuser->mobile }}</td>
                        </tr>
                        <tr>
                            <th>@lang('Email')</th>
                            <td>{{ $order->myuser->email }}</td>
                        </tr>
                        <tr>
                            
                            <th>@lang('Address')</th>
                            <td>{!! $order->address->full_address ?? $order->guest->address ?? '' !!}</td>
                          
                        </tr>
                        <tr>
                            <th>@lang('Notes')</th>
                            <td>{{ $order->address->address['notes'] ?? '' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <div class="col-md-6 col-sm-12">
        <!-- general form elements -->
        <div class="card card-danger">
            <div class="card-header">
                <h3 class="card-title">@lang('Products')</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-stripped">
                    <thead>
                        <tr>
                            <th>@lang('Image')</th>
                            <th>@lang('Product name')</th>
                            <th>@lang('Store')</th>
                            <th>@lang('Options')</th>
                            <th>@lang('Price')</th>
                            <th>@lang('Count')</th>
                            <th>@lang('Status')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->myproducts as $item)
                        <tr>
                            <td><img src="{{ $item['image'] }}" height="100px"></td>
                            <td>{{ $item['title'] }}</td>
                            <td>{{ $item['store'] ? $item['store']->name->{app()->getLocale()} : '' }}</td>
                            <td>
                                @foreach($item['options'] as $row)
                                    @if($row->name)
                                    <li>{{ $row->name->ar }}</li>
                                    @endif
                                @endforeach
                            </td>
                            <td>{{ $item['total'] }}</td>
                            <td>{{ $item['count'] }}</td>
                            <td>@lang($item['status'])</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-12">
        <!-- general form elements -->
        <div class="card card-danger">
            <div class="card-header">
                <h3 class="card-title">الفاتورة</h3>
                <a style="float: left; cursor: pointer;" class="btn btn-success print_bill"><i
                        class="fa fa-print"></i></a>
            </div>
            <div class="card-body order_bill">
                <table class="table table-bordered table-stripped">
                    <thead>
                        <tr>
                            <th class="bill_title" colspan="2">الفاتورة</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>رقم الطلب <br /> {{ $order->code ?? "MZ".$order->id }}</th>
                            <th>تاريخ الطلب <br /> {{ date('Y/m/d', strtotime($order->created_at)) }}</th>
                        </tr>
                        <tr>
                            <th>ساعة الطلب</th>
                            <td>{{ date('h:i a', strtotime($order->created_at)) }}</td>
                        </tr>
                        <tr>
                            <th>تاريخ وصول الطلب</th>
                            <td>{{ $order->delivery_date }}</td>
                        </tr>
                        <tr>
                            <th>@lang('Payment method')</th>
                            <td>{{ __(ucfirst($order->payment_method)) }}</td>
                        </tr>
                        <tr>
                            <th>@lang('Delivery type')</th>
                            <td>{{ $order->delivery_type == 'express' ? __('Express') : __('Normal') }}</td>
                        </tr>
                        @if($order->delivery_date)
                        <tr>
                            <th>@lang('Delivery date')</th>
                            <td>{{ $order->delivery_date }}</td>
                        </tr>
                        @endif
                        @if($order->delivery_time && $order->delivery_type != 'express')
                        <tr>
                            <th>@lang('Delivery time')</th>
                            <td>{{ $order->delivery_time }}</td>
                        </tr>
                        @endif
                        <tr>
                            <th>عنوان العميل</th>
                            <td>{!! $order->address->full_address ?? $order->guest->address ?? '' !!}</td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-bordered table-stripped bill_items">
                    <thead>
                        <tr>
                            <th>الصنف</th>
                            <th>المتجر</th>
                            <th>الإضافات</th>
                            <th>السعر</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->myproducts as $item)
                        <tr>
                            <th>{{ $item['title'] }} <br /> الكمية المطلوبة : {{ $item['count'] }}</th>
                            <td>
                                {{ $item['store'] ? $item['store']->name->{app()->getLocale()} : '' }}
                                <br>
                                {{ $item['store'] && $item['store']->address ? $item['store']->address->{app()->getLocale()} : '' }}
                            </td>
                            <th>
                                @foreach($item['options'] as $row)
                                    @if($row->name)
                                    <li>{{ $row->name->ar }}</li>
                                    @endif
                                @endforeach
                            </th>
                            
                            <th>{{ $item['total'] }}</th>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>طريقة الدفع</th>
                            <td colspan="3">{{ __(ucfirst($order->payment_method)) }}</td>
                        </tr>
                        @if($order->payment_method == '50')
                        <tr>
                            <th>المبلغ المتبقى</th>
                            <td colspan="2">{{ $order->total / 2 }} @lang("KD")</td>
                        </tr>
                        @endif
                        <tr>
                            <th>سعر التوصيل</th>
                            <td colspan="3">{{ $order->delivery }} @lang("KD")</td>
                        </tr>
                        @if($order->copon)
                        <tr>
                            <th>الكوبون</th>
                            <td colspan="3">{{ $order->copon->code ?? "" }}</td>
                        </tr>
                        @endif
                        @if($order->discount)
                        <tr>
                            <th>الخصم</th>
                            <td colspan="3">{{ $order->discount ?? 0 }} @lang("KD")</td>
                        </tr>
                        @endif
                        <tr>
                            <th>الإجمالى</th>
                            <th colspan="3">{{ $order->total }} @lang("KD")</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $('.accept_request').click(function(){
        var t = confirm("هل أنت متأكد");
        if(!t){
            return false;
        }
    });
</script>
@stop
