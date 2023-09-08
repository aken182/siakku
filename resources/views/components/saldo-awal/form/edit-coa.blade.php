<form action="{{ route($store, $idtransaksi) }}" method="post">
    @csrf
    @method('PATCH')
    <div class="row">
        <div class="col-md-6 col-12">
            <div class="form-group">
                <label for="tgl_transaksi" class="text-primary">Konfirmasi Saldo Akun Per Tanggal</label>
                <input type="date" name="tgl_transaksi"
                    class="form-control @error('tgl_transaksi') is-invalid @enderror" value="{{ $tanggal }}"
                    readonly>
                @error('tgl_transaksi')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mb-3">
            <small class="text-primary">Dibawah ini adalah pengelompokan akun berdasarkan
                kategori.</small>
        </div>
        <div class="col-12">
            @php
                $id = 0;
            @endphp
            @foreach ($menuData[1]->kategori as $k)
                @php
                    $id = $id + 1;
                @endphp
                <div class="accordion card bg-light-primary">
                    <div class="card-header bg-light-primary">
                        <div id="heading{{ $id }}" data-bs-toggle="collapse"
                            data-bs-target="#collapse{{ $id }}" aria-expanded="false"
                            aria-controls="collapse{{ $id }}" role="button">
                            <span class="collapsed collapse-title">{{ $k->nama }}</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="collapse{{ $id }}" class="collapse pt-1"
                            aria-labelledby="heading{{ $id }}">
                            <div class="row mt-2">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr class="text-nowrap">
                                                    <th>Akun</th>
                                                    <th>Debet</th>
                                                    <th>Kredit</th>
                                                </tr>
                                            </thead>
                                            @foreach ($coa as $data)
                                                @if ($data['kategori'] == $k->nama)
                                                    <tbody>
                                                        <input type="hidden" class="form-control"
                                                            name="id_coa{{ $data['id_coa'] }}"
                                                            value="{{ $data['id_coa'] }}" readonly>
                                                        <input type="hidden" class="form-control"
                                                            name="header{{ $data['id_coa'] }}"
                                                            value="{{ $data['header'] }}" readonly>
                                                        <tr>
                                                            <td>{{ $data['kode'] }} - {{ $data['nama'] }}</td>
                                                            <td>
                                                                <input style="text-align: right" type="text"
                                                                    class="form-control format-rupiah"
                                                                    name="saldo_debet{{ $data['id_coa'] }}"
                                                                    id="saldo_debet{{ $data['id_coa'] }}"
                                                                    value="{{ buatrp($data['saldo_debet']) }}"
                                                                    onKeyUp="hitungTotalSaldo()">
                                                            </td>
                                                            <td>
                                                                <input type="text" style="text-align: right"
                                                                    class="form-control format-rupiah"
                                                                    name="saldo_kredit{{ $data['id_coa'] }}"
                                                                    id="saldo_kredit{{ $data['id_coa'] }}"
                                                                    value="{{ buatrp($data['saldo_kredit']) }}"
                                                                    onKeyUp="hitungTotalSaldo()">
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                @endif
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="table table-bordered">
                <tr class="table-primary">
                    <td>Keterangan</td>
                    <td>Debet</td>
                    <td>Kredit</td>
                </tr>
                <tr>
                    <td>Total Saldo Awal</td>
                    <td style="text-align:right" id="total_debet">{{ buatrp($debet) }}</td>
                    <td style="text-align:right" id="total_kredit">{{ buatrp($kredit) }}</td>
                </tr>
            </table>
            <input type="hidden" class="form-control" id="input_total_debet" name="total_debet"
                value="{{ $debet }}" readonly>
            <input type="hidden" class="form-control" id="input_total_kredit" name="total_kredit"
                value="{{ $kredit }}" readonly>
        </div>
    </div>
    <div class="row">
        <div class="col-12 d-flex justify-content-end">
            <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
            <a type="button" href="{{ route($main) }}" class="btn btn-light-secondary me-1 mb-1">Kembali</a>
        </div>
    </div>
</form>
@section('pageScript')
    <script>
        var coa = @json($coa);
    </script>
    <script src="{{ asset('assets/admin') }}/js/siakku-custom/saldo-awal-coa.js"></script>
@endsection
