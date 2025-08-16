<div>
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">{{ $title }} Filter</h3>
        </div>

        <div class="card-body table-responsive p-3">
            <div class="row">
                <div class="col-md-6">
                    <x-filter-select name="filterTahunAjaran" label="Tahun Ajaran">
                        <option value="">-Semua-</option>
                        @foreach ($this->listTahunAjaran() as $filterTA)
                            <option value="{{ $filterTA->id }}">{{ $filterTA->nama }}</option>
                        @endforeach
                    </x-filter-select>
                </div>
                <div class="col-md-6">
                    <x-filter-select name="filterJenisKelamin" label="Jenis Kelamin">
                        <option value="">-Semua-</option>
                        @foreach ($this->listJenisKelamin() as $index => $filterJK)
                            <option value="{{ $index }}">{{ $filterJK }}</option>
                        @endforeach
                    </x-filter-select>
                </div>
            </div>
        </div>
    </div>

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
                        <th>Tahun Ajaran</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Email</th>
                        <th>No Telp</th>
                        <th>Tagihan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total = 0;
                    @endphp
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $data->firstItem() + $loop->index }}</td>
                            <td>{{ $item->tahun_ajaran->nama }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->kelas->nama }}</td>
                            <td>{{ $item->user->email }}</td>
                            <td>{{ $item->no_telp_wali }}</td>
                            <td class="text-right">{{ number_format($item->Tagihan()) }}</td>
                            <td>
                                <x-button-edit id="{{ $item->id }}" type="button" modal="Ya" />
                                <x-button-delete id="{{ $item->id }}" />
                            </td>
                        </tr>
                        @php
                            $total +=$item->Tagihan();
                        @endphp
                    @endforeach
                        <tr>
                            <td colspan="6" class="text-right">Total Tagihan</td>
                            <td class="text-right">{{ number_format($total) }}</td>
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
                <x-form-select name="tahun_ajaran_id" label="Tahun Ajaran">
                    <option value="">-Pilih-</option>
                    @foreach ($this->listTahunAjaran() as $ta)
                        <option value="{{ $ta->id }}">{{ $ta->nama }}</option>
                    @endforeach
                </x-form-select>
            </div>
            <div class="col-md-6">
                <x-form-select name="kelas_id" label="Kelas">
                    <option value="">-Pilih-</option>
                    @foreach ($this->listKelas() as $kelas)
                        <option value="{{ $kelas->id }}">{{ $kelas->nama }}</option>
                    @endforeach
                </x-form-select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <x-form-input type="number" name="nisn" label="NISN" />
            </div>
            <div class="col-md-6">
                <x-form-input name="nama" label="Nama" />
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <x-form-input name="tempat_lahir" label="Tempat Lahir" />
            </div>
            <div class="col-md-6">
                <x-form-input type="date" name="tanggal_lahir" label="Tanggal Lahir" />
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <x-form-select name="jenis_kelamin" label="Jenis Kelamin">
                    <option value="">-Pilih-</option>
                    @foreach ($this->listJenisKelamin() as $index => $jk)
                        <option value="{{ $index }}">{{ $jk }}</option>
                    @endforeach
                </x-form-select>
            </div>
            <div class="col-md-6">
                <x-form-input type="email" name="email" label="Email" />
            </div>
        </div>
        <x-form-input name="alamat" label="Alamat" />
        <div class="row">
            <div class="col-md-6">
                <x-form-input name="nama_wali" label="Nama Wali" />
            </div>
            <div class="col-md-6">
                <x-form-input name="no_telp_wali" label="No Telp Wali" />
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
