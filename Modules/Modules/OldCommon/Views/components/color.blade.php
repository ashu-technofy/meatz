<!-- bootstrap color picker -->
<script src="{{ url('assets/admin') }}/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<div class="form-group">
    <label>{{ $mytitle }}</label>

    <div class="input-group colorpicker">
        <input type="color" {{ $required }} name="{{ $name }}" value="{{ $value }}" class="form-control">

    </div>
    <!-- /.input group -->
</div>
