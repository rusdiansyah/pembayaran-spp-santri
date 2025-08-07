<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">Photo</h3>
    </div>
    <form wire:submit.prevent="save">
        <div class="card-body">
            @if ($photo)
                <img src="{{ $photo->temporaryUrl() }}" style="width: 350px;">
            @endif

            <div class="form-group">
                <label for="favicon">Photo</label>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" wire:model="photo"
                            class="custom-file-input @error('photo') is-invalid @enderror" id="photo">
                        <label class="custom-file-label" for="photo">Choose file</label>
                    </div>
                </div>
                <div wire:loading wire:target="photo">Uploading...</div>
                @error('photo')
                    <div class="form-text text-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            @if ($photo_old)
                <img src="{{ asset('storage/'.$photo_old) }}" style="width: 350px;">
            @endif
        </div>

        <div class="card-footer text-center">
            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                <i class="fas fa-upload"></i> Upload
            </button>
            <div wire:loading>
                Upload ...
            </div>
        </div>
    </form>
</div>
