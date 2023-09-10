    <thead>
        <tr class="text-nowrap">
            <th>tanggal_mulai</th>
            <th>kode</th>
            <th>nama</th>
            <th>kategori</th>
            <th>subkategori</th>
            <th>header</th>
            <th>debet</th>
            <th>kredit</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tabel as $data)
            <tr>
                <td>{{ $data->transaksi->tgl_transaksi }}</td>
                <td>{{ $data->coa->kode }}</td>
                <td>{{ $data->coa->nama }}</td>
                <td>{{ $data->coa->kategori }}</td>
                <td>{{ $data->coa->subkategori }}</td>
                <td>{{ $data->coa->header }}</td>
                @if ($data->posisi_dr_cr == 'debet')
                    <td style="text-align:right">{{ $data->saldo }}</td>
                    <td style="text-align:right">{{ 0 }}</td>
                @elseif($data->posisi_dr_cr == 'kredit')
                    <td style="text-align:right">{{ 0 }}</td>
                    <td style="text-align:right">{{ $data->saldo }}</td>
                @endif
            </tr>
        @endforeach
    </tbody>
