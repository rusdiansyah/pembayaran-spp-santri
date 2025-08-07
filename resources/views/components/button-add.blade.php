@props(['type' => 'button', 'modal' => 'Ya'])
<button type="{{ $type }}" class="btn btn-sm btn-primary" wire:click="addPost"
    @if ($modal == 'Ya') data-toggle="modal" data-target="#modalForm" @endif>
    <i class="fas fa-plus"></i>
    Tambah
</button>
