<div>


    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">{{ $title }} Table</h3>
        </div>

        <div class="card-body table-responsive p-0">
            <x-table-search />

            <table class="table table-hover text-nowrap table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Periode</th>
                        <th>Nama Tagihan</th>
                        <th>Jumlah</th>
                        <th>Dibayar</th>
                        <th>Tagihan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $tJumlah = 0;
                        $tDibayar = 0;
                        $tTagihan = 0;
                    @endphp
                    @foreach ($data as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item['periode'] }}</td>
                            <td>{{ $item['jenis_tagihan'] }}</td>
                            <td>{{ number_format($item['jumlah']) }}</td>
                            <td>{{ number_format($item['dibayar']) }}</td>
                            <td>{{ number_format($item['tagihan']) }}</td>
                            <td>
                                @if ($item['status'] == 'Lunas')
                                    <span class="badge badge-success">{{ $item['status'] }}</span>
                                @else
                                    <span class="badge badge-danger">{{ $item['status'] }}</span>
                                @endif

                            </td>
                        </tr>
                        @php
                            $tJumlah += $item['jumlah'];
                            $tDibayar += $item['dibayar'];
                            $tTagihan += $item['tagihan'];
                        @endphp
                    @endforeach
                    <tr>
                        <td colspan="3" class="text-right">Total</td>
                        <td>{{ number_format($tJumlah) }}</td>
                        <td>{{ number_format($tDibayar) }}</td>
                        <td>{{ number_format($tTagihan) }}</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>



</div>
