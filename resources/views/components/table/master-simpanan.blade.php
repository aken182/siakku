<thead>
    <tr>
        <th>nama</th>
        <th>jumlah</th>
    </tr>
</thead>
<tbody>
    @foreach ($tabel as $t)
        <tr>
            <td>{{ $t->nama }}</td>
            <td>{{ $t->jumlah }}</td>
        </tr>
    @endforeach
</tbody>
