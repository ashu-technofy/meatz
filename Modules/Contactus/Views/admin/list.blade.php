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
                <table id="example2" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="visible">#</th>
                            <th class="visible">@lang('Client')</th>
                            <th class="visible">@lang('Email')</th>
                            <th class="visible">@lang('Phone')</th>
                            <th class="visible">@lang('Status')</th>
                            {{-- <th class="visible">@lang('Claim title')</th> --}}
                            <th class="visible">@lang('Created at')</th>
                            <th>@lang('Show')</th>
                            <th>@lang('Delete')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($messages as $row)
                        <tr class="{{ !$row->seen ? 'unseen' : '' }}">
                            <td class="visible">{{ $row->id }}</td>
                            <td class="visible">{{ $row->name }}</td>
                            <td class="visible">{{ $row->email }}</td>
                            <td class="visible">{{ $row->mobile }} </td>
                            <td class="visible">{{ $row->status }} </td>
                            {{-- <td class="visible">{{ $row->title }}</td> --}}
                            <td class="visible">{{ $row->created_at }}</td>
                            <td class="actions_td">
                                <a class="btn btn-primary mlink" href="{{ route("admin.contactus.show" , $row->id) }}">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                            <td>
                                <a class="btn btn-danger mlink" href="{{ route("admin.contactus.show" , [$row->id , 'action' => 'delete']) }}">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <ul class="paginator">
                {{ $messages->links() }}
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
        bSort : false,
        paging: false,//Dont want paging
        bPaginate: false,//Dont want paging
        buttons: [
            {
                extend: 'copyHtml5',
                text : "<i class='fas fa-copy'></i> {{ __('Copy') }}",
                exportOptions: {
                    columns: ['.visible']
                }
            },
            {
                extend: 'excelHtml5',
                text : "<i class='fas fa-file-excel'></i> {{ __('Export to excel') }}",
                exportOptions: {
                    columns: ['.visible']
                }
            },
            {
                extend: 'print',
                text : "<i class='fas fa-print'></i> {{ __('Print') }}",
                exportOptions: {
                    columns: ['.visible']
                }
            },
        ]
    });

</script>

@stop