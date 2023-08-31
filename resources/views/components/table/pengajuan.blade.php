<thead>
    <tr>
        <th>kode_anggota</th>
        <th>nama_anggota</th>
        <th>gaji_perbulan</th>
        <th>potongan_perbulan</th>
        <th>cicilan_perbulan</th>
        <th>biaya_perbulan</th>
        <th>sisa_penghasilan</th>
        <th>perkiraan</th>
        <th>kemampuan_bayar</th>
        <th>jumlah_pinjaman</th>
        <th>jangka_waktu</th>
        <th>bunga</th>
        <th>asuransi</th>
        <th>kapitalisasi</th>
        <th>biaya_administrasi</th>
        <th>angsuran_bunga</th>
        <th>angsuran_pokok</th>
        <th>total_angsuran</th>
        <th>total_pinjaman</th>
        <th>keterangan</th>
        <th>status</th>
        <th>tgl_acc</th>
        <th>status_pencairan</th>
    </tr>
</thead>
<tbody>
    @foreach ($tabel as $t)
        <tr>
            <td>{{ $t->anggota->kode }}</td>
            <td>{{ $t->anggota->nama }}</td>
            <td>{{ $t->gaji_perbulan }}</td>
            <td>{{ $t->potongan_perbulan }}</td>
            <td>{{ $t->cicilan_perbulan }}</td>
            <td>{{ $t->biaya_perbulan }}</td>
            <td>{{ $t->sisa_penghasilan }}</td>
            <td>{{ $t->perkiraan }}</td>
            <td>{{ $t->kemampuan_bayar }}</td>
            <td>{{ $t->jumlah_pinjaman }}</td>
            <td>{{ $t->jangka_waktu }}</td>
            <td>{{ $t->bunga }}</td>
            <td>{{ $t->asuransi }}</td>
            <td>{{ $t->kapitalisasi }}</td>
            <td>{{ $t->biaya_administrasi }}</td>
            <td>{{ $t->angsuran_bunga }}</td>
            <td>{{ $t->angsuran_pokok }}</td>
            <td>{{ $t->total_angsuran }}</td>
            <td>{{ $t->total_pinjaman }}</td>
            <td>{{ $t->keterangan }}</td>
            <td>{{ $t->status }}</td>
            <td>{{ $t->tgl_acc }}</td>
            <td>{{ $t->status_pencairan }}</td>
        </tr>
    @endforeach
</tbody>
