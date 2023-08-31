<thead>
    <tr>
        <th>judul_berita</th>
        <th>isi_berita</th>
        <th>penulis</th>
        <th>gambar_berita</th>
        <th>tgl_berita</th>
    </tr>
</thead>
<tbody>
    @foreach ($tabel as $b)
        <tr>
            <td>{{ $b->judul_berita }}</td>
            <td>{{ $b->isi_berita }}</td>
            <td>{{ $b->penulis }}</td>
            <td>{{ $b->gambar_berita }}</td>
            <td>{{ $b->tgl_berita }}</td>
        </tr>
    @endforeach
</tbody>
