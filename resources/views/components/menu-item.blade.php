@props(['link','label','icon'])
<li class="nav-item">
    <a wire:navigate href="{{ $link }}" class="nav-link"  wire:current="active">
        <i class="fas {{ $icon }} nav-icon"></i>
        <p>{{ $label }}</p>
    </a>
</li>
