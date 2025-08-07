@props(['id'])
<button wire:click="cofirmDelete({{ $id }})" class="btn btn-sm btn-danger">
    <i class="fas fa-trash"></i>
</button>
