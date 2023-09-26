<div class="row mb-3">
    <div class="col">
        <label for="persen_bunga" class="text-primary">Persentase Bunga</label>
        <div class="col-5">
            <div class="input-group">
                <input type="number" step="0.05" class="form-control" id="persen-bunga" value="0.6">
                <input type="text" class="form-control" value="%" readonly>
            </div>
        </div>
    </div>
</div>
<div class="row mb-3">
    <div class="col">
        <label class="form-label text-primary">Jenis Penarikan</label>
        <div class="row">
            <div class="col-md-4">
                <div class="form-check mt-3">
                    <label class="form-check-label" for="penarikan-pokok">
                        Penarikan Pokok
                    </label>
                    <input class="form-check-input @error('cek_penarikan_simpanan') is-invalid @enderror"
                        name="cek_penarikan_simpanan" type="radio" value="penarikan pokok" id="penarikan-pokok" />
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-check mt-3">
                    <label class="form-check-label" for="penarikan-bunga">
                        Penarikan Bunga
                    </label>
                    <input class="form-check-input @error('cek_penarikan_simpanan') is-invalid @enderror"
                        name="cek_penarikan_simpanan" type="radio" value="penarikan bunga" id="penarikan-bunga" />
                    @error('cek_penarikan_simpanan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mb-3 bungas-field">
    <div class="col">
        <label for="bunga" class="text-primary">Bunga/bulan</label>
        <input type="text" class="form-control" id="bunga-sebelum" readonly>
    </div>
</div>
<div class="row mb-3 saldos-field">
    <div class="col">
        <label class="text-primary">Saldo Simpanan</label>
        <input type="text" id="saldo-sebelum" class="form-control" readonly>
    </div>
</div>
<div class="row mb-3">
    <div class="col">
        <label for="total_transaksi" class="form-label  text-primary">Jumlah
            Penarikan</label>
        <input type="text" name="total_transaksi" id="total-transaksi"
            class="form-control format-rupiah @error('total_transaksi') is-invalid @enderror"
            placeholder="Masukkan jumlah penarikan simpanan.">
        @error('total_transaksi')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>

<div class="row mb-3">
    <div class="col">
        <label for="bunga" class="text-primary">Bunga/bulan Sekarang</label>
        <input type="text" class="form-control @error('bunga') is-invalid @enderror" name="bunga" id="bunga"
            readonly>
        @error('bunga')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>

<div class="row mb-3">
    <div class="col">
        <label for="saldo_simpanan" class="text-primary">Sisa Saldo Simpanan</label>
        <input type="text" class="form-control @error('saldo_simpanan') is-invalid @enderror" name="saldo_simpanan"
            id="saldo-simpanan" readonly>
        @error('saldo_simpanan')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
