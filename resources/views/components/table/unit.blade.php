<thead>
    <tr>
        <th>nama</th>
        <th>unit</th>
        <th>kode_unit</th>
    </tr>
</thead>
<tbody>
    @foreach ($tabel as $template)
        <tr>
            <td>{{ $template->nama }}</td>
            <td>{{ $template->unit }}</td>
            <td>{{ $template->kode_unit }}</td>
        </tr>
    @endforeach
</tbody>
