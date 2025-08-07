<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">Profile</h3>
    </div>
    <form wire:submit.prevent="saveProfile">
        <div class="card-body">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" wire:model="name"
                    class="form-control @error('name') is-invalid @enderror" id="name"
                    placeholder="Nama Aplikasi">
                @error('name')
                    <div class="form-text text-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" wire:model="email"
                    class="form-control " id="email" readonly>
            </div>
            <div class="form-group">
                <label for="role">Role</label>
                <input type="text" wire:model="role"
                    class="form-control " id="role" readonly>
            </div>
        </div>

        <div class="card-footer text-center">
            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                <i class="fas fa-save"></i> Simpan
            </button>
            <div wire:loading>
                Processing ...
            </div>
        </div>
    </form>
</div>
