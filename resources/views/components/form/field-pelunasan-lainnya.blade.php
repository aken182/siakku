@if ($jenis === 'Pembayaran Piutang Penjualan')
    <div class="row">
        <div class="col mb-3">
            <label for="pot_bendahara" class="text-primary">Potongan dari Bendahara</label>
            <input type="text" class="form-control format-rupiah @error('pot_bendahara') is-invalid @enderror"
                name="pot_bendahara" id="pot-bendahara" placeholder="Masukkan potongan dari bendahara !">
            @error('pot_bendahara')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
@endif
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
@if ($jenis === 'Pembayaran Piutang Penjualan')
    <div class="row">
        <div class="col mb-3">
            <label for="tpk" class="text-primary">TPK Pembayaran</label>
            <select name="tpk" class="form-select choices @error('tpk') is-invalid @enderror">
                <option value="">Pilih TPK</option>
                <option value="Larantuka">Larantuka</option>
                <option value="Pasar Baru">Pasar Baru</option>
                <option value="Waiwerang">Waiwerang</option>
            </select>
            @error('tpk')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
@endif
