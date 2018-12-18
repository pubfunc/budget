@php

    $input_name = isset($name) ? $name : '_unnamed_';
    $input_id = isset($id) ? $id : 'input_' . $input_name;
    $input_value = old($input_name, isset($value) ? $value : null);
    $is_valid = $errors->isNotEmpty() && !$errors->has($input_name);
    $is_invalid = $errors->isNotEmpty() && $errors->has($input_name);
    $input_type = isset($type) ? $type : 'text';

    if($input_type === 'date' && $input_value instanceof DateTime){
        $input_value = $input_value->format('Y-m-d');
    }

@endphp
<div class="form-group">
    @isset($label)
    <label for="{{ $input_id }}">{{ $label }}</label>
    @endisset

    @if($input_type === 'select')
    <select id="{{ $input_id }}"
            name="{{ $input_name }}"
            class="custom-select{{ $is_valid ? ' is-valid' : '' }}{{ $is_invalid ? ' is-invalid' : '' }}">
        @isset($placeholder)
        <option value="">{{ $placeholder }}</option>
        @endisset

        @if(isset($map) && is_array($map))
        @foreach($map as $key=>$value)
        <option value="{{ $key }}"{{ $input_value === $key ? ' selected' : '' }}>{{ $value }}</option>
        @endforeach
        @endif

        @if(isset($groups) && is_array($groups))
        @foreach($groups as $group=>$options)
        <optgroup label="{{ $group }}">
            @foreach($options as $key=>$value)
            <option value="{{ $key }}"{{ $input_value === $key ? ' selected' : '' }}>{{ $value }}</option>
            @endforeach
        </optgroup>
        @endforeach
        @endif

        @isset($options)
        {{ $options }}
        @endisset
    </select>
    @elseif($input_type === 'textarea')
    <textarea
            id="{{ $input_id }}"
            name="{{ $input_name }}"
            rows="3"
            class="form-control{{ $is_valid ? ' is-valid' : '' }}{{ $is_invalid ? ' is-invalid' : '' }}">{{ $input_value }}</textarea>

    @else

    <input type="{{ $input_type }}"
            id="{{ $input_id }}"
            name="{{ $input_name }}"
            value="{{ $input_value }}"
            class="form-control{{ $is_valid ? ' is-valid' : '' }}{{ $is_invalid ? ' is-invalid' : '' }}"
            placeholder="{{ isset($placeholder) ? $placeholder : '' }}">
    @endif

    @if($is_valid)
    <div class="valid-feedback"></div>
    @elseif($is_invalid)
    <div class="invalid-feedback">
        {{ $errors->first($input_name) }}
    </div>
    @endif
</div>