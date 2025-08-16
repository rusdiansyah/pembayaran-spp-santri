<div>
    <div class="card card-warning card-outline">
        <div class="card-header">
            <h3 class="card-title">Data Santri</h3>
            <div class="card-tools">
                <x-button-back route="userPembayaranList" />
            </div>
        </div>
        <form wire:submit.prevent="save">
            <div class="card-body table-responsive p-3">
                <div class="row">
                    <div class="col-md-6">
                        <x-form-input name="nama" label="Nama Santri" readonly />
                    </div>
                    <div class="col-md-3">
                        <x-form-input name="nisn" label="NISN" readonly />
                    </div>
                    <div class="col-md-3">
                        <x-form-input name="kelas" label="Kelas" readonly />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-form-select name="jenisBayar" label="Jenis Bayar">
                            @foreach ($this->listJenisBayar() as $jenis)
                                <option value="{{ $jenis }}">{{ $jenis }}</option>
                            @endforeach
                        </x-form-select>
                    </div>
                    <div class="col-md-6">
                        <x-form-input type="file" name="buktiBayar" label="Bukti Bayar" />
                    </div>

                </div>
            </div>
    </div>

    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">{{ $title }} Detail</h3>

        </div>

        <div class="card-body table-responsive p-0">

            <table class="table table-hover text-nowrap table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Periode</th>
                        <th>Jenis Tagihan</th>
                        <th>Jumlah</th>
                        <th>Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $tot = 0;
                    @endphp
                    @foreach ($data as $index => $item)
                        @if ($item['jumlah'] > 0)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item['periode'] }}</td>
                                <td>{{ $item['jenis_tagihan'] }}</td>
                                <td>{{ number_format($item['jumlah']) }}</td>
                                <td class="col-md-3">
                                    <input type="number" wire:model.live="bayar.{{ $item['id_tagihan'] }}"
                                        class="form-control" min="0">
                                </td>
                            </tr>
                            @php
                                $tot += $item['jumlah'];
                            @endphp
                        @endif
                    @endforeach
                    <tr>
                        <td colspan="3" class="text-right">Total</td>
                        <td>{{ number_format($tot) }}</td>
                        <td class="col-md-3">
                            <input type="text" class="form-control"
                                value="{{ number_format($totalBayar, 0, ',', '.') }}" readonly>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="card-footer clearfix text-center">
            <x-button-save />
        </div>
        </form>
    </div>


</div>
@script
    <script>
        $wire.on('close-modal', () => {
            $(".btn-close").trigger("click");
        });
    </script>
@endscript
