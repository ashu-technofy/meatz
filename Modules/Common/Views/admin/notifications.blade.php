@extends('Common::admin.layout.page')
@section('page')
<!-- general form elements -->
<form action="{{ route('admin.notifications') }}" method="post" class="action_form" novalidate>
    @csrf
    <div class="row">
        <div class="col-sm-12 col-md-8">
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">@lang('Send notification')</h3>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs langs">
                        @foreach(config('app.locales') as $myname => $lang)
                        <li class="{{ $loop->iteration == 1 ? 'active' : '' }}">
                            <a data-toggle="tab" href="#{{ $myname }}"
                                class="{{ $loop->iteration == 1 ? 'active' : '' }}">
                                
                                <span>{{ __($lang) }}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>

                    <div class="tab-content">
                        @foreach(config('app.locales') as $lang_name => $lang)
                        <div id="{{ $lang_name }}"
                            class="tab-pane fade {{ $loop->iteration == 1 ? 'in active show' : '' }}">
                            <div class="form-group">
                                <label class="col-sm-12" for=""> @lang('Notice title')</label>
                                <div class="col-sm-12">
                                    <input required name="title[{{ $lang_name }}]" class="form-control" rows="5"
                                        placeholder=@lang('Notice title')>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-12" for=""> @lang('Notice text')</label>
                                <div class="col-sm-12">
                                    <textarea required name="text[{{ $lang_name }}]" class="form-control" rows="5"
                                        placeholder=@lang('Notice text')></textarea>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"> <span>{{ __("Send") }}</span> <i
                                class="fas fa-save"></i></button>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-sm-12 col-md-4">
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">@lang('Settings')</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <label for=""> @lang('notification type')</label>
                            <select name="for" class="form-control selectpicker" title="نوع الاشعار" id="">
                                <option value="all">@lang('all customers') </option>
                                <option value="android">@lang('android')</option>
                                <option value="ios">@lang('ios')</option>
                            </select>
                        </div>
                    </div>
                    {{-- <div class="form-group">
                        <div class="col-sm-12">
                            <label>الخدمة</label>
                            <select name="product_id" class="form-control selectpicker" title="اختر الخدمة" id="">
                                <option value="0">إشعار عام</option>
                                @foreach($services as $service)
                                <option value="{{ $service->id }}">{{ $service->name->{app()->getLocale()} }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</form>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">@lang('Notifications')</h3>
    </div>
    <div class="card-body">
        <table class="table table-striped table-bordered">
            <thead>
                <th>#</th>
                <th>@lang('Text')</th>
                <th>@lang('Created at')</th>
                <th>@lang('Resend')</th>
                <th>@lang('Delete')</th>
            </thead>
            <tbody>
                @foreach($notifications as $row)
                <tr>
                    <td>
                        {{ $loop->iteration }}
                    </td>
                    <td>{{ $row->text }}</td>
                    <td>{{ $row->created_at }}</td>
                    <td>
                        <a href="{{ route('admin.notifications' , $row->id) }}" class="btn btn-primary mlink">
                            <i class="far fa-share-square"></i>
                        </a>
                    </td>
                    <td>
                        <form action="{{ route("admin.notifications.destroy" , $row->id) }}" method="post"
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
        {{ $notifications->links() }}
    </div>
</div>
<!-- /.card -->
</form>
@stop
