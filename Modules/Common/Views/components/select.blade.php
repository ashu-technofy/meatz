<div class="form-group">
    <label>{{ $mytitle }}</label>
    <select {{ $required }} name="{{ $name }}" class="select2" id="{{isset($input['id']) ? $input['id'] : ''}}" {{ $input['multiple'] ?? '' }}
        data-placeholder="{{ $mytitle }}" style="width: 100%;" searchable>
        @foreach($input['values'] as $key => $val)
        @if(is_array($value))
        <option {{ in_array($key , $value) ? 'selected' : '' }} value="{{ $key }}">{{ __($val) }}</option>
        @elseif(!is_object($value))
        <option {{ $value == $key ? 'selected' : '' }} value="{{ $key }}">{{ __($val) }}</option>
        @elseif(is_object($value) && $value = $value->pluck('id')->toArray())
        <option {{ in_array($key , $value) ? 'selected' : '' }} value="{{ $key }}">{{ __($val) }}</option>
        @else
        <option value="{{ $key }}">{{ __($val) }}</option>
        @endif
        @endforeach
    </select>
</div>
