<div class="row">
    <div class="col mb-3">
        <label for="id_pinjaman" class="text-primary">Tagihan Pinjaman</label>
        <select class="selectpicker w-100 @error('id_pinjaman') is-invalid @enderror" name="id_pinjaman" id="id_pinjaman"
            data-style="btn-outline-secondary" data-live-search="true">
            <option value="">Masukan Tagihan Pinjaman atau Nama Anggota!</option>
            @foreach ($tagihan as $t)
                <option value="{{ $t->id_pinjaman }}">{{ $t->transaksi->kode . ' - ' . $t->anggota->nama }}</option>
            @endforeach
        </select>
        @error('id_pinjaman')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
<div class="row info-pinjaman">
    <div class="col-12 mb-3">
        <table class="table table-condensed text-primary" style="font-width:bold">
            <tbody>
                <tr>
                    <td><small>Nomor Tagihan</small></td>
                    <td><small>: </small><small id="kode-pinjaman"></small></td>
                </tr>
                <tr>
                    <td><small>No. Bukti</small></td>
                    <td><small>: </small><small id="no-bukti-pinjaman"></small></td>
                </tr>
                <tr>
                    <td><small>Tanggal Peminjaman</small></td>
                    <td><small>: </small><small id="tanggal-pinjam"></small></td>
                </tr>
                <tr>
                    <td><small>Nama Anggota</small></td>
                    <td><small>: </small><small id="nama-anggota"></small></td>
                </tr>
                <tr>
                    <td><small>Status</small></td>
                    <td><small>: </small><small id="status-peminjaman" class="text-capitalize"></small></td>
                </tr>
                <tr>
                    <td><small>Saldo Pokok</small></td>
                    <td><small>: </small><small id="saldo-pokok"></small></td>
                </tr>
                <tr>
                    <td><small>Saldo Bunga</small></td>
                    <td><small>: </small><small id="saldo-bunga"></small></td>
                </tr>
                <tr>
                    <td><small>Total Pinjaman</small></td>
                    <td><small>: </small><small id="total-tagihan"></small></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="row mb-3">
    <div class="col">
        <label for="" class="text-primary">Angsuran Pokok</label>
        <input type="text" name="angsuran_pokok"
            class="form-control format-rupiah @error('angsuran_pokok') is-invalid @enderror" id="angsuran-pokok"
            placeholder="Masukkan Angsuran Pokok !">
        @error('angsuran_pokok')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
<div class="row mb-3">
    <div class="col">
        <label for="" class="text-primary">Angsuran Bunga</label>
        <input type="text" name="angsuran_bunga"
            class="form-control format-rupiah @error('angsuran_bunga') is-invalid @enderror" id="angsuran-bunga"
            placeholder="Masukkan Angsuran Bunga !">
        @error('angsuran_bunga')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
<div class="row mb-3">
    <div class="col">
        <label for="" class="text-primary">Total Angsuran</label>
        <input type="text" name="total_transaksi" class="form-control @error('total_transaksi') is-invalid @enderror"
            id="total-angsuran" readonly>
        @error('total_transaksi')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
