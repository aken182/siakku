<thead>
    <tr>
        <th>nama</th>
        <th>persen</th>
        <th>unit</th>
    </tr>
</thead>
<tbody>
    @foreach ($tabel as $t)
        <tr>
            <td>{{ $t->nama }}</td>
            <td>{{ $t->persen }}</td>
            <td>{{ $t->unit }}</td>
        </tr>
    @endforeach
</tbody>
