<div class="row">
    <div class="col-md-12 col-sm-12 col-lg-12">
        <div class="table-responsive">
            <table class="table table-hover">
                <tr>
                    <td colspan="4"><b class="text-uppercase">I. Penjualan Barang Januari s/d
                            {{ "$bulanini $tahun" }}</b></td>
                </tr>
                @isset($lap['penjualanBarang'])
                    @php
                        $nop = 0;
                    @endphp
                    @foreach ($lap['penjualanBarang'] as $p)
                        @php
                            $nop++;
                        @endphp
                        <tr>
                            <td>{{ "$nop. $p->nama" }}</td>
                            <td style="text-align: right">{{ cek_uang($p->total_saldo) }}</td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endforeach
                    <tr>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Total Penjualan</b></td>
                        <td></td>
                        <td style="text-align: right"><b>{{ cek_uang($lap['totalPenjualan']) }}</b></td>
                        <td></td>
                    </tr>
                @endisset
                <tr>
                    <td colspan="4"><b class="text-uppercase">II. Harga Pokok Penjualan</b></td>
                </tr>
                <tr>
                    <td>1. Persediaan Awal</td>
                    <td style="text-align: right">{{ cek_uang($lap['persediaanAwal']) }}</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>2. Pengadaan Januari s/d {{ "$bulanini $tahun" }}</td>
                    <td style="text-align: right">{{ cek_uang($lap['pengadaanTahunBerjalan']) }}</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>3. Barang Siap Dijual</td>
                    <td style="text-align: right">{{ cek_uang($lap['persediaanSiapJual']) }}</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>4. Persediaan Akhir</td>
                    <td style="text-align: right">{{ cek_uang($lap['persediaanAkhir']) }}</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Total Harga Pokok Penjualan</b></td>
                    <td></td>
                    <td style="text-align: right"><b>{{ cek_uang($lap['hpp']) }}</b></td>
                    <td></td>
                </tr>
                <tr>
                    <td><b class="text-uppercase">III. Laba Kotor / Bruto</b></td>
                    <td></td>
                    <td style="text-align: right"><b>{{ cek_uang($lap['labaKotor']) }}</b></td>
                    <td></td>
                </tr>
                @isset($lap['pendapatanLainBulanSebelum'])
                    <tr>
                        <td><b class="text-uppercase">IV. Pendapatan Lain - Lain Januari s/d {{ "$bulanlalu $tahun" }}</b>
                        </td>
                        <td></td>
                        <td style="text-align: right"><b>{{ cek_uang($lap['pendapatanLainBulanSebelum']) }}</b></td>
                        <td></td>
                    </tr>
                @endisset
                <tr>
                    <td><b class="text-uppercase">V. Pendapatan Lain - Lain {{ "$bulanini $tahun" }}</b>
                    </td>
                    <td></td>
                    <td style="text-align: right"><b>{{ cek_uang($lap['pendapatanLainBulanIni']) }}</b></td>
                    <td></td>
                </tr>
                <tr>
                    <td><b class="text-uppercase">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total
                            Pendapatan</b></td>
                    <td></td>
                    <td></td>
                    <td style="text-align: right"><b>{{ cek_uang($lap['totalPendapatan']) }}</b></td>
                </tr>
                <tr>
                    <td colspan="4"><b class="text-uppercase">VI. Biaya - biaya Januari s/d
                            {{ "$bulanini $tahun" }}</b>
                    </td>
                </tr>
                @isset($lap['biaya'])
                    @php
                        $no = 0;
                    @endphp
                    @foreach ($lap['biaya'] as $item)
                        @php
                            $no++;
                        @endphp
                        <tr>
                            <td>{{ "$no. $item->nama" }}</td>
                            <td style="text-align: right">{{ cek_uang($item->total_saldo) }}</td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endforeach
                @endisset
                <tr>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Jumlah Biaya</b></td>
                    <td></td>
                    <td></td>
                    <td style="text-align: right"><b>{{ cek_uang($lap['totalBiaya']) }}</b></td>
                </tr>
                <tr>
                    <td colspan="3"><b class="text-uppercase">VII. Sisa Hasil Usaha ( SHU ) Januari s/d
                            {{ "$bulanini $tahun" }}</b>
                    </td>
                    <td style="text-align: right"><b>{{ cek_uang($lap['shu']) }}</b></td>
                </tr>
            </table>
        </div>
    </div>
</div>
