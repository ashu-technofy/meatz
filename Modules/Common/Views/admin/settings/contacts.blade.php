@extends('Common::admin.layout.page')
@section('page')
<form action="{{ $action }}" method="post" enctype="multipart/form-data" class="action_form" novalidate>
    @csrf
    <!-- general form elements -->
    <div class="card card-primary contactsDiv">
        <div class="card-header">
            <h3 class="card-title">{{ $title }}</h3>
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead>
                    {{-- <th>@lang('Icon')</th> --}}
                    <th>@lang('Type')</th>
                    <th>@lang('Value')</th>
                    <th>@lang('Delete')</th>
                </thead>
                <tbody>
                    @foreach($contacts as $contact)
                    @if($contact->key && $contact->value)
                    <tr>
                        {{-- <td>
                            <x-input :input="$contact" name="image[]" :model="$contact" lang="all" />
                        </td> --}}
                        <td>
                            <select name="key[]" id="" class="form-control">
                                @foreach(social_types() as $key => $type )
                                <option {{ $key == $contact->key ? 'selected' : '' }} value="{{ $key }}">{{ $type }}
                                </option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="text" name="value[]"
                                value="{{ $contact->value ?? $contact->value->all ?? '' }}" class="form-control"></td>
                        <td><a href="#!" class="remove_contact btn btn-danger" id="{{ $contact->id }}"><i
                                    class="fa fa-trash"></i></a></td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="contactTr">
                        {{-- <td>
                            <x-input :input="$model" name="image[]" :model="$model" lang="all" />
                        </td> --}}
                        <td>
                            <select name="key[]" id="" class="form-control">
                                @foreach(social_types() as $key => $type )
                                <option {{ $model->key == $key ? 'selected' : '' }} value="{{ $key }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="text" name="value[]" value="{{ $model->value->all ?? '' }}"
                                class="form-control">
                        </td>
                        <td><a href="#!" class="remove_contact btn btn-danger" id="0"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center"><a href="#!" class="add_contact">+ @lang('Add another
                                contact')</a>
                        </td>
                    </tr>
                </tfoot>
            </table>


        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary"> <span>??????</span> <i class="fas fa-save"></i></button>
        </div>
    </div>
    <!-- /.card -->
</form>
<script>
    $('.select2').select2();
    $('body').on('click', '.remove_contact', function () {
        var id = parseInt($(this).attr('id'));
        var btn = $(this);
        if (id && id != 0) {
            Swal.fire({
                icon: "warning",
                text: "???? ???????? ??????????",
                showConfirmButton: true,
                confirmButtonText: "??????",
                showCancelButton: true,
                cancelButtonText: "????"
            }).then(function (ok) {
                if (!ok.value) {
                    return false;
                } else {
                    $.get("{{ route('admin.remove_contact') }}", {
                        id: id
                    });
                    btn.closest('tr').remove();
                }
            });
        } else {
            btn.closest('tr').remove();
        }
    });
    $('.add_contact').click(function () {
        $('tbody').append("<tr>" + $('.contactTr').html() + "</tr>");
        return false;
    })

</script>
@stop