<thead>
    <tr>
        <td>no_induk</td>
        <td>nama</td>
        <td>tempat_lahir</td>
        <td>tgl_lahir</td>
        <td>jenis_kelamin</td>
        <td>pekerjaan</td>
        <td>tempat_tugas</td>
        <td>status</td>
        <td>level</td>
        <td>tgl_masuk</td>
        <td>tgl_berhenti</td>
        <td>alasan_berhenti</td>
    </tr>
</thead>
<tbody>
    @foreach ($tabel as $t)
        <tr>
            <td>{{ $t->no_induk }}</td>
            <td>{{ $t->nama }}</td>
            <td>{{ $t->tempat_lahir }}</td>
            <td>{{ $t->tgl_lahir }}</td>
            <td>{{ $t->jenis_kelamin }}</td>
            <td>{{ $t->pekerjaan }}</td>
            <td>{{ $t->tempat_tugas }}</td>
            <td>{{ $t->status }}</td>
            <td>{{ $t->level }}</td>
            <td>{{ $t->tgl_masuk }}</td>
            <td>{{ $t->tgl_berhenti }}</td>
        </tr>
    @endforeach
</tbody>
