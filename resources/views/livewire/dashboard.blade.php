<div>
    <div class="card card-primary">
        <div class="card-header">
            <h5 class="m-0">Halaman Admin</h5>
        </div>
        <div class="card-body">

            <h6 class="card-title">Hi <b>{{ Auth::user()->name }} [{{ Auth::user()->role->nama }}]</b> selamat datang
                di Sistem Informasi {{ config('app.name') }}</h6>
        </div>
    </div>
    <div class="row">
        <x-small-box label="Santri" jumlah="{{ $jmlSantri }}" route="santriList" color="info" icon="ion-person" />
        <x-small-box label="Tagihan" jumlah="{{ $jmlTagihan }}" route="tagihanList" color="warning" icon="ion-edit" />
        <x-small-box label="Pembayaran" jumlah="{{ $jmlPembayaran }}" route="pembayaranList" color="success" icon="ion-laptop" />
        <x-small-box label="Piutang" jumlah="{{ $piutang }}" route="santriList" color="danger" icon="ion-pie-graph" />
    </div>
</div>
