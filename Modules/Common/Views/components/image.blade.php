<div class="form-group">
    <label for="exampleInputFile">{{ $mytitle }}</label>
    <div class="input-group">
        <div class="mycustom-file">
            <input {{ $required }} name="{{ $name }}" type="file" class="mycustom-file-input">
            <label title="@lang('Choose image')" class="mycustom-file-label">
                <div class="image">
                    <i class="fas fa-image"></i>
                    <span>@lang('Choose image')</span>
                    <img onerror="this.style.display='none'" src="{{ url($value) }}">
                </div>
            </label>
        </div>
    </div>
</div>
