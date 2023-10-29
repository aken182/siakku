<div class="row mb-3">
    <div class="col">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-success">
                    <tr>
                        <th>TANGGAL/TAHUN</th>
                        <th>NOMOR BUKTI</th>
                        <th>SALDO AWAL</th>
                        <th>SETORAN POKOK</th>
                        <th>TARIK POKOK</th>
                        <th>JUMLAH SIMPANAN</th>
                        <th>BUNGA PER BULAN</th>
                        <th>TARIK BUNGA</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="2" style="text-align: center"><b>SALDO AWAL</b></td>
                        <td style="text-align:right"><b>{{ cekAccounting($lp['saldoAwal']) }}</b></td>
                        <td style="text-align:right"></td>
                        <td style="text-align:right"></td>
                        <td style="text-align:right"></td>
                        <td style="text-align:right"></td>
                        <td style="text-align:right"></td>
                    </tr>
                    @foreach ($lp['data'] as $item)
                        <tr>
                            <td style="text-align: center">{{ date('d-m-Y', strtotime($item['tgl_transaksi'])) }}</td>
                            <td style="text-align: center">{{ $item['no_bukti'] }}</td>
                            <td style="text-align:right"></td>
                            <td style="text-align:right">{{ cekAccounting($item['setor_pokok']) }}</td>
                            <td style="text-align:right">{{ cekAccounting($item['tarik_pokok']) }}</td>
                            <td style="text-align:right">{{ cekAccounting($item['saldo']) }}</td>
                            <td style="text-align:right">{{ cekAccounting($item['bunga']) }}</td>
                            <td style="text-align:right">{{ cekAccounting($item['tarik_bunga']) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
