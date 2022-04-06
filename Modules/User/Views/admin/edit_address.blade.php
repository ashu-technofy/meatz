@extends('Common::admin.layout.page')
@section('page')
<!-- general form elements -->
<form method="post" action="{{ route('admin.user_addresses' , request()->query()) }}" class="action_form" novalidate>
    @csrf
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">@lang('Edit')</h3>
                </div>
                    <div class="tab-content">
                        <div class="form-group">
                            <input type="hidden" name="user_id" value="{{ request('user_id') }}">
                            <label class="col-sm-12" for="">المنطقة</label>
                            <div class="col-sm-12">
                                <select name="area_id" class="form-control" id="">
                                    @foreach($areas as $area)
                                        <option value="{{ $area->id == $info->area_id }}">
                                            {{ $area->name->{app()->getLocale()} }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12" for="">اسم العنوان</label>
                            <div class="col-sm-12">
                                <input required name="address[address_name]" value="{{ $info->address['address_name'] ?? '' }}" class="form-control" rows="5"
                                    placeholder="اسم العنوان">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12" for="">القطعة</label>
                            <div class="col-sm-12">
                                <input required name="address[block]" value="{{ $info->address['block'] ?? '' }}" class="form-control" rows="5"
                                    placeholder="القطعة">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12" for="">الشارع</label>
                            <div class="col-sm-12">
                                <input required name="address[street]" value="{{ $info->address['street'] ?? '' }}" class="form-control" rows="5"
                                    placeholder="الشارع">
                            </div>
                        </div>
                        {{-- <div class="form-group">
                            <label class="col-sm-12" for="">رقم المنزل</label>
                            <div class="col-sm-12">
                                <input required name="address[house_number]" value="{{ $info->address['house_number'] ?? '' }}" class="form-control" rows="5"
                                    placeholder="رقم المنزل">
                            </div>
                        </div> --}}
                        <div class="form-group">
                            <label class="col-sm-12" for="">رقم المبني</label>
                            <div class="col-sm-12">
                                <input required name="address[building_number]" value="{{ $info->address['building_number'] ?? '' }}" class="form-control" rows="5"
                                    placeholder="رقم المبني">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12" for="">الطابق</label>
                            <div class="col-sm-12">
                                <input required name="address[level_no]" value="{{ $info->address['level_no'] ?? '' }}" class="form-control" rows="5"
                                    placeholder="الطابق">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12" for="">الملاحظات</label>
                            <div class="col-sm-12">
                                <input required name="address[notes]" value="{{ $info->address['notes'] ?? '' }}" class="form-control" rows="5"
                                    placeholder="الملاحظات">
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
@stop
