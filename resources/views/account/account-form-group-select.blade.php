@component('ui.form.form-group', ['type' => 'select', 'label' => $label, 'value' => $value, 'name' => $name])
    @slot('options')
        @foreach($accountOptions as $group=>$options)
        <optgroup label="{{ $group }}">
            @foreach($options as $i=>$account)
            <option value="{{ $account->id }}"{{ old($name, $value) === $account->id ? ' selected' : '' }}>{{ $account->title }}</option>
            @endforeach
        </optgroup>
        @endforeach
    @endslot
@endcomponent