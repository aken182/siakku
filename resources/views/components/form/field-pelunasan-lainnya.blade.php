<div class="row">
    <div class="col mb-3">
        <label for="jumlah_bayar" class="text-primary">Jumlah Pembayaran</label>
        <input type="text" class="form-control format-rupiah @error('jumlah_bayar') is-invalid @enderror"
            id="jumlah_bayar" name="jumlah_bayar" placeholder="Masukkan jumlah pembayaran !">
        @error('jumlah_bayar')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
<div class="row">
    <div class="col mb-3">
        <label for="saldo_tagihan" class="text-primary">Sisa Tagihan</label>
        <input type="text" class="form-control @error('saldo_tagihan') is-invalid @enderror" id="sisa_tagihan"
            name="saldo_tagihan" readonly>
        @error('saldo_tagihan')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
