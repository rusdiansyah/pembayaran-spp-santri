<div>

    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">{{ $title }} Table</h3>
            <div class="card-tools">
                <x-button-add type="button" />
            </div>
        </div>

        <div class="card-body table-responsive p-0">
            <x-table-search />

            <table class="table table-hover text-nowrap table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nomor</th>
                        <th>Tanggal</th>
                        <th>Periode</th>
                        <th>Tagihan</th>
                        <th>Jumlah</th>
                        <th>Bayar</th>
                        <th>Valid</th>
                        <th>Bukti</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $tTagihan = 0;
                        $tBayar = 0;
                    @endphp
                    @foreach ($data as $item)
                        <tr class="{{ $item->pembayaran->isValid == false ? 'text-danger' : '' }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->pembayaran->nomorBayar }}</td>
                            <td>{{ date('d-m-Y', strtotime($item->pembayaran->tanggal)) }}</td>
                            <td>{{ $item->tagihan->periode }}</td>
                            <td>{{ $item->tagihan->jenis_tagihan->nama }}</td>
                            <td class="text-right">{{ number_format($item->tagihan->jumlah) }}</td>
                            <td class="text-right">{{ number_format($item->jumlahBayar) }}</td>
                            <td>
                                @if ($item->pembayaran->isValid == true)
                                    <i class="fas fa-check text-success"></i>
                                @endif
                            </td>
                            <td>
                                @if ($item->pembayaran->jenisBayar == 'Transfer')
                                    <a href="{{ asset('storage/' . $item->pembayaran->buktiBayar) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $item->pembayaran->buktiBayar) }}" alt=""
                                            width="50">
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @php
                            $tTagihan += $item->tagihan->jumlah;
                            $tBayar += $item->jumlahBayar;
                        @endphp
                    @endforeach
                    <tr>
                        <td colspan="4" class="text-right">Total</td>
                        <td class="text-right">{{ number_format($tTagihan) }}</td>
                        <td class="text-right">{{ number_format($tBayar) }}</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="card-footer clearfix">

        </div>

    </div>


</div>
