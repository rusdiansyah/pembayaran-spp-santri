<aside x-transition class="main-sidebar sidebar-dark-warning elevation-4">
    <a wire:navigate href="/dashboard" class="brand-link">
        @php
            $logo = App\Models\Setting::where('id', 1)->first();
            $photo = Auth::user()->photo;
        @endphp
        @if ($logo)
            <img src="{{ asset('storage/'.$logo->logo_home) }}" alt="{{ config('app.name') }}"
                class="brand-image img-circle elevation-3" style="opacity: .8">
        @else
            <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="{{ config('app.name') }}"
                class="brand-image img-circle elevation-3" style="opacity: .8">
        @endif
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @if ($photo)
                    <img src="{{ asset('storage/'.$photo) }}" class="img-circle elevation-2" alt="{{ Auth::user()->name }}">
                @else
                    <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                        alt="{{ Auth::user()->name }}">
                @endif
            </div>
            <div class="info">
                <a wire:navigate href="/photouser" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>


        <!-- Sidebar Menu -->
        @if (Auth::user()->role->nama == 'Admin')
            <x-layouts.side-link></x-layouts.side-link>
        @elseif (Auth::user()->role->nama == 'Santri')
            <x-layouts.side-link-user></x-layouts.side-link-user>
        @endif
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
