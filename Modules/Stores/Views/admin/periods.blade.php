@extends('Common::admin.layout.page')
@section('page')
    <form action="{{ route('admin.store_periods', $store->id) }}" method="post" data-title="{{ $title }}"
        enctype="multipart/form-data" class="action_form" novalidate>
        @csrf
        <div class="card-body">
            <div class="myoptions">
                <h2>@lang('Periods')</h2>
                @forelse($periods as $row) 
                    <div class="col-sm-12" style="margin-bottom: 10px">
                        <div class="row">
                            <div class="col-sm-5">
                                <select class="form-control" name="from[]" id="">
                                    @foreach(hours() as $h => $val)
                                        <option {{ $row->from == $h ? 'selected' : '' }} value="{{ $h }}">{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-5">
                                <select class="form-control" name="to[]" id="">
                                    @foreach(hours() as $h => $val)
                                        <option {{ $row->to == $h ? 'selected' : '' }} value="{{ $h }}">{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-1">
                                <a href="#!" class="remove_option btn btn-danger" data-dayid="{{ $row->id }}">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                <div class="col-sm-12" style="margin-bottom: 10px">
                    <div class="row">
                        <div class="col-sm-5">
                            <select class="form-control" name="from[]" id="">
                                @foreach(hours() as $h => $val)
                                    <option value="{{ $h }}">{{$val}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-5">
                            <select class="form-control" name="to[]" id="">
                                @foreach(hours() as $h => $val)
                                    <option value="{{ $h }}">{{$val}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-1">
                            <a href="#!" class="remove_option btn btn-danger" data-dayid="0">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>
            <hr>
            <a href="#!" class="btn btn-success" id="add_more">
                <i class="fa fa-plus"></i>
                @lang('Add other option')
            </a>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary"> <span>{{ __('Save') }}</span> <i
                        class="fas fa-save"></i></button>
            </div>

            <div class="empty_div" style="position: absolute;width:0px;height:0px;opacity:0;">
                <div class="col-sm-12" style="margin-bottom: 10px">
                    <div class="row">
                        <div class="col-sm-5">
                            <select class="form-control" name="from[]" id="">
                                @foreach(hours() as $h => $val)
                                    <option value="{{ $h }}">{{$val}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-5">
                            <select class="form-control" name="to[]" id="">
                                @foreach(hours() as $h => $val)
                                    <option value="{{ $h }}">{{$val}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-1">
                            <a href="#!" class="remove_option btn btn-danger" data-dayid="0">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        $('body').on('click', '.remove_option', function() {
            $.get("{{ route('admin.remove_store_period') }}", {
                day_id: $(this).data('dayid'),
                store_id: "{{ $store->id }}"
            });
            $(this).closest('.col-sm-12').remove();
            return false;
        });
    </script>
@stop