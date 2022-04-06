@extends('Common::admin.layout.page')
@section('page')

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">@lang('Admin actions')</h3>
    </div>
    <div class="card-body">
        <table class="table table-striped table-bordered">
            <thead>
                <th>#</th>
                <th>@lang('Admin')</th>
                <th>@lang('Action')</th>
                <th>@lang('Created at')</th>
            </thead>
            <tbody>
                @foreach($actions as $row)
                <tr>
                    <td>
                        {{ $loop->iteration }}
                    </td>
                    <td>{{ $row->admin->username ?? $row->admin->name ?? 'unkown' }}</td>
                    <td>
                        <a style="text-decoration: none;" class="mlink" href="{{ $row->url }}">
                            {{ $row->action }}
                        </a>
                    </td>
                    <td>{{ $row->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <ul class="paginator">
        {{ $actions->links() }}
        </ul>
    </div>
</div>
<!-- /.card -->
</form>
@stop