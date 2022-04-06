<hr>
<div class="myoptions">
    <h2>@lang('Options')</h2>
    @forelse($model->options as $row)
        <div class="col-sm-12" style="margin-bottom: 10px">
            <div class="row">
                <div class="col-sm-11">
                    <select name="option_id[]" class="form-control">
                        <option value="0" disabled selected>@lang('Choose option')</option>
                        @foreach ($options as $option)
                            <option {{ $row->id == $option->id ? 'selected' : '' }} value="{{ $option->id }}">
                                {{ $option->name->{app()->getLocale()} }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-1">
                    <a href="#!" class="remove_option btn btn-danger" data-id="{{ $row->id }}">
                        <i class="fa fa-trash"></i>
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-11">
                    <select name="option_id[]" class="form-control">
                        <option value="0" disabled selected>@lang('Choose option')</option>
                        @foreach ($options as $option)
                            <option value="{{ $option->id }}">{{ $option->name->{app()->getLocale()} }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-1">
                    <a href="#!" class="remove_option btn btn-danger" data-id="0">
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

<div class="empty_div" style="position: absolute;width:0px;height:0px;opacity:0;">
    <div class="col-sm-12" style="margin-top:10px;">
        <div class="row">
            <div class="col-sm-11">
                <select name="option_id[]" class="form-control">
                    <option value="0" disabled selected>@lang('Choose option')</option>
                    @foreach ($options as $option)
                        <option value="{{ $option->id }}">{{ $option->name->{app()->getLocale()} }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-1">
                <a href="#!" class="remove_option btn btn-danger" data-id="0">
                    <i class="fa fa-trash"></i>
                </a>
            </div>
        </div>
    </div>
</div>
<script>
    $('body').on('click', '.remove_option', function() {
        $.get("{{ route('admin.remove_product_option') }}", {
            id: $(this).data('id')
        });
        $(this).closest('.col-sm-12').remove();
        return false;
    });
    $('body').on('click', '.add_more', function() {
        var cont = $('.empty_div').html();
        $('.myoptions').append(cont);
        return false;
    });

</script>
