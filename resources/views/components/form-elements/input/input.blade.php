<div class="{{ isset($class) ? $class : '' }}">
    <label class="form-label {{ isset($required) && $required == 'true' ? 'required' : '' }}" for="{{ isset($id) ? $id : '' }}">{{ $title }}</label>
    <input type="{{ isset($type) ? $type : 'text' }}" class="form-control" name="{{ $name }}" id="{{ isset($id) ? $id : '' }}"
        placeholder="{{ isset($placeholder) ? $placeholder : '' }}" value="{{ isset($value) ? $value : '' }}" min="{{ isset($min) ? $min : '' }}" max="{{ isset($max) ? $max : '' }}" step="{{ isset($step) ? $step : '' }}" 
        {{ isset($disabled) && $disabled == 'true' ? 'disabled' : '' }}
        {{ isset($readonly) && $readonly == 'true' ? 'readonly' : '' }}
        {{ isset($mask) ? 'data-mask=' . $mask . '' : '' }}
        {{ isset($required) && $required == 'true' ? 'required' : '' }}>
</div>