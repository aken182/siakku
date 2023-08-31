<thead>
    <tr>
        <th>nama</th>
        <th>alamat</th>
        <th>no_tlp</th>
    </tr>
</thead>
<tbody>
    @foreach ($tabel as $t)
        <tr>
            <td>{{ $t->nama }}</td>
            <td>{{ $t->alamat }}</td>
            <td>{{ $t->no_tlp }}</td>
        </tr>
    @endforeach
</tbody>
