@props(['name','label'])
<div class="custom-control custom-checkbox">
    <input wire:model="{{ $name }}" class="custom-control-input" type="checkbox" id="{{ $name }}" checked="">
    <label for="{{ $name }}" class="custom-control-label">{{ $label }}</label>
</div>
@error($name)
    <div class="form-text text-danger">
        {{ $message }}
    </div>
@enderror
