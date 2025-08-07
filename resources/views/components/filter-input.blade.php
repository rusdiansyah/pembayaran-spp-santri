@props(['name', 'label', 'type' => 'text'])
<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    <input type="{{ $type }}" wire:model.live="{{ $name }}" class="form-control">
</div>
