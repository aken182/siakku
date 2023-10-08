<form id="form-step-tiga" action="{{ route($route . '.store-tiga') }}" method="post">
    @csrf
    <div class="card-body">
        <div class="card shadow-none bg-transparent border border-info mb-3">
            <div class="card-body">
                <h5 class="card-title mb-0">Step-3</h5>
                <div class="row mb-3">
                    <small class="text-info">Lihat inventaris yang sudah disusutkan dan isi akun penyusutan.</small>
                </div>
                <div class="row mb-3">
                    <div class="col-md-2">
                        <label for="tgl_transaksi" class="form-label"><b>Tanggal Transaksi</b></label>
                    </div>
                    <div class="col-md-6">: <b>{{ $tanggal }}</b></div>
                    <input type="hidden" name="tgl_transaksi" value="{{ $tanggal }}" />
                    <input type="hidden" name="data_prev" value="{{ $dataprev }}" />
                </div>
                <div class="row g-3">
                    @foreach ($penyusutans as $i)
                        <div class="col-md-6">
                            <table class="table table-borderless table-info small">
                                <tr>
                                    <td colspan="2"><b><label for="detail_inventaris">Detil-
                                                {{ $i['nama'] }}</label></b>
                                    </td>
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
                                    <td><label for="harga">Harga Beli </label></td>
                                    <td><label for="harga">: {{ cek_uang($i['harga']) }}</label></td>
                                </tr>
                                @if ($i['status'] == 'S')
                                    <tr>
                                        <td><label for="harga_e">Harga Beli (Eceran)</label>
                                        </td>
                                        <td><label for="harga_e">: {{ cek_uang($i['harga_e']) }}</label></td>
                                    </tr>
                                @endif
                                <tr>
                                    <td><label for="nilai_buku">Nilai Buku Sebelum Penyusutan</label></td>
                                    <td><label for="nilai_buku">: {{ cek_uang($i['nilai_buku']) }}</label></td>
                                </tr>
                                @if ($i['status'] == 'S')
                                    <tr>
                                        <td><label for="nilai_buku_e">Nilai Buku Sebelum Penyusutan (Eceran)</label>
                                        </td>
                                        <td><label for="nilai_buku_e">: {{ cek_uang($i['nilai_buku_e']) }}</label>
                                        </td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless table-info small">
                                <tr>
                                    <td colspan="2"><b><label for="detail_penyusutan">Detil Penyusutan -
                                                {{ $i['nama'] }}</label></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="tgl">Tanggal Beli</label></td>
                                    <td><label for="tgl">:
                                            {{ $i['tgl_beli'] ? date('d/m/Y', strtotime($i['tgl_beli'])) : '-' }}</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="umur">Umur Ekonomis</label></td>
                                    <td><label for="umur">:
                                            {{ $i['umur'] ? $i['umur'] . ' tahun' : '-' }}</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="nilai_buku_sekarang">Nilai Buku Sekarang</label></td>
                                    <td><label for="nilai_buku_sekarang">:
                                            {{ cek_uang($i['nilai_buku_s']) }}</label>
                                    </td>
                                </tr>
                                @if ($i['status'] == 'S')
                                    <tr>
                                        <td><label for="nilai_buku_sekarang">Nilai Buku Sekarang (Eceran)</label></td>
                                        <td><label for="nilai_buku_sekarang">:
                                                {{ cek_uang($i['nilai_buku_se']) }}</label>
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td><label for="nilai_penyusutan"><b>Nilai Penyusutan</b></label></td>
                                    <td><label for="nilai_penyusutan"><b>:
                                                {{ cek_uang($i['nilai_penyusutan']) }}</b></label>
                                    </td>
                                </tr>
                                @if ($i['status'] == 'S')
                                    <tr>
                                        <td><label for="nilai_penyusutan"><b>Nilai Penyusutan (Eceran)</b></label></td>
                                        <td><label for="nilai_penyusutan"><b>:
                                                    {{ cek_uang($i['nilai_penyusutan_e']) }}</b></label>
                                        </td>
                                    </tr>
                                @endif
                                @if ($i['total_penyusutan'] > 0)
                                    <tr>
                                        <td colspan="2"><label for="akun">Akun Penyusutan
                                                {{ $i['jenis'] }}</label></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <select type="text" class="form-select choices"
                                                name="data[{{ $i['id'] }}][id_kredit_penyusutan]"
                                                data-placeholder="Pilih Akun Penyusutan {{ $i['jenis'] }}.."
                                                data-allow-clear="true" id="idKredit{{ $i['id'] }}">
                                                <option value="">Pilih Akun Penyusutan {{ $i['jenis'] }}..
                                                </option>
                                                @foreach ($coas as $coa)
                                                    <option value="{{ $coa->id_coa }}">{{ $coa->kode }} |
                                                        {{ $coa->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="text-danger"><small
                                                id="errorPenyusutan{{ $i['id'] }}"></small>
                                        </td>
                                    </tr>
                                    <input type="hidden" name="data[{{ $i['id'] }}][id_inventaris]"
                                        value="{{ $i['id'] }}" />
                                @else
                                    <tr>
                                        <td><label for="akun">Keterangan</label></td>
                                        <td><label for="akun"><b class="text-danger">: Inventaris tidak
                                                    dapat disusutkan !</b></label></td>
                                    </tr>
                                @endif
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
                <a href="{{ route($route . '.step-dua', [
                    'id_inventaris' => json_encode($inventaris),
                    'penyesuaian' => $penyesuaian,
                ]) }}"
                    type="button" class="btn btn-outline-secondary">kembali</a>
                <button type="submit" class="btn btn-primary">Selanjutnya</button>
            </div>
        </div>
    </div>
</form>
