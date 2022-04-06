@extends('Common::admin.layout.page')
@section('page')
<div class="row list_page">
    <div class="col-12">
        <div class="card">

            <div class="card-header">
                <h3 class="card-title">{{ __($title) }}</h3>
                @if($can_add)
                <a href="{{ route("admin.$name.create" , request()->query()) }}" class="mlink btn btn-success"><i
                        class="fa fa-plus"></i>
                    <span>{{ __("Add new") }}</span></a>
                @endif
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
                <table id="example2" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="visible">#</th>
                            @foreach($list as $key =>$col_title)
                            <th class="visible">{{ app()->getLocale() == 'ar' ? $col_title : str_replace("_" , " " , ucfirst($key)) }}</th>
                            @endforeach
                            @if(isset($links))
                            @foreach($links as $link)
                            <th>{{  __($link['title']) }}</th>
                            @endforeach
                            @endif
                            @if(isset($switches))
                            @foreach($switches as $title => $option)
                            @if((!isset($option['on'])) || (isset($option['on']) && request($option['on'][0]) ==
                            $option['on'][1]))
                            <th>{{ __(str_replace('_' , ' ' , $title)) }}</th>
                            @endif
                            @endforeach
                            @endif
                            <th>{{ __("Edit") }}</th>
                            @if($can_delete)
                            <th>{{ __("Delete") }}</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rows as $row)
                        <tr>
                            <td class="visible">{{ $loop->iteration }}</td>
                            @foreach($list as $key => $col_title)
                            @php
                            $value = $key != 'created_at' && is_object($row->$key) ? $row->$key->{app()->getLocale()} :
                            $row->$key;
                            $relation = explode('_' , $key);
                            @endphp
                            @if(in_array($key , ['image' , 'path']))
                            <td class="visible"><img src="{{ $value }}" /></td>
                            @elseif(strpos($key , '_') !== false && $row->{$relation[0]})
                            @if(is_object($row->{$relation[0]}) && $relation[1] == 'count')
                            <td class="visible">{{ $row->{$relation[0]}->count() }}</td>
                            @else
                            <td class="visible">{{ is_object($row->{$relation[0]}->{$relation[1]}) ? $row->{$relation[0]}->{$relation[1]}->{app()->getLocale()} : $row->{$relation[0]}->{$relation[1]} }}
                            </td>
                            @endif
                            @else
                            <td class="visible">{{ $value }}</td>
                            @endif
                            @endforeach

                            @if(isset($links))
                            @foreach($links as $link)
                            <td>
                                <a class="btn btn-{{ $link['type'] }} mlink"
                                    href="{{ route($link['url'] , array_merge([$link['key'] => $row->id] , request()->query())) }}">
                                    <i class="fa {{ $link['icon'] }}"></i>
                                </a>
                            </td>
                            @endforeach
                            @endif
                            @if(isset($switches))
                            @foreach($switches as $title => $option)
                            @if((!isset($option['on'])) || (isset($option['on']) && request($option['on'][0]) ==
                            $option['on'][1]))
                            <td>
                                <label class="switch">
                                    <input type="checkbox" {{ $row->$title ? 'checked' : '' }} class="change_status"
                                        value="{{ $row->id }}" data-route="{{ $option['url'] }}">
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            @endif
                            @endforeach
                            @endif
                            <td>

                                <a class="btn btn-primary mlink" href="{{ route("admin.$name.edit" , array_merge([$row->id] , request()->query())) }}">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                            @if($can_delete)
                            <td>
                                <form action="{{ route("admin.$name.destroy" , $row->id) }}" method="post"
                                    class="action_form remove">
                                    @csrf
                                    {{ method_field('delete') }}
                                    @foreach(request()->query() as $key => $val)
                                        <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                                    @endforeach
                                    <button type="submit" class="btn btn-danger removethis">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @if($paginate)
                <ul class="paginator">
                {{ $rows->appends(request()->query())->links() }}
                </ul>
                @endif
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
<script>
    $('.paginator a').addClass('mlink');
    $('.table').DataTable({
        dom: 'Bfrtip',
        searching: false,
        bInfo: false, //Dont display info e.g. "Showing 1 to 4 of 4 entries"
        paging: false,//Dont want paging
        bPaginate: false,//Dont want paging
        buttons: [
            {
                extend: 'copyHtml5',
                text : "<i class='fas fa-copy'></i> {{ __('Copy') }}",
                exportOptions: {
                    columns: ['.visible'],
                    modifier: {
                    page: 'all',
                    search: 'none'
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

</script>

@stop
