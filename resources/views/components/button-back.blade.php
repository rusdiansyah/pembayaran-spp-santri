@props(['type' => 'button', 'route'])
<a wire:navigate href="{{ route($route) }}" class="btn btn-sm btn-primary">
    <i class="far fa-arrow-alt-circle-left"></i> Kembali
</a>
