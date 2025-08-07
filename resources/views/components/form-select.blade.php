@props(['name','label'])
<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    <select wire:model.change="{{ $name }}" class="form-control @error( $name) is-invalid @enderror">
        {{ $slot }}
    </select>
    @error($name)
        <div class="form-text text-danger">
            {{ $message }}
        </div>
    @enderror
</div>
