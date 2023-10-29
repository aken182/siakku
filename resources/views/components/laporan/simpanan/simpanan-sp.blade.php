<div class="row mb-3">
    <div class="col">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-success text-dark">
                    <tr>
                        <th rowspan="2" style="text-align: center">TANGGAL/TAHUN</th>
                        <th rowspan="2" style="text-align: center">NOMOR BUKTI</th>
                        <th colspan="6" style="text-align: center">JENIS SIMPANAN</th>
                        <th rowspan="2" style="text-align: center">TOTAL SIMPANAN</th>
                    </tr>
                    <tr>
                        <th>POKOK</th>
                        <th>WAJIB</th>
                        <th>PTHK</th>
                        <th>KHUSUS</th>
                        <th>KPTLS</th>
                        <th>SUKARELA</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="2"><b>SALDO AWAL PER 31 DES {{ $tahunlalu }}</b></td>
                        <td style="text-align: right"><b>{{ cekAccounting($lp['saldoAwalPokok']) }}</b></td>
                        <td style="text-align: right"><b>{{ cekAccounting($lp['saldoAwalWajib']) }}</b></td>
                        <td style="text-align: right"><b>{{ cekAccounting($lp['saldoAwalPthk']) }}</b></td>
                        <td style="text-align: right"><b>{{ cekAccounting($lp['saldoAwalKhusus']) }}</b></td>
                        <td style="text-align: right"><b>{{ cekAccounting($lp['saldoAwalKapitalisasi']) }}</b></td>
                        <td style="text-align: right"><b>{{ cekAccounting($lp['saldoAwalSukarela']) }}</b></td>
                        <td style="text-align: right"><b>{{ cekAccounting($lp['saldoAwal']) }}</b></td>
                    </tr>
                    @php
                        $saldo = 0;
                        $saldoPokok = 0;
                        $saldoWajib = 0;
                        $saldoPthk = 0;
                        $saldoKhusus = 0;
                        $saldoKapitalisasi = 0;
                        $saldoSukarela = 0;
                        $saldo += $lp['saldoAwal'];
                        $saldoPokok += $lp['saldoAwalPokok'];
                        $saldoWajib += $lp['saldoAwalWajib'];
                        $saldoPthk += $lp['saldoAwalPthk'];
                        $saldoKhusus += $lp['saldoAwalKhusus'];
                        $saldoKapitalisasi += $lp['saldoAwalKapitalisasi'];
                        $saldoSukarela += $lp['saldoAwalSukarela'];
                    @endphp
                    @foreach ($lp['laporan'] as $l)
                        <tr>
                            <td>{{ date('d-m-Y', strtotime($l['tgl_transaksi'])) }}</td>
                            <td>{{ $l['no_bukti'] }}</td>
                            <td style="text-align: right">{{ cekAccounting($l['jumlah_pokok']) }}</td>
                            <td style="text-align: right">{{ cekAccounting($l['jumlah_wajib']) }}</td>
                            <td style="text-align: right">{{ cekAccounting($l['jumlah_pthk']) }}</td>
                            <td style="text-align: right">{{ cekAccounting($l['jumlah_khusus']) }}</td>
                            <td style="text-align: right">{{ cekAccounting($l['jumlah_kapitalisasi']) }}</td>
                            <td style="text-align: right">{{ cekAccounting($l['jumlah_sukarela']) }}</td>
                            @php
                                $saldoPokok += $l['jumlah_pokok'];
                                $saldoWajib += $l['jumlah_wajib'];
                                $saldoPthk += $l['jumlah_pthk'];
                                $saldoKhusus += $l['jumlah_khusus'];
                                $saldoKapitalisasi += $l['jumlah_kapitalisasi'];
                                $saldoSukarela += $l['jumlah_sukarela'];
                                $saldox = $l['jumlah_pokok'] + $l['jumlah_wajib'] + $l['jumlah_pthk'] + $l['jumlah_khusus'] + $l['jumlah_kapitalisasi'] + $l['jumlah_sukarela'];
                                $saldo += $saldox;
                            @endphp
                            <td style="text-align: right">{{ cekAccounting($saldo) }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="2"><b>SALDO PER {{ "$hari/$bulan/$tahun" }}</b></td>
                        <td style="text-align: right"><b>{{ cekAccounting($saldoPokok) }}</b></td>
                        <td style="text-align: right"><b>{{ cekAccounting($saldoWajib) }}</b></td>
                        <td style="text-align: right"><b>{{ cekAccounting($saldoPthk) }}</b></td>
                        <td style="text-align: right"><b>{{ cekAccounting($saldoKhusus) }}</b></td>
                        <td style="text-align: right"><b>{{ cekAccounting($saldoKapitalisasi) }}</b></td>
                        <td style="text-align: right"><b>{{ cekAccounting($saldoSukarela) }}</b></td>
                        <td style="text-align: right"><b>{{ cekAccounting($saldo) }}</b></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
