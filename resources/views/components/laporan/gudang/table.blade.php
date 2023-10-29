<div class="table-responsive">
    <input type="hidden" id="route-gudang-{{ $tpk }}" data-route="{{ route($route, ['tpk' => $tpk]) }}" />
    <table class="table table-bordered table-hover" id="gudang-table-{{ $tpk }}">
        <thead class="table-success">
            <tr>
                <th rowspan="2" style="text-align: center">NO.</th>
                <th rowspan="2" style="text-align: center">NAMA BARANG</th>
                <th rowspan="2" style="text-align: center">JENIS BARANG</th>
                <th colspan="2" style="text-align: center">STOK</th>
                <th rowspan="2" style="text-align: center">JUMLAH</th>
            </tr>
            <tr>
                <th style="text-align: center">AKHIR</th>
                <th style="text-align: center">HB. SATUAN</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
