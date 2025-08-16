<div>
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">{{ $title }} Filter</h3>
            <div class="card-tools">
                <x-button-back route="pembayaranList" />
            </div>
        </div>

        <div class="card-body table-responsive p-3">
            <div class="row">
                <div class="col-md-6">
                    <x-filter-select name="filterTahunAjaran" label="Tahun Angkatan">
                        <option value="">-Semua-</option>
                        @foreach ($this->listTahunAjaran() as $filterTA)
                            <option value="{{ $filterTA->id }}">{{ $filterTA->nama }}</option>
                        @endforeach
                    </x-filter-select>
                </div>
                <div class="col-md-6">
                    <x-filter-select name="filterJenisTagihan" label="Jenis Tagihan">
                        <option value="">-Semua-</option>
                        @foreach ($this->listJenisTagihan() as  $filterJenis)
                            <option value="{{ $filterJenis->id }}">{{ $filterJenis->nama }}</option>
                        @endforeach
                    </x-filter-select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <x-filter-input type="date" name="filterTanggal" label="Tanggal" />
                </div>
                <div class="col-md-6">
                    <x-filter-select name="filterPeriode" label="Periode">
                        <option value="">-Semua-</option>
                        @foreach ($this->listPeriode() as  $filterPeriode)
                            <option value="{{ $filterPeriode }}">{{ $filterPeriode }}</option>
                        @endforeach
                    </x-filter-select>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $title }} Table</h3>
        </div>

        <div class="card-body table-responsive p-0">
            <x-table-search />

            <table class="table table-hover text-nowrap table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>Santri</th>
                        <th>Periode</th>
                        <th>Tagihan</th>
                        <th>Jumlah</th>
                        <th>Bayar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $tTagihan=0;
                        $tBayar=0;
                    @endphp
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $data->firstItem() + $loop->index }}</td>
                            <td>{{ date("d-m-Y",strtotime($item->pembayaran->tanggal)) }}</td>
                            <td>{{ $item->pembayaran->santri->nama }}</td>
                            <td>{{ $item->tagihan->periode }}</td>
                            <td>{{ $item->tagihan->jenis_tagihan->nama }}</td>
                            <td class="text-right">{{ number_format($item->tagihan->jumlah) }}</td>
                            <td class="text-right">{{ number_format($item->jumlahBayar) }}</td>
                            <td>
                                <x-button-delete id="{{ $item->id }}" />
                            </td>
                        </tr>
                        @php
                            $tTagihan+=$item->tagihan->jumlah;
                            $tBayar+=$item->jumlahBayar;
                        @endphp
                    @endforeach
                        <tr>
                            <td colspan="5" class="text-right">Total</td>
                            <td class="text-right">{{ number_format($tTagihan) }}</td>
                            <td class="text-right">{{ number_format($tBayar) }}</td>
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
