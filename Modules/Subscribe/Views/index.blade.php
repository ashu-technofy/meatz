@extends('Common::admin.layout.page')
@section('page')
<!-- general form elements -->

<form action="{{ route('admin.subscribe.store') }}" method="post" class="action_form" novalidate>
    @csrf
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">@lang('Send Email')</h3>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-sm-12" for="">@lang('Email subject')</label>
                                    <div class="col-sm-12">
                                        <input required name="subject" class="form-control"
                                            placeholder="@lang('Email subject')" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-sm-12" for="">@lang('message')</label>
                                    <div class="col-sm-12">
                                        <textarea required name="content" class="form-control" rows="5"
                                            placeholder="@lang('message')"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"> <span>{{ __("Send") }}</span> <i
                                class="fas fa-save"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">@lang($title)</h3>
    </div>
    <div class="card-body">
        <table class="table table-striped table-bordered">
            <thead>
                <th>#</th>
                <th>@lang('Email')</th>
                <th>@lang('Created at')</th>
                <th>@lang('Delete')</th>
            </thead>
            <tbody>
                @foreach($rows as $row)
                <tr>
                    <td>
                        {{ $loop->iteration }}
                    </td>
                    <td>{{ $row->email }}</td>
                    <td>{{ $row->created_at }}</td>
                    <td>
                        <form action="{{ route("admin.subscribe.destroy" , $row->id) }}" method="post"
                            class="action_form remove">
                            @csrf
                            {{ method_field('delete') }}
                            <button type="submit" class="btn btn-danger removethis">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $rows->links() }}
    </div>
</div>
@stop
