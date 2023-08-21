<table class="table table-hover">
    <tr>
        <td>Koperasi</td>
        <td> : {{ $profil->nama }}</td>
    </tr>
    <tr>
        <td>Nomor Badan Hukum Pendirian</td>
        <td> : {{ $profil->badan_hukum }}</td>
    </tr>
    <tr>
        <td>Tanggal Badan Hukum Pendirian</td>
        <td> : {{ date('d/m/Y', strtotime($profil->tgl_badan_hukum)) }}</td>
    </tr>
    <tr>
        <td>Nomor Perubahan Anggaran Dasar (Terbaru)</td>
        <td> : {{ $profil->nmr_pad }}</td>
    </tr>
    <tr>
        <td>Tanggal Perubahan Anggaran Dasar (Terbaru)</td>
        @if (isset($profil->tgl_pad))
            <td> : {{ date('d/m/Y', strtotime($profil->tgl_pad)) }}</td>
        @else
            <td> : -</td>
        @endif
    </tr>
    <tr>
        <td>Tanggal RAT Terakhir</td>
        <td> : {{ date('d/m/Y', strtotime($profil->tgl_rat)) }}</td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td> : {{ $profil->alamat }}</td>
    </tr>
    <tr>
        <td>Kelurahan/Desa</td>
        <td> : {{ $profil->kelurahan }}</td>
    </tr>
    <tr>
        <td>Kecamatan</td>
        <td> : {{ $profil->kecamatan }}</td>
    </tr>
    <tr>
        <td>Kabupaten</td>
        <td> : {{ $profil->kabupaten }}</td>
    </tr>
    <tr>
        <td>Provinsi</td>
        <td> : {{ $profil->provinsi }}</td>
    </tr>
    <tr>
        <td>Bentuk Koperasi</td>
        <td> : {{ $profil->bentuk_koperasi }}</td>
    </tr>
    <tr>
        <td>Jenis Koperasi</td>
        <td> : {{ $profil->jenis }}</td>
    </tr>
    <tr>
        <td>Kelompok Koperasi</td>
        <td> : {{ $profil->kelompok_koperasi }}</td>
    </tr>
    <tr>
        <td>Sektor Usaha</td>
        <td> : {{ $profil->sektor }}</td>
    </tr>
    <tr>
        <td>Nomor Induk Koperasi (NIK)</td>
        <td> : {{ $profil->nik }}</td>
    </tr>
    <tr>
        <td>Status NIK</td>
        <td> : {{ $profil->status_nik }}</td>
    </tr>
    <tr>
        <td>Status Grade</td>
        <td> : {{ $profil->status_grade }}</td>
    </tr>
</table>
