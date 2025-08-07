@props(['type'=>'submit','class'])
<button type="{{$type}}" class="btn btn-primary" wire:loading.attr="hidden">
    <i class="fas fa-save"></i> Simpan
</button>
