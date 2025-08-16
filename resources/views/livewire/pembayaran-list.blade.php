<div>
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">{{ $title }} Table</h3>
            <div class="card-tools">
                <x-button-add type="button" />
                <a wire:navigate href="{{ route('pembayaranDetail') }}" class="btn btn-sm btn-info">Detail</a>
            </div>
        </div>

        <div class="card-body table-responsive p-0">
            <x-table-search />

            <table class="table table-hover text-nowrap table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>Santri</th>
                        <th>Bayar</th>
                        <th>Jumlah</th>
                        <th>Items</th>
                        <th>Bukti</th>
                        <th>Valid</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $tot = 0;
                    @endphp
                    @foreach ($data as $item)
                        <tr class="{{ $item->isValid==0 ? 'text-danger' : '' }}">
                            <td>{{ $data->firstItem() + $loop->index }}</td>
                            <td>{{ date('d-m-Y', strtotime($item->tanggal)) }}</td>
                            <td>{{ $item->santri->nama }}</td>
                            <td>{{ $item->jenisBayar }}</td>
                            <td>{{ number_format($item->totalBayar) }}</td>
                            <td>{{ $item->detail->count() }}</td>
                            <td>
                                @if ($item->buktiBayar)
                                <a href="{{ asset('storage/'.$item->buktiBayar) }}" target="_blank">
                                    <img src="{{ asset('storage/'.$item->buktiBayar) }}" alt="{{ $item->id }}" width="50">
                                </a>
                                @endif
                            </td>
                            <td>
                                <div class="form-group" wire:click="saveValid({{ $item->id }})">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch{{ $item->id }}" wire:model="isValid.{{ $item->id }}" >
                                        <label class="custom-control-label" for="customSwitch{{ $item->id }}"></label>
                                    </div>
                                </div>
                            </td>
                            <td>
                                {{-- <x-button-edit id="{{ $item->id }}" type="button" /> --}}
                                <x-button-delete id="{{ $item->id }}" />
                            </td>
                        </tr>
                        @php
                            $tot += $item->totalBayar;
                        @endphp
                    @endforeach
                    <tr>
                        <td colspan="4" class="text-right">Total</td>
                        <td>{{ number_format($tot) }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="card-footer clearfix">
            {{ $data->links() }}
        </div>

    </div>


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
