<thead>
    <tr>
        <th>tanggal_mulai</th>
        <th>kode_unit</th>
        <th>nama_barang</th>
        <th>jenis_barang</th>
        <th>nama_unit</th>
        <th>satuan</th>
        <th>stok</th>
        <th>harga_barang</th>
        @if ($jenis === 'saldo awal inventaris')
            <th>tgl_beli</th>
            <th>nilai_saat_ini</th>
            <th>umur_ekonomis</th>
        @endif
    </tr>
</thead>
<tbody>
    @foreach ($tabel as $t)
        <tr>
            <td>{{ $t->transaksi->tgl_transaksi }}</td>
            <td>{{ $t->barang->unit->kode_unit }}</td>
            <td>{{ $t->barang->nama_barang }}</td>
            <td>{{ $t->barang->jenis_barang }}</td>
            <td>{{ $t->barang->unit->nama }}</td>
            <td>{{ $t->barang->satuan->nama_satuan }}</td>
            <td>{{ $t->barang->stok }}</td>
            <td>{{ $t->barang->harga_barang }}</td>
            @if ($jenis === 'saldo awal inventaris')
                <td>{{ $t->barang->tgl_beli }}</td>
                <td>{{ $t->barang->nilai_saat_ini }}</td>
                <td>{{ $t->barang->umur_ekonomis }}</td>
            @endif
        </tr>
    @endforeach
</tbody>
