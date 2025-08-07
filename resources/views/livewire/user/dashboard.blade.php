<div>
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h5 class="m-0">Halaman User</h5>
        </div>
        <div class="card-body">

            <h6 class="card-title">Hi <b>{{ Auth::user()->name }} [{{ Auth::user()->role->nama }}]</b> selamat datang
                di Sistem Informasi {{ config('app.name') }}</h6>
        </div>
    </div>
    <livewire:user.santri-info />
</div>
