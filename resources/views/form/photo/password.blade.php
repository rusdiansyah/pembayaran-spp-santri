<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">Ganti Password</h3>
    </div>
    <form wire:submit.prevent="savePassword">
        <div class="card-body">
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" wire:model="password"
                    class="form-control @error('password') is-invalid @enderror" id="password"
                    placeholder="password" >
                @error('password')
                    <div class="form-text text-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="password_confirmation">Password Confirmation</label>
                <input type="password_confirmation" wire:model="password_confirmation"
                    class="form-control @error('password_confirmation') is-invalid @enderror"
                    id="password_confirmation" placeholder="password_confirmation" >
                @error('password_confirmation')
                    <div class="form-text text-danger">
                        {{ $message }}
                    </div>
                @enderror
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
