@props(['type','class'])
<button type="{{$type}}" class="btn {{$class}}" wire:loading.attr="hidden">
    {{$slot}}
</button>
