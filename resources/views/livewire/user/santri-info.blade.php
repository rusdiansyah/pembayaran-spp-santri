<div>

    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">{{ $title }}</h3>
        </div>

        <div class="card-body table-responsive p-3">
            <div class="row">
                <div class="col-md-6">
                    <x-form-input name="nisn" label="NISN" readonly />
                </div>
                <div class="col-md-6">
                    <x-form-input name="nama" label="Nama" readonly />
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <x-form-input name="tempat_lahir" label="Tempat Lahir" readonly />
                </div>
                <div class="col-md-6">
                    <x-form-input name="tanggal_lahir" label="Tanggal Lahir" readonly />
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <x-form-input name="jenis_kelamin" label="Jenis Kelamin" readonly />
                </div>
                <div class="col-md-6">
                    <x-form-input  name="email" label="Email" readonly />
                </div>
            </div>
            <x-form-input name="alamat" label="Alamat" readonly />
            <div class="row">
                <div class="col-md-6">
                    <x-form-input name="nama_wali" label="Nama Wali" readonly />
                </div>
                <div class="col-md-6">
                    <x-form-input name="no_telp_wali" label="No Telp Wali" readonly />
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <x-form-input name="tahun_ajaran" label="Tahun Ajaran" readonly />
                </div>
                <div class="col-md-6">
                    <x-form-input name="kelas" label="Kelas" readonly />
                </div>
            </div>
        </div>
    </div>
</div>
