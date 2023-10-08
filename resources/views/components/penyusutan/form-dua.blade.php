<form action="{{ route($route . '.store-dua') }}" method="post">
    @csrf
    <div class="card-body">
        <div class="card shadow-none bg-transparent border border-info mb-3">
            <div class="card-body">
                <h5 class="card-title mb-0">Step-2</h5>
                <div class="row mb-3">
                    <small class="text-info">Lihat inventaris yang akan disusutkan dan isi tanggal transaksi.</small>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <div class="col-lg-2">
                            <label for="tanggal-transaksi" class="text-bold">Tanggal Transaksi</label>
                        </div>
                        <div class="col-lg-4">
                            <input type="hidden" class="form-control" name="penyesuaian" value="{{ $penyesuaian }}">
                            <input type="date" class="form-control form-tanggal" name="tgl_transaksi"
                                placeholder="Masukkan Tanggal Transaksi Penyusutan.." />
                        </div>
                    </div>
                </div>
                <div class="row g-3">
                    @foreach ($inventaris as $i)
                        @php
                            if ($i['status'] == 'S') {
                                $harga_beli = getNilai($i['status'], $i['stok'], $i['harga'], $i['stok_e'], $i['harga_e']);
                                $nilai_saat_ini = getNilai($i['status'], $i['stok'], $i['nilai_buku'], $i['stok_e'], $i['nilai_buku_e']);
                            } else {
                                $harga_beli = getNilai($i['status'], $i['stok'], $i['harga']);
                                $nilai_saat_ini = getNilai($i['status'], $i['stok'], $i['nilai_buku']);
                            }
                            $ket = cekPenyusutan($i['tgl_beli'], $i['umur'], $harga_beli, $nilai_saat_ini);
                        @endphp
                        <input type="hidden" class="form-control" name="id_inventaris[]" value="{{ $i['id'] }}">
                        <input type="hidden" class="form-control"
                            name="data[{{ $i['id'] }}][id_inventaris]"value="{{ $i['id'] }}">
                        <input type="hidden" class="form-control"
                            name="data[{{ $i['id'] }}][keterangan]"value="{{ $ket }}">
                        <div class="col-md-6">
                            <table class="table table-borderless table-info small">
                                <tr>
                                    <td><b><label for="nama">Nama</label></b></td>
                                    <td><b><label for="nama">: {{ $i['nama'] }}</label></b></td>
                                </tr>
                                <tr>
                                    <td style="width:250px"><label for="kode">Kode</label></td>
                                    <td><label for="kode">: {{ $i['kode'] }}</label></td>
                                </tr>
                                <tr>
                                    <td><label for="jenis">Jenis</label></td>
                                    <td><label for="jenis">: {{ $i['jenis'] }}</label></td>
                                </tr>
                                <tr>
                                    <td><label for="unit">Unit</label></td>
                                    <td><label for="unit">: {{ $i['unit'] }}</label></td>
                                </tr>
                                <tr>
                                    <td><label for="unitinduk">Unit Induk</label></td>
                                    <td><label for="unitinduk">: {{ $i['unit_induk'] }}</label></td>
                                </tr>
                                <tr>
                                    <td><label for="tgl">Tanggal Beli</label></td>
                                    <td><label for="tgl">:
                                            {{ $i['tgl_beli'] ? date('d/m/Y', strtotime($i['tgl_beli'])) : '-' }}</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="stok">Jumlah</label></td>
                                    <td><label for="stok">: {{ formatAccounting($i['stok']) }}
                                            {{ $i['satuan'] }}</label>
                                    </td>
                                </tr>
                                @if ($i['status'] == 'S')
                                    <tr>
                                        <td><label for="stok_e">Jumlah (eceran)</label></td>
                                        <td><label for="stok_e">: {{ formatAccounting($i['stok_e']) }}
                                                {{ $i['satuan_e'] }}</label>
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td><label for="harga">Harga Beli / Satuan</label></td>
                                    <td><label for="harga">: {{ cek_uang($i['harga']) }}</label></td>
                                </tr>
                                @if ($i['status'] == 'S')
                                    <tr>
                                        <td><label for="harga_e">Harga Beli / Satuan (Eceran)</label>
                                        </td>
                                        <td><label for="harga_e">: {{ cek_uang($i['harga_e']) }}</label></td>
                                    </tr>
                                @endif
                                <tr>
                                    <td><label for="nilai_buku">Nilai Buku / Satuan</label></td>
                                    <td><label for="nilai_buku">: {{ cek_uang($i['nilai_buku']) }}</label></td>
                                </tr>
                                @if ($i['status'] == 'S')
                                    <tr>
                                        <td><label for="nilai_buku_e">Nilai Buku / Satuan (Eceran)</label></td>
                                        <td><label for="nilai_buku_e">: {{ cek_uang($i['nilai_buku_e']) }}</label>
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td><label for="umur">Umur Ekonomis</label></td>
                                    <td><label for="umur">:
                                            {{ $i['umur'] ? $i['umur'] . ' tahun' : '-' }}</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td><b><label for="keterangan">Keterangan</label></b></td>
                                    <td
                                        class="{{ $ket == 'Inventaris dapat disusutkan.' ? 'text-primary' : 'text-danger' }}">
                                        <b><label for="keterangan">: {{ $ket }}</b></label>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-12 d-flex justify-content-end">
                <a href="{{ route($route . '.step-satu') }}" type="button"
                    class="btn btn-outline-secondary">kembali</a>
                <button type="submit" class="btn btn-primary">Selanjutnya</button>
            </div>
        </div>
    </div>
</form>
