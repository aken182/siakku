<thead>
    <tr>
        <td>Nama</td>
        <td>Jabatan</td>
        <td>Status</td>
    </tr>
</thead>
<tbody>
    @foreach ($tabel as $t)
        <tr>
            <td>{{ $t->anggota->nama }}</td>
            <td>{{ $t->jabatan }}</td>
            <td>{{ $t->status }}</td>
        </tr>
    @endforeach
</tbody>
