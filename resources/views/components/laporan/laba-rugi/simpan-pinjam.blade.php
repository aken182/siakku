<div class="row">
    <div class="col-md-12 col-sm-12 col-lg-12">
        <div class="table-responsive">
            <table class="table table-hover">
                <tr>
                    <td colspan="4"><b>I. PENDAPATAN</b></td>
                </tr>
                <tr>
                    <td colspan="4">Pendapatan Bunga</td>
                </tr>
                @isset($lap['pendapatanBungaBulanSebelum'])
                    <tr>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;Bulan Januari s/d {{ "$bulanlalu $tahun" }}</td>
                        <td style="text-align: right">{{ cek_uang($lap['pendapatanBungaBulanSebelum']) }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                @endisset
                <tr>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;Bulan {{ "$bulanini $tahun" }}</td>
                    <td style="text-align: right">{{ cek_uang($lap['pendapatanBungaBulanIni']) }}</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Jumlah Pendapatan Bunga</b></td>
                    <td></td>
                    <td style="text-align: right"><b>{{ cek_uang($lap['jumlahPendapatanBunga']) }}</b></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Pendapatan Lain - Lain ( Januari s/d {{ "$bulanini $tahun" }})</td>
                    <td></td>
                    <td style="text-align: right">{{ cek_uang($lap['pendapatanLainnya']) }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td><b class="text-uppercase">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jumlah
                            Pendapatan</b></td>
                    <td></td>
                    <td></td>
                    <td style="text-align: right"><b>{{ cek_uang($lap['totalPendapatan']) }}</b></td>
                </tr>
                <tr>
                    <td colspan="4"><b class="text-uppercase">II. Biaya - biaya Januari s/d
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
                    <td colspan="3"><b class="text-uppercase">III. Sisa Hasil Usaha ( SHU ) Januari s/d
                            {{ "$bulanini $tahun" }}</b>
                    </td>
                    <td style="text-align: right"><b>{{ cek_uang($lap['shu']) }}</b></td>
                </tr>
            </table>
        </div>
    </div>
</div>
