<thead>
    <tr>
        <th>kode</th>
        <th>nama</th>
        <th>kategori</th>
        <th>subkategori</th>
        <th>header</th>
    </tr>
</thead>
<tbody>
    @foreach ($tabel as $t)
        <tr>
            <td>{{ $t->kode }}</td>
            <td>{{ $t->nama }}</td>
            <td>{{ $t->kategori }}</td>
            <td>{{ $t->subkategori }}</td>
            <td>{{ $t->header }}</td>
        </tr>
    @endforeach
</tbody>
