<div class="form-group">
    <label for="exampleInputEmail1">{{ $mytitle }} {!! $name == 'wallet' ? "<b style='color:red;font-size:17px;font-weight:bold;padding:30px'>".__('Available Wallet is : ').$model->mywallet.' '.__('KD')."</b>" : '' !!}</label>
    <input {{ $required }} type="number" step="0.1" name="{{ $name }}" value="{{ $value }}" class="form-control"
        placeholder="{{ $mytitle }}">
</div>