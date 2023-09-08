    @switch($jenis)
        @case('coa')
            <x-saldo-awal.form.edit-coa :coa="$coa" :debet="$debet" :kredit="$kredit" :main="$main"
                :store="$store" :idtransaksi="$idtransaksi" :tanggal="$tanggal" />
        @break

        @case('persediaan')
            <x-saldo-awal.form.edit-barang :detail="$detail" :jenis="$jenis" :satuan="$satuan" :unit="$unit"
                :barang="$barang" :main="$main" :store="$store" :idtransaksi="$idtransaksi" :tanggal="$tanggal" />
        @break

        @case('inventaris')
            <x-saldo-awal.form.edit-barang :detail="$detail" :jenis="$jenis" :satuan="$satuan" :unit="$unit"
                :barang="$barang" :main="$main" :store="$store" :idtransaksi="$idtransaksi" :tanggal="$tanggal" />
        @break
    @endswitch
