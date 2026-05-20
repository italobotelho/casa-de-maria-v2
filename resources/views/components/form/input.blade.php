@props([
    'name',
    'label',
    'type' => 'text',
    'col' => '12',
    'value' => '',
    'required' => false,
    'maxlength' => '',
    'oninput' => '',
    'onblur' => '',
    'size' => '',
])

<div class="form-group col-md-{{ $col }}">
    <label for="{{ $name }}">{{ $label }}</label>
    <input 
        type="{{ $type }}" 
        class="form-control @error($name) is-invalid @enderror" 
        id="{{ $name }}" 
        name="{{ $name }}" 
        value="{{ old($name, $value) }}" 
        @if($required) required @endif
        @if($maxlength) maxlength="{{ $maxlength }}" @endif
        @if($oninput) oninput="{{ $oninput }}" @endif
        @if($onblur) onblur="{{ $onblur }}" @endif
        @if($size) size="{{ $size }}" @endif
    >
    @error($name)
        <span class="invalid-feedback d-block">{{ $message }}</span>
    @enderror
</div>
