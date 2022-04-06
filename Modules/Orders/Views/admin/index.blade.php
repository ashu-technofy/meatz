@extends('Common::admin.layout.page')
@section('page')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ __($title) }}</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="search-box" style="
                width: 100%;
                max-width: 300px;
                margin: auto;">
                    <div class="form-group">
                        <select name="delivery_type" class="form-control" id="">
                            <option value="delivery_type" selected disabled>@lang('Delivery type')</</option>
                            <option value="usual">@lang('Normal')</option>
                            <option {{ request('delivery_type') == 'express' ? 'selected' : '' }} value="express">@lang('Express')</option>
                        </select>
                        <br>
                        <select name="payment_method" class="form-control payment_method" id="">
                            <option selected disabled>@lang('Payment method')</option>
                            <option value="knet">@lang('KNET')</option>
                            {{-- <option {{ request('payment_method') == 'credit' ? 'selected' : '' }} value="credit">@lang('Visa')</option> --}}
                            <option {{ request('payment_method') == 'wallet' ? 'selected' : '' }} value="wallet">@lang('Wallet')</option>
                        </select>
                    </div>
                </div>
                <table id="example2" class="table table-bordered table-hover">
                    <thead class="statis">
                        <tr>
                            <th class="visible"><span>@lang("Total orders")</span> {{ $count }}</th>
                            <th class="visible"><span>@lang("Total sales")</span> {{ $total }} @lang('KD')</th>
                            {{-- <th class="visible"><span>@lang("Total paid")</span> {{ $total_paid }} @lang('KD')</th> --}}
                            {{-- <th class="visible"><span>@lang('Total cash')</span> {{ $total_cash }} @lang('KD')</th> --}}
                            <th class="visible"><span>@lang('Total wallet')</span> {{ $total_wallet }} @lang('KD')</th>
                            <th class="visible"><span>@lang('Total 50')</span> {{ $total_50 }} @lang('KD')</th>
                            <th class="visible"><span>@lang('Total knet')</span> {{ $total_knet }} @lang('KD')</th>
                            <th class="visible"></th>
                            <th></th>
                        </tr>
                    </thead>
                    <thead>
                        <tr>
                            <th class="visible">@lang("Order ID")</th>
                            <th class="visible">@lang('Client')</th>
                            <th class="visible">@lang('Total')</th>
                            <th class="visible">@lang('Delivery type')</th>
                            <th class="visible">@lang('Payment method')</th>
                            @if(request('status') == 'cancel_request')
                            <th class="visible">@lang('Cancel status')</th>
                            @endif
                            <th class="visible">@lang('Created at')</th>
                            <th>@lang('Show')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $row)
                        <tr>
                            <td class="visible">{{ $row->code ?? "ZW".$row->id }}</td>
                            <td class="visible">{{ $row->myuser->username ?? '#' }}</td>
                            <td class="visible">{{ $row->total }} @lang("KD")</td>
                            <td class="visible">{{ $row->delivery_type == 'express' ? __('Express') : __('Normal') }}</td>
                            <td class="visible">@lang(ucfirst($row->payment_method))</td>
                            @if(request('status') == 'cancel_request')
                            <td class="visible">
                                @if($row->cancel_request == -1)
                                    @lang('Rejected')
                                @elseif($row->cancel_request == 2)
                                    @lang('Accepted')
                                @else
                                    @lang('Pending request')
                                @endif
                            </td>
                            @endif
                            <th class="visible">{{ $row->created_at }}</th>
                            <td class="actions_td">
                                <a class="btn btn-primary mlink" href="{{ route("admin.orders.show" , $row->id) }}">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <ul class="paginator">
                {{ $orders->appends(request()->query())->links() }}
                </ul>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
<script>
    $('.table').DataTable({
        dom: 'Bfrtip',
        searching: false,
        bInfo: false, //Dont display info e.g. "Showing 1 to 4 of 4 entries"
        paging: false,//Dont want paging
        bPaginate: false,//Dont want paging
        ordering:false,
        buttons: [
            {
                extend: 'copyHtml5',
                text : "<i class='fas fa-copy'></i> {{ __('Copy') }}",
                exportOptions: {
                    columns: ['.visible'],
                    modifier: {
                    page: 'all',
                    selected: 'none'   
                    }
                },
            },
            {
                extend: 'excelHtml5',
                text : "<i class='fas fa-file-excel'></i> {{ __('Export to excel') }}",
                exportOptions: {
                    columns: ['.visible'],
                    modifier: {
                    page: 'all',
                    search: 'none'   
                    }
                },
            },
            {
                extend: 'print',
                text : "<i class='fas fa-print'></i> {{ __('Print') }}",
                exportOptions: {
                    columns: ['.visible'],
                    modifier: {
                    page: 'all',
                    search: 'none'   
                    }
                },
            },
        ]
    });

    $("[name='delivery_type']").change(function(){
        add_query($(this).val(), 'delivery_type');
    });
</script>

@stop
