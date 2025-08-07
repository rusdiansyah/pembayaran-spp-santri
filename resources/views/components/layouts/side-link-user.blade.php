<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
        data-accordion="false">
        <li class="nav-item">
            <a href="/user/dashboard" wire:navigate class="nav-link" wire:current="active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
            </a>
        </li>
        <x-menu-item link="/user/tagihanList" label="Tagihan" icon="fas fa-hand-holding-usd" />
        <x-menu-item link="/user/pembayaranList" label="Pembayaran" icon="fas fa-money-bill-alt" />
        <li class="nav-item">
            <a wire:navigate href="/logout" class="nav-link">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>Logout</p>
            </a>
        </li>
    </ul>
</nav>
