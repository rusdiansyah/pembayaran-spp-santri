@props(['name','label'])
<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    <select wire:model.live="{{ $name }}" class="form-control @error( $name) is-invalid @enderror">
        {{ $slot }}
    </select>
</div>
