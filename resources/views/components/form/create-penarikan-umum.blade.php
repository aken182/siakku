<div class="row mb-3">
    <div class="col">
        <label for="simpanan" class="text-primary">Jenis Penarikan
            Simpanan</label>
        <select name="nama_simpanan" class="form-select @error('nama_simpanan') is-invalid @enderror" id="nama-simpanan">
            <option value="">Pilih Simpanan</option>
            @if ($unit === 'Simpan Pinjam')
                @foreach ($simpanan as $s)
                    <option value="{{ $s->nama }}">{{ $s->nama }}
                    </option>
                @endforeach
            @else
                <option value="Simpanan Khusus Pertokoan">Simpanan Khusus
                    Pertokoan
                </option>
            @endif
        </select>
        @error('nama_simpanan')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
<div class="row mb-3" id="saldo-field">
    <div class="col">
        <label id="saldo-title" class="text-primary"></label>
        <input type="text" name="saldo_simpanan" id="saldo-simpanan" class="form-control" readonly>
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
<div class="row mb-3" id="sisa-field">
    <div class="col">
        <label for="sisa_saldo" id="sisa-title" class="form-label text-primary">Sisa Saldo</label>
        <input type="text" name="sisa_saldo" id="sisa-saldo"
            class="form-control @error('sisa_saldo') is-invalid @enderror" readonly>
        @error('sisa_saldo')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
