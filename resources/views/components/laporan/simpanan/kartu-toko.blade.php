<div class="row mb-3">
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-success text-dark">
                <tr>
                    <th rowspan="2">Tanggal</th>
                    <th rowspan="2">No. Bukti</th>
                    <th colspan="4" style="text-align: center">Simpanan</th>
                    <th rowspan="2">Saldo Hutang {{ $tahunlalu }}</th>
                    <th colspan="3" style="text-align: center">Penambahan {{ $tahun }}
                    </th>
                    <th rowspan="2">Jumlah</th>
                    <th colspan="3" style="text-align: center">Tunai</th>
                    <th rowspan="2">Jumlah</th>
                    <th rowspan="2">Daftar Potongan</th>
                    <th rowspan="2">Saldo Akhir {{ $tahun }}</th>
                </tr>
                <tr>
                    <th>Saldo Akhir {{ $tahunlalu }}</th>
                    <th>Masuk Tahun {{ $tahun }}</th>
                    <th>Penarikan Tahun {{ $tahun }}</th>
                    <th>Jumlah</th>
                    <th>Larantuka</th>
                    <th>Pasar Baru</th>
                    <th>Waiwerang</th>
                    <th>Larantuka</th>
                    <th>Pasar Baru</th>
                    <th>Waiwerang</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="2"><b class="text-capitalize">saldo awal per
                            01/01/{{ $tahun }}</b></td>
                    <td style="text-align: right">
                        <b>{{ cekAccounting($lp['saldoAwalSimpanan']) }}</b>
                    </td>
                    <td></td>
                    <td></td>
                    <td style="text-align: right">
                        <b>{{ cekAccounting($lp['saldoAwalSimpanan']) }}</b>
                    </td>
                    <td style="text-align: right">
                        <b>{{ cekAccounting($lp['saldoAwalHutang']) }}</b>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="text-align: right">
                        <b>{{ cekAccounting($lp['saldoAwalHutang']) }}</b>
                    </td>
                </tr>
                @php
                    $saldoHutang = $lp['saldoAwalHutang'] ?? 0;
                    $saldoSimpanan = $lp['saldoAwalSimpanan'] ?? 0;
                @endphp
                @foreach ($lp['kartuToko'] as $item)
                    <tr>
                        <td>{{ date('d/m/Y', strtotime($item['tgl_transaksi'])) }}</td>
                        <td>{{ $item['no_bukti'] }}</td>
                        <td style="text-align: right"></td>
                        <td style="text-align: right">
                            {{ cekAccounting($item['jumlah_simpanan']) }}
                        </td>
                        <td style="text-align: right">
                            {{ cekAccounting($item['jumlah_penarikan']) }}
                        </td>
                        @php
                            $saldoSimpanan = $saldoSimpanan + $item['jumlah_simpanan'] - $item['jumlah_penarikan'];
                        @endphp
                        <td style="text-align: right">
                            {{ cekAccounting($saldoSimpanan) }}
                        </td>
                        <td></td>
                        <td style="text-align: right">{{ cekAccounting($item['penambahan_lrtk']) }}
                        </td>
                        <td style="text-align: right">{{ cekAccounting($item['penambahan_psr']) }}
                        </td>
                        <td style="text-align: right">{{ cekAccounting($item['penambahan_wrg']) }}
                        </td>
                        <td></td>
                        <td style="text-align: right">{{ cekAccounting($item['tunai_lrtk']) }}
                        </td>
                        <td style="text-align: right">{{ cekAccounting($item['tunai_psr']) }}
                        </td>
                        <td style="text-align: right">{{ cekAccounting($item['tunai_wrg']) }}
                        </td>
                        <td></td>
                        <td style="text-align: right">{{ cekAccounting($item['pot_bendahara']) }}
                        </td>
                        @php
                            $saldoHutang = $saldoHutang + $item['penambahan_lrtk'] + $item['penambahan_psr'] + $item['penambahan_wrg'] - ($item['tunai_lrtk'] + $item['tunai_psr'] + $item['tunai_wrg'] + $item['pot_bendahara']);
                        @endphp
                        <td style="text-align: right">
                            {{ cekAccounting($saldoHutang) }}
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="2"><b class="text-uppercase">Jumlah</b></td>
                    <td></td>
                    <td style="text-align: right">
                        <b>{{ cekAccounting($lp['saldoPenyimpanan']) }}</b>
                    </td>
                    <td style="text-align: right">
                        <b>{{ cekAccounting($lp['saldoPenarikan']) }}</b>
                    </td>
                    <td></td>
                    <td></td>
                    <td style="text-align: right">
                        <b>{{ cekAccounting($lp['saldoPenambahanLrtk']) }}</b>
                    </td>
                    <td style="text-align: right">
                        <b>{{ cekAccounting($lp['saldoPenambahanPsr']) }}</b>
                    </td>
                    <td style="text-align: right">
                        <b>{{ cekAccounting($lp['saldoPenambahanWrg']) }}</b>
                    </td>
                    <td></td>
                    <td style="text-align: right">
                        <b>{{ cekAccounting($lp['saldoTunaiLrtk']) }}</b>
                    </td>
                    <td style="text-align: right">
                        <b>{{ cekAccounting($lp['saldoTunaiPsr']) }}</b>
                    </td>
                    <td style="text-align: right">
                        <b>{{ cekAccounting($lp['saldoTunaiWrg']) }}</b>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2"><b class="text-uppercase">Total</b></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="text-align: right">
                        <b>{{ cekAccounting($lp['saldoAkhirSimpanan']) }}</b>
                    </td>
                    <td style="text-align: right">
                        <b>{{ cekAccounting($lp['saldoAwalHutang']) }}</b>
                    </td>
                    <td style="text-align: right"></td>
                    <td style="text-align: right"></td>
                    <td style="text-align: right"></td>
                    <td style="text-align: right">
                        <b>{{ cekAccounting($lp['saldoPenambahan']) }}</b>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="text-align: right">
                        <b>{{ cekAccounting($lp['saldoTunai']) }}</b>
                    </td>
                    <td style="text-align: right">
                        <b>{{ cekAccounting($lp['saldoPotongan']) }}</b>
                    </td>
                    <td style="text-align: right">
                        <b>{{ cekAccounting($lp['saldoAkhirHutang']) }}</b>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
