@props(['name','label','type','attributes'])
<div class="form-group">
    <label for="{{$name}}">{{$label}}</label>
    <input type="{{$type}}"
        class="form-control @error('{{$name}}') is-invalid @enderror" id="{{$name}}"
        {{$attributes}} placeholder="{{$label}}">
    @error('{{$name}}')
        <div class="form-text text-danger">
            {{ $message }}
        </div>
    @enderror
</div>
