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
                <table id="example2" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            {{-- <th>@lang('Name')</th> --}}
                            <th width:1>@lang('Area')</th>
                            <th>@lang('Block')</th>
                            {{-- <th>@lang('Avenue')</th> --}}
                            <th>@lang('Street')</th>
                            {{-- <th>@lang('House number')</th> --}}
                            <th>@lang('Building no')</th>
                            <th>@lang('Level no')</th>
                            <th>@lang('Notes')</th>
                            <th>{{ __("Edit") }}</th>
                            <th>{{ __("Delete") }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rows as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            {{-- <td>{{ $row->address['address_name'] ?? '' }}</td> --}}
                            <td>{{ $row->area->name->{app()->getLocale()} ?? '' }}</td>
                            <td>{{ $row->address['block'] ?? '' }}</td>
                            {{-- <td>{{ $row->address['avenue'] ?? '' }}</td> --}}
                            <td>{{ $row->address['street'] ?? '' }}</td>
                            {{-- <td>{{ $row->address['house_number'] ?? '' }}</td> --}}
                            <td>{{ $row->address['building_number'] ?? '' }}</td>
                            <td>
                                @if(isset($row->address['level']))
                                {{ isset($row->address['level']) ? substr($row->address['level'] , 0 , 10) : '' }}
                                @else
                                {{ isset($row->address['level_no']) ? substr($row->address['level_no'] , 0 , 10) : '' }}
                                @endif
                            </td>
                            <td>@if(isset($row->address['notes'])){{ substr($row->address['notes'] , 0 , 50).' ...'}} @endif</td>
                            <td>
                                <a class="mlink" href="{{ route('admin.user_addresses' , ['user_id' => $row->user_id , 'address_id' => $row->id , 'action' => 'edit']) }}">
                                <i class="fa fa-edit"></i>
                                </a>
                            </td>
                            <td>
                                <a class="mlink" href="{{ route('admin.user_addresses' , ['user_id' => $row->user_id , 'address_id' => $row->id , 'action' => 'delete']) }}">
                                <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
<script>
    // $('.table').DataTable({
    //     "paging": false,
    //     "lengthChange": false,
    //     "searching": false,
    //     "ordering": true,
    //     "info": false,
    //     "autoWidth": false,
    // });

</script>

@stop
