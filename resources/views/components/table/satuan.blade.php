<thead>
    <tr>
        <th>nama_satuan</th>
    </tr>
</thead>
<tbody>
    @foreach ($tabel as $template)
        <tr>
            <td>{{ $template->nama_satuan }}</td>
        </tr>
    @endforeach
</tbody>
