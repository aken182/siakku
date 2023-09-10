<form action="{{ route($store, $idtransaksi) }}" method="post">
    @csrf
    @method('PATCH')
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
    <div class="row mt-3">
        <div class="divider">
            <div class="divider-text text-primary text-capitalize"><b>Form Input {{ $jenis }}</b></div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-7 col-12">
            <div class="row mb-4">
                <label for="" class="text-primary text-capitalize">Jenis {{ $jenis }}</label>
                <div class="col-md-4">
                    <div class="form-check mt-3">
                        <input class="form-check-input" name="cek_barang" type="radio" value="barang baru" />
                        <label class="form-check-label text-capitalize" for="barangBaru">
                            {{ $jenis }} Baru
                        </label>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-check mt-3">
                        <input class="form-check-input" name="cek_barang" type="radio" value="dari database" />
                        <label class="form-check-label text-capitalize" for="barangTersedia">
                            Dari Master {{ $jenis }}
                        </label>
                    </div>
                </div>
            </div>
            <div class="row field-barang-baru">
                <div class="col-md-12 col-12">
                    <div class="form-group">
                        <label for="nama_barang_baru" class="text-primary">Nama</label>
                        <input type="text" id="nama_barang_baru" class="form-control"
                            placeholder="{{ $jenis === 'persediaan' ? 'Masukkan nama persediaan' : 'Masukkan nama inventaris' }}">
                    </div>
                </div>
                @if ($jenis === 'inventaris')
                    <div class="col-md-12 col-12">
                        <div class="form-group">
                            <label for="tgl_beli_baru" class="text-primary">Tanggal Beli</label>
                            <input type="date" id="tgl_beli_baru" class="form-control"
                                placeholder="Pilih {{ $jenis }} untuk melihat tanggal beli.">
                        </div>
                    </div>
                    <div class="col-md-12 col-12">
                        <div class="form-group  col-6">
                            <label for="umur_ekonomis_baru" class="text-primary">Umur Ekonomis</label>
                            <div class="input-group">
                                <input type="number" step="0.25" id="umur_ekonomis_baru" class="form-control"
                                    placeholder="ex. 3">
                                <input class="form-control" value="tahun" readonly>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-md-12 col-12">
                    <div class="form-group">
                        <label for="id_satuan_baru" class="text-primary">Satuan</label>
                        <select id="id_satuan_baru" class="form-select choices">
                            <option value="" selected>Pilih Satuan</option>
                            @foreach ($satuan as $item)
                                <option value="{{ $item->id_satuan }}">{{ $item->nama_satuan }}
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" id="nama_satuan_baru" class="form-control">
                    </div>
                </div>
                <div class="col-md-12 col-12">
                    <div class="form-group">
                        <label for="jenis_barang_baru" class="text-primary">Jenis</label>
                        <select id="jenis_barang_baru" class="form-select">
                            <option value="" selected>Pilih Jenis</option>
                            @if ($jenis === 'persediaan')
                                <option value="Barang Konsumsi">Barang Konsumsi</option>
                                <option value="Barang Sandang">Barang Sandang</option>
                                <option value="Barang Kosmetik">Barang Kosmetik</option>
                                <option value="Barang ATM">Barang ATM</option>
                                <option value="Barang Elektronik">Barang Elektronik</option>
                                <option value="Barang Bangunan">Barang Bangunan</option>
                            @else
                                <option value="Perlengkapan">Perlengkapan</option>
                                <option value="Peralatan">Peralatan</option>
                                <option value="Mesin">Mesin</option>
                                <option value="Kendaraan">Kendaraan</option>
                                <option value="Gedung">Gedung</option>
                                <option value="Tanah">Tanah</option>
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-md-12 col-12">
                    <div class="form-group">
                        <label for="id_unit_baru" class="text-primary">Unit</label>
                        <select id="id_unit_baru" class="form-select">
                            <option value="" selected>Pilih Unit</option>
                            @foreach ($unit as $u)
                                <option value="{{ $u->id_unit }}">{{ $u->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row field-dari-database">
                <div class="col-md-12 col-12">
                    <div class="form-group">
                        <label for="id_barang" class="text-primary text-capitalize">Nama</label>
                        <select class="form-select choices" id="id_barang">
                            <option value="" selected>Pilih {{ $jenis }}</p>
                            </option>
                            @foreach ($barang as $b)
                                <option value="{{ $b->id_barang }}">{{ $b->nama_barang }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" id="nama_barang" class="form-control">
                    </div>
                </div>
                @if ($jenis === 'inventaris')
                    <div class="col-md-12 col-12">
                        <div class="form-group">
                            <label for="tgl_beli" class="text-primary">Tanggal Beli</label>
                            <input type="date" id="tgl_beli" class="form-control"
                                placeholder="Pilih {{ $jenis }} untuk melihat tanggal beli.">
                        </div>
                    </div>
                    <div class="col-md-12 col-12">
                        <div class="form-group col-6">
                            <label for="umur_ekonomis" class="text-primary">Umur Ekonomis</label>
                            <div class="input-group">
                                <input type="number" step="0.25" id="umur_ekonomis" class="form-control"
                                    placeholder="Pilih {{ $jenis }}." readonly>
                                <input class="form-control" value="tahun" readonly>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-md-12 col-12">
                    <div class="form-group">
                        <label for="nama_satuan" class="text-primary">Satuan</label>
                        <input type="text" id="nama_satuan"
                            placeholder="Pilih {{ $jenis }} untuk melihat satuan." class="form-control"
                            readonly>
                    </div>
                </div>
                <div class="col-md-12 col-12">
                    <div class="form-group">
                        <label for="jenis_barang" class="text-primary">Jenis</label>
                        <input type="text" id="jenis_barang"
                            placeholder="Pilih {{ $jenis }} untuk melihat jenis." class="form-control"
                            readonly>
                    </div>
                </div>
                <div class="col-md-12 col-12">
                    <div class="form-group">
                        <label for="nama_unit" class="text-primary">Unit</label>
                        <input type="text" id="nama_unit"
                            placeholder="Pilih {{ $jenis }} untuk melihat unit." class="form-control"
                            readonly>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5 col-12">
            <div class="row mb-3">
                <div class="col-md-12 col-12">
                    <div class="form-group">
                        <label for="jumlah" class="form-label text-primary">Stok</label>
                        <input type="number" step="0.25" placeholder="Masukkan jumlah stok {{ $jenis }}."
                            id="qty" class="form-control">
                    </div>
                </div>
                <div class="col-md-12 col-12">
                    <div class="form-group">
                        <label for="harga" class="form-label text-primary">Harga Beli</label>
                        <input type="text" placeholder="Masukkan harga beli {{ $jenis }}." id="harga_beli"
                            class="form-control format-rupiah">
                    </div>
                </div>
                @if ($jenis === 'inventaris')
                    <div class="col-md-12 col-12">
                        <div class="form-group">
                            <label for="harga" class="form-label text-primary">Nilai Buku</label>
                            <input type="text" placeholder="Masukkan harga beli {{ $jenis }}."
                                id="nilai_buku" class="form-control format-rupiah">
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="row mt-3 mb-3">
        <div class="col-lg-3 col-md-3 col-sm-3">
            <button type="button" class="btn btn-sm btn-outline-primary addToChartBtn"><i class="bi bi-basket"></i>
                Tambah Ke Keranjang</button>
        </div>
    </div>
    <hr class="m-0" style="height: 0.5px" />
    <div class="row mt-3">
        <label for="keranjangTabel" class="form-label text-primary"><i class="bi bi-cart-check"></i> <b>Tabel
                Keranjang</b></label>
        <div class="table table-responsive p-3">
            <table class="table table-info" id="keranjangTabel">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Jenis</th>
                        @if ($jenis === 'inventaris')
                            <th>Tgl. Beli</th>
                        @endif
                        <th>Stok</th>
                        @if ($jenis === 'persediaan')
                            <th>Harga</th>
                        @endif
                        @if ($jenis === 'inventaris')
                            <th>Nilai Buku</th>
                        @endif
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
        <input type="hidden" class="form-control  @error('data_barang') is-invalid @enderror" name="data_barang"
            id="dataBarang">
        @error('data_barang')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="row mb-3">
        <div class="col-md-9" style="text-align: right"></div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="" class="text-primary">Total Saldo Awal</label>
                <input class="form-control text-dark no-box @error('total_transaksi') is-invalid @enderror"
                    id="total_transaksi" style="text-align: right" name="total_transaksi" readonly>
                @error('total_transaksi')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 d-flex justify-content-end">
            <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
            <a type="button" href="{{ route($main) }}" class="btn btn-light-secondary me-1 mb-1">Kembali</a>
        </div>
    </div>
</form>

@section('pageScript')
    <script>
        var barangs = @json($barang);
        var satuans = @json($satuan);
        var detailTransaksi = @json($detail);
    </script>
    @if ($jenis === 'inventaris')
        <script src="{{ asset('assets/admin') }}/js/siakku-custom/edit-inventaris.js"></script>
    @else
        <script src="{{ asset('assets/admin') }}/js/siakku-custom/edit-persediaan.js"></script>
    @endif
@endsection
