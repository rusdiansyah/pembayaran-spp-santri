@props(['name', 'label', 'attributes'])
<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    <textarea class="form-control" name="{{ $name }}" id="{{ $name }}" rows="4">{{ $label }}</textarea>
    @error('{{ $name }}')
        <div class="form-text text-danger">
            {{ $message }}
        </div>
    @enderror
</div>
