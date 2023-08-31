    <thead>
        <tr>
            <th>kode_unit</th>
            <th>nama_barang</th>
            <th>jenis_barang</th>
            <th>nama_unit</th>
            <th>unit</th>
            <th>satuan</th>
            @if ($jenis === 'inventaris')
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
                @if ($jenis === 'inventaris')
                    <td>{{ $t->umur_ekonomis }}</td>
                @endif
            </tr>
        @endforeach
    </tbody>
