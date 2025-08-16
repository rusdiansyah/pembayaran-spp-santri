<div>
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $title }}</h3>
        </div>
        <form wire:submit.prevent="save">
            <div class="card-body">
                <x-form-input name="nama_aplikasi" label="Nama Aplikasi" />
                <x-form-input name="nama_perusahaan" label="Nama Perusahaan" />
                <x-form-input name="copyright" label="Copyright" />
                <x-form-text-area name="alamat" label="Alamat" />
            </div>

            <div class="card-footer text-center">
                <x-button-save />
            </div>
        </form>
    </div>
</div>
