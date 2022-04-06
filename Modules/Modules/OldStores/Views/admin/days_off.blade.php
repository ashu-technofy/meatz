@extends('Common::admin.layout.page')
@section('page')
    <form action="{{ route('admin.store_days_off', $store->id) }}" method="post" data-title="{{ $title }}"
        enctype="multipart/form-data" class="action_form" novalidate>
        @csrf
        <div class="card-body">
            <div class="myoptions">
                <h2>@lang('Dates')</h2>
                @forelse($store->dates_off as $row) 
                    <div class="col-sm-12" style="margin-bottom: 10px">
                        <div class="row">
                            <div class="col-sm-11">
                                <input type="date" name="dates[]" value="{{ $row->date }}" class="form-control" id="">
                            </div>
                            <div class="col-sm-1">
                                <a href="#!" class="remove_option btn btn-danger" data-dayid="{{ $row->id }}">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-11">
                                <input type="date" name="dates[]" class="form-control" id="">
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
            <a href="#!" class="btn btn-success add_more">
                <i class="fa fa-plus"></i>
                @lang('Add other option')
            </a>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary"> <span>{{ __('Save') }}</span> <i
                        class="fas fa-save"></i></button>
            </div>

            <div class="empty_div" style="position: absolute;width:0px;height:0px;opacity:0;">
                <div class="col-sm-12" style="margin-top:10px;">
                    <div class="row">
                        <div class="col-sm-11">
                            <input type="date" name="dates[]" class="form-control" id="">
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
            $.get("{{ route('admin.remove_store_day_off') }}", {
                day_id: $(this).data('dayid'),
                store_id : "{{ $store->id }}"
            });
            $(this).closest('.col-sm-12').remove();
            return false;
        });
        $('body').on('click', '.add_more', function() {
            var cont = $('.empty_div').html();
            $('.myoptions').append(cont);
            // $('.select2').select2();
            return false;
        });
        // $('.select2').select2();

    </script>
@stop
