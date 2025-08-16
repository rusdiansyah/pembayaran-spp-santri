<div>
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $title }} Table</h3>
            <div class="card-tools">
                <x-button-add type="button" modal="Ya" />
            </div>
        </div>

        <div class="card-body table-responsive p-0">
            <x-table-search />

            <table class="table table-hover text-nowrap table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Tingkat</th>
                        <th>Wali Kelas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $data->firstItem() + $loop->index }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->tingkat }}</td>
                            <td>{{ $item->wali_kelas }}</td>
                            <td>
                                <x-button-edit id="{{ $item->id }}" type="button" modal="Ya" />
                                <x-button-delete id="{{ $item->id }}" />
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

        <div class="card-footer clearfix">
            {{ $data->links() }}
        </div>


    </div>

    {{-- modal --}}
    <x-form-modal save="save" title="{{ $title }}">
        <x-form-input name="nama" label="Nama" />
        <x-form-input name="tingkat" label="Tingkat" />
        <x-form-input name="wali_kelas" label="Wali Kelas" />
    </x-form-modal>

</div>
@script
    <script>
        $wire.on('close-modal', () => {
            $(".btn-close").trigger("click");
        });

        $wire.on("confirm", (event) => {
            Swal.fire({
                title: "Yakin dihapus?",
                text: "Anda tidak dapat mengembalikannya!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.dispatch("delete", {
                        id: event.id
                    });
                }
            });
        });
    </script>
@endscript
