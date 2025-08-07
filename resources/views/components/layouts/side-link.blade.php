<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <x-menu-item link="/dashboard" label="Dashboard" icon="fa-tachometer-alt" />

        <li class="nav-item {{ request()->segment(1) == 'setting' ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->segment(1) == 'setting' ? 'active' : '' }}">
                <i class="nav-icon fas fa-cogs"></i>
                <p>
                    Setting
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <x-menu-item link="/setting/identitas" label="Identitas" icon="fa-asterisk" />
                <x-menu-item link="/setting/favicon" label="Favicon" icon="fa-asterisk" />
                <x-menu-item link="/setting/logo_login" label="Background Login" icon="fa-asterisk" />
                <x-menu-item link="/setting/logo_home" label="Login Home" icon="fa-asterisk" />
            </ul>
        </li>
        <li class="nav-item {{ request()->segment(1) == 'user' ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->segment(1) == 'user' ? 'active' : '' }}">
                <i class="nav-icon fas fa-users"></i>
                <p>
                    Management User
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <x-menu-item link="/user/role" label="Role" icon="far fa-arrow-alt-circle-right" />
                <x-menu-item link="/user/user" label="User" icon="far fa-arrow-alt-circle-right" />
            </ul>
        </li>
        <li class="nav-item {{ request()->segment(1) == 'config' ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->segment(1) == 'config' ? 'active' : '' }}">
                <i class="nav-icon fas fa-tools"></i>
                <p>
                    Config
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <x-menu-item link="/config/tahunAjaranList" label="Tahun Ajaran" icon="far fa-arrow-alt-circle-right" />
                <x-menu-item link="/config/kelasList" label="Kelas" icon="far fa-arrow-alt-circle-right" />
                <x-menu-item link="/config/jenisTagihanList" label="Jenis Tagihan"
                    icon="far fa-arrow-alt-circle-right" />
            </ul>
        </li>
        <x-menu-item link="/santriList" label="Santri" icon="fas fa-user-plus" />
        <x-menu-item link="/tagihanList" label="Tagihan" icon="fas fa-hand-holding-usd" />
        <li class="nav-item">
            <a wire:navigate href="{{ route('pembayaranList') }}"
                class="nav-link {{ request()->segment(1) == 'pembayaran' ? 'active' : '' }}">
                <i class="fas fa-money-bill-alt nav-icon"></i>
                <p>Pembayaran</p>
            </a>
        </li>
        <x-menu-item link="/logout" label="Logout" icon="fa-sign-out-alt" />
    </ul>
</nav>
