    <thead>
        <tr>
            <th>kode_unit</th>
            <th>nama_barang</th>
            <th>jenis_barang</th>
            <th>nama_unit</th>
            <th>unit</th>
            <th>satuan</th>
            <th>harga_barang</th>
            @if ($jenis === 'inventaris')
                <th>tgl_beli</th>
                <th>nilai_saat_ini</th>
                <th>umur_ekonomis</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach ($tabel as $t)
            <tr>
                <td>{{ $t->unit->kode_unit }}</td>
                <td>{{ $t->nama_barang }}</td>
                <td>{{ $t->jenis_barang }}</td>
                <td>{{ $t->unit->nama }}</td>
                <td>{{ $t->unit->unit }}</td>
                <td>{{ $t->satuan->nama_satuan }}</td>
                <td>{{ $t->harga_barang }}</td>
                @if ($jenis === 'inventaris')
                    <td>{{ $t->tgl_beli }}</td>
                    <td>{{ $t->nilai_saat_ini }}</td>
                    <td>{{ $t->umur_ekonomis }}</td>
                @endif
            </tr>
        @endforeach
    </tbody>
