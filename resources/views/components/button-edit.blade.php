@props(['id','modal'=>'Ya'])
<button wire:click="edit({{ $id }})"
@if ($modal=='Ya')
data-toggle="modal" data-target="#modalForm"
@endif
class="btn btn-sm btn-success">
    <i class="fas fa-edit"></i>
</button>
