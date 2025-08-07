<div>
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">{{ $title }}</h3>
        </div>
        <form wire:submit.prevent="save">
            <div class="card-body">

                <div class="form-group">
                    <label for="favicon">Favicon</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" wire:model="favicon" class="custom-file-input @error('favicon') is-invalid @enderror" id="favicon">
                            <label class="custom-file-label" for="favicon">Choose file</label>
                        </div>
                    </div>
                    <div wire:loading wire:target="favicon">Uploading...</div>
                    @error('favicon')
                        <div class="form-text text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
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
</div>
@script
    <script>
        document.addEventListener("swal", event => {
            Swal.fire({
                icon: event.detail[0].icon,
                title: event.detail[0].title,
                text: event.detail[0].text,
            });
        });
    </script>
@endscript
