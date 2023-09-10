<table>
    @switch($jenisTabel)
        @case('anggota')
            <x-table.anggota :tabel="$tabel" />
        @break

        @case('unit')
            <x-table.unit :tabel="$tabel" />
        @break

        @case('satuan')
            <x-table.satuan :tabel="$tabel" />
        @break

        @case('berita')
            <x-table.berita :tabel="$tabel" />
        @break

        @case('persediaan')
        @case('inventaris')
            <x-table.barang :tabel="$tabel" :jenis="$jenisTabel" />
        @break

        @case('vendor')
            <x-table.vendor :tabel="$tabel" />
        @break

        @case('simpanan')
            <x-table.master-simpanan :tabel="$tabel" />
        @break

        @case('pengajuan')
            <x-table.pengajuan :tabel="$tabel" />
        @break

        @case('coa')
            <x-table.coa :tabel="$tabel" />
        @break

        @case('shu')
            <x-table.shu :tabel="$tabel" />
        @break

        @case('saldo awal coa')
            <x-table.saldo-awal-coa :tabel="$tabel" />
        @break

        @case('saldo awal persediaan')
        @case('saldo awal inventaris')
            <x-table.saldo-awal-barang :tabel="$tabel" :jenis="$jenisTabel" />
        @break
    @endswitch
</table>
