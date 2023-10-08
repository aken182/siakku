<div class="row mb-3">
    <div class="col-12 col-md-6">
        <label class="form-label text-primary"> Pengajuan Pinjaman Anggota</label>
        <select name="id_pengajuan" id="id-pengajuan"
            class="form-select choices select-pengajuan @error('id_pengajuan') is-invalid @enderror">
            <option value="" selected>Pilih Kode Pengajuan - Nama Anggota - Total Pinjaman
            </option>
            @foreach ($pengajuan as $p)
                <option value="{{ $p->id_pengajuan }}">
                    {{ $p->kode . ' - ' . $p->anggota->nama . ' - ' . buatrp($p->jumlah_pinjaman) }}
                </option>
            @endforeach
        </select>
        @error('id_pengajuan')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
<div class="row mb-3 detail-pengajuan">
    <div class="col-12 col-md-7">
        <input type="hidden" id="route-pengajuan" data-route="{{ route($route) }}" />
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-primary">
                <tr>
                    <td>Kode Pengajuan</td>
                    <td>
                        <div id="kode-pengajuan" style="text-align: right"></div>
                    </td>
                </tr>
                <tr>
                    <td>Nama Anggota</td>
                    <td>
                        <div id="nama-anggota" style="text-align: right"></div>
                    </td>
                </tr>
                <tr>
                    <td>Tempat Tugas</td>
                    <td>
                        <div id="tempat-tugas" style="text-align: right"></div>
                    </td>
                </tr>
                <tr>
                    <td>Jumlah Pinjaman</td>
                    <td>
                        <div id="jumlah-pengajuan" style="text-align: right"></div>
                    </td>
                </tr>
                <tr>
                    <td>Jangka Waktu</td>
                    <td>
                        <div id="jangka-waktu" style="text-align: right"></div>
                    </td>
                </tr>
                <tr>
                    <td>Bunga Pinjaman</td>
                    <td>
                        <div id="bunga" style="text-align: right"></div>
                    </td>
                </tr>
                <tr>
                    <td>Asuransi</td>
                    <td>
                        <div id="asuransi" style="text-align: right"></div>
                    </td>
                </tr>
                <tr>
                    <td>Kapitalisasi</td>
                    <td>
                        <div id="kapitalisasi" style="text-align: right"></div>
                    </td>
                </tr>
                <tr>
                    <td>Pinjaman yang Diterima</td>
                    <td>
                        <div id="total-penerimaan" style="text-align: right"></div>
                    </td>
                </tr>
                <tr>
                    <td>Total Angsuran/bulan</td>
                    <td>
                        <div id="total-angsuran" style="text-align: right"></div>
                    </td>
                </tr>
                <tr>
                    <td>Angsuran Pokok/bulan</td>
                    <td>
                        <div id="angsuran-pokok" style="text-align: right"></div>
                    </td>
                </tr>
                <tr>
                    <td>Angsuran Bunga/bulan</td>
                    <td>
                        <div id="angsuran-bunga" style="text-align: right"></div>
                    </td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>
                        <div id="status-pencairan" style="text-align: right" class="text-capitalize"></div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
