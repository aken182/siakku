<form action="{{ route($store) }}" method="post">
    @csrf
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
    @switch($jenis)
        @case('coa')
            <x-saldo-awal.form.create-coa :coa="$coa" :main="$main" />
        @break

        @case('persediaan')
            <x-saldo-awal.form.create-barang :main="$main" :barang="$barang" :jenis="$jenis" :satuan="$satuan"
                :unit="$unit" />
        @break

        @case('inventaris')
            <x-saldo-awal.form.create-barang :main="$main" :barang="$barang" :jenis="$jenis" :satuan="$satuan"
                :unit="$unit" />
        @break

        @default
    @endswitch
</form>
