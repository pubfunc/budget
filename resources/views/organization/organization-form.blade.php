<form id="{{ isset($id) ? $id : 'organization_form' }}" action="{{ $action }}" method="POST">
    @method($method)
    @csrf

    <div class="form-group">
        <label for="input_label">Organization Label</label>
        <input id="input_label" type="text" class="form-control" name="label">
        @if ($errors->has('label'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('label') }}</strong>
            </span>
        @endif
    </div>

</form>