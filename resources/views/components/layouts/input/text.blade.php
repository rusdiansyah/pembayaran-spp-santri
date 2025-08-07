<div class="form-group">
    <label for="{{$model_name}}">{{$label}}</label>
    <input type="text" wire:model="{{$model_name}}"
        class="form-control @error('{{$model_name}}') is-invalid @enderror" id="{{$model_name}}"
        placeholder="{{$label}}">
    @error('{{$model_name}}')
        <div class="form-text text-danger">
            {{ $message }}
        </div>
    @enderror
</div>
