<div>
    <div class="card card-warning card-outline">
        <div class="card-header">
            <h3 class="card-title">{{ $title }} Filter</h3>
        </div>

        <div class="card-body table-responsive p-3">
            <div class="row">
                <div class="col-md-4">
                    <x-filter-select name="filterTahunAjaran" label="Tahun Angkatan">
                        <option value="">-Semua-</option>
                        @foreach ($this->listTahunAjaran() as $filterTA)
                            <option value="{{ $filterTA->id }}">{{ $filterTA->nama }}</option>
                        @endforeach
                    </x-filter-select>
                </div>
                <div class="col-md-4">
                    <x-filter-select name="filterJenis" label="Jenis Tagihan">
                        <option value="">-Semua-</option>
                        @foreach ($this->listJenisTagihan() as  $filterJenis)
                            <option value="{{ $filterJenis->id }}">{{ $filterJenis->nama }}</option>
                        @endforeach
                    </x-filter-select>
                </div>
                <div class="col-md-4">
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

    <div class="card card-primary card-outline">
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
                        <th>Tahun Angkatan</th>
                        <th>Santri</th>
                        <th>Nama Tagihan</th>
                        <th>Periode</th>
                        <th>Jumlah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $tot=0;
                    @endphp
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $data->firstItem() + $loop->index }}</td>
                            <td>{{ $item->santri->tahun_ajaran->nama }}</td>
                            <td>{{ $item->santri->nama }}</td>
                            <td>{{ $item->jenis_tagihan->nama }}</td>
                            <td>{{ $item->periode }}</td>
                            <td>{{ number_format($item->jumlah) }}</td>
                            <td>
                                {{-- <x-button-edit id="{{ $item->id }}" type="button" modal="Ya" /> --}}
                                <x-button-delete id="{{ $item->id }}" />
                            </td>
                        </tr>
                        @php
                            $tot=$tot+$item->jumlah;
                        @endphp
                    @endforeach
                        <tr>
                            <td colspan="5" class="text-right">Total</td>
                            <td>{{ number_format($tot) }}</td>
                            <td></td>
                        </tr>
                </tbody>
            </table>
        </div>

        <div class="card-footer clearfix">
            {{ $data->links() }}
        </div>


    </div>

    {{-- modal --}}
    <x-form-modal save="save" title="{{ $title }}" size="modal-lg">
        <div class="row">
            <div class="col-md-6">
                <x-form-select name="tahun_ajaran_id" label="Tahun Angkatan">
                    <option value="">-Pilih-</option>
                    @foreach ($this->listTahunAjaran() as $ta)
                        <option value="{{ $ta->id }}">{{ $ta->nama }}</option>
                    @endforeach
                </x-form-select>
            </div>
            <div class="col-md-6">
                <x-form-select name="jenis_tagihan_id" label="Jenis Tagihan">
                    <option value="">-Pilih-</option>
                    @foreach ($this->listJenisTagihan() as $jt)
                        <option value="{{ $jt->id }}">{{ $jt->nama }}</option>
                    @endforeach
                </x-form-select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <x-form-select name="bulanTerpilih" label="Periode Bulan">
                    <option value="">-Pilih-</option>
                    @foreach ($this->listBulan() as $index => $bulan)
                        <option value="{{ $index }}">{{ $bulan }}</option>
                    @endforeach
                </x-form-select>
            </div>
            <div class="col-md-6">
                <x-form-select name="tahunTerpilih" label="Periode Tahun">
                    <option value="">-Pilih-</option>
                    @foreach ($daftarTahun as $tahun)
                        <option value="{{ $tahun }}">{{ $tahun }}</option>
                    @endforeach
                </x-form-select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <x-form-input type="number" name="jumlah" label="Jumlah" />
            </div>
        </div>

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
