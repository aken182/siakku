<div class="row mb-3">
    <div class="col-md-3 col-sm-3 col-lg-3">
        <a type="button" class="btn btn-sm btn-outline-primary" href="{{ route($edit) }}">Ubah Saldo</a>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable">
        <thead class="table-primary">
            <tr>
                <th>Kode-Nama</th>
                <th>Jenis Barang</th>
                <th>Tanggal Input</th>
                <th>Jumlah Stok</th>
                <th>{{ $jenis == 'persediaan' ? 'Harga' : 'Nilai Buku' }}</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total = 0;
            @endphp
            @forelse ($transaksi as $data)
                <tr>
                    <td>{{ $data->barang->kode_barang }} - {{ $data->barang->nama_barang }}</td>
                    <td>{{ $data->barang->jenis_barang }}</td>
                    @php
                        try {
                            $date = Carbon::createFromFormat('Y-m-d', $data->transaksi->tgl_transaksi);
                        } catch (InvalidArgumentException $e) {
                            echo 'Error : ' . $e->getMessage();
                            return redirect()
                                ->route('error')
                                ->with('error', $e->getMessage());
                        }
                        $newDate = $date->addDays(1);
                        $formattedDate = $newDate->toDateString();
                    @endphp
                    <td>{{ tanggal_indonesia($formattedDate) }}</td>
                    <td style="text-align:right">{{ $data->qty . ' ' . $data->barang->satuan->nama_satuan }}
                    </td>
                    <td style="text-align:right">
                        {{ $jenis == 'persediaan' ? buatrp($data->harga) : buatrp($data->nilai_buku) }}</td>
                    <td style="text-align:right">{{ buatrp($data->subtotal) }}</td>
                    @php
                        $total += $data->subtotal;
                    @endphp
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center">Data kosong. </td>
                </tr>
            @endforelse
        </tbody>
        <tfoot class="table-primary">
            <tr>
                <th colspan="5">Total Saldo Awal</th>
                <th style="text-align:right">{{ buatrp($total) }}</th>
            </tr>
        </tfoot>
    </table>
</div>
