<div class="row mb-3">
    <div class="col-md-3 col-sm-3 col-lg-3">
        <a type="button" class="btn btn-sm btn-outline-primary" href="{{ route($edit) }}">Ubah Saldo</a>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable">
        <thead class="table-primary">
            <tr>
                <th>Akun</th>
                <th>Kategori</th>
                <th>Tanggal Mulai</th>
                <th>Debet</th>
                <th>Kredit</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total_debet = 0;
                $total_kredit = 0;
            @endphp
            @forelse ($transaksi as $data)
                <tr>
                    <td>{{ $data->coa->kode }} - {{ $data->coa->nama }}</td>
                    <td>{{ $data->coa->kategori }}</td>
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
                    @if ($data->posisi_dr_cr == 'debet')
                        <td style="text-align:right">{{ buatrp($data->saldo) }}</td>
                        <td style="text-align:right">{{ buatrp(0) }}</td>
                        @php
                            $total_debet = $total_debet + $data->saldo;
                        @endphp
                    @elseif($data->posisi_dr_cr == 'kredit')
                        <td style="text-align:right">{{ buatrp(0) }}</td>
                        <td style="text-align:right">{{ buatrp($data->saldo) }}</td>
                        @php
                            $total_kredit = $total_kredit + $data->saldo;
                        @endphp
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center">Data kosong. </td>
                </tr>
            @endforelse
        </tbody>
        <tfoot class="table-primary">
            <tr>
                <th colspan="3">Total Saldo Awal</th>
                <th style="text-align:right">{{ buatrp($total_debet) }}</th>
                <th style="text-align:right">{{ buatrp($total_kredit) }}</th>
            </tr>
        </tfoot>
    </table>
</div>
