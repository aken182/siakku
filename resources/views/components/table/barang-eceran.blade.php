<thead>
    <tr>
        <th>Kode</th>
        <th>Nama</th>
        <th>Jenis</th>
        <th>TPK</th>
        <th>Kuantitas</th>
        <th>Harga Satuan</th>
        @if ($jenis === 'inventaris eceran')
            <th>Nilai Buku</th>
            <th>Umur Ekonomis</th>
        @endif
        <th>Harga Jual/Satuan</th>
    </tr>
</thead>
<tbody>
    @forelse ($tabel as $a)
        <tr>
            <td>{{ $a->barang->kode_barang }}</td>
            <td>{{ $a->barang->nama_barang }}</td>
            <td>{{ $a->barang->jenis_barang }}</td>
            <td>{{ $a->barang->unit->nama }}</td>
            <td>{{ $a->stok . ' ' . $a->satuan->nama_satuan }}</td>
            <td>{{ cek_uang($a->harga_barang) . '/' . $a->satuan->nama_satuan }}</td>
            @if ($jenis === 'inventaris eceran')
                <td>{{ cek_uang($a->nilai_saat_ini) . '/' . $a->satuan->nama_satuan }}</td>
                <td>{{ $a->barang->umur_ekonomis }} tahun</td>
            @endif
            <td>{{ cek_uang($a->harga_jual) . '/' . $a->satuan->nama_satuan }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="{{ $jenis === 'inventaris eceran' ? '9' : '7' }}" style="text-align: center">
                Data Kosong.
            </td>
        </tr>
    @endforelse
</tbody>
