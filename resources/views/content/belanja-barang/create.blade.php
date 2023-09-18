@extends('layouts.contentSidebarLayout')
@section('title', "$title")
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>{{ $title }}</h3>
                    <p class="text-subtitle text-muted text-capitalize">Form Transaksi Pengadaan {{ $jenis }} unit
                        {{ $unit . ' - TPK ' . $tpk }}</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="page-content">
        <section class="section">
            <div class="card">
                <form action="{{ route($storeRoute) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="card shadow-none bg-transparent border border-grey mb-3">
                            <div class="card-header">
                                <h5 class="card-title">Form Transaksi</h5>
                                <div class="col-12 d-flex justify-content-end">
                                    <button class="btn rounded-pill btn-icon btn-outline-info" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false"
                                        title="Panduan" aria-controls="collapseExample"><span class='bi bi-info-circle'>
                                            Panduan</span>
                                    </button>
                                </div>
                                <x-panduan.panduan-belanja-barang :title="$title">
                                </x-panduan.panduan-belanja-barang>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <label class="form-label text-primary"><b>Jenis Belanja</b></label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-check mt-3">
                                                <input class="form-check-input @error('cek_belanja') is-invalid @enderror"
                                                    name="cek_belanja" type="radio" value="baru" id="belanjaBaru" />
                                                <label class="form-check-label" for="belanjaBaru">
                                                    Belanja Baru
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-check mt-3">
                                                <input class="form-check-input @error('cek_belanja') is-invalid @enderror"
                                                    name="cek_belanja" type="radio" value="penyesuaian"
                                                    id="belanjaPenyesuaian" />
                                                <label class="form-check-label" for="belanjaPenyesuaian">
                                                    Penyesuaian
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    @error('cek_belanja')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="row mb-3 detail-penyesuaian-belanja">
                                    <label class="form-label text-primary"><b>Belanja yang Disesuaikan</b></label>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <select name="id_belanja_penyesuaian" id="invoicePenyesuaianBelanja"
                                                    class="form-select choices invoicePenyesuaianBelanja @error('id_belanja_penyesuaian') is-invalid @enderror">
                                                    <option value="">Pilih Nomor Transaksi..</option>
                                                    @foreach ($pnyBelanja as $p)
                                                        <option value="{{ $p->id_transaksi }}">{{ $p->kode }}</option>
                                                    @endforeach
                                                </select>
                                                @error('id_belanja_penyesuaian')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <button class="btn btn-outline-primary me-1" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseDetailPenyesuaian"
                                                    aria-expanded="false" aria-controls="collapseDetailPenyesuaian"><i
                                                        class='bx bx-show'></i>
                                                    Lihat Detail
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="collapse mt-3" id="collapseDetailPenyesuaian">
                                        <div class="row">
                                            <div class="d-flex p-3 border">
                                                <span>
                                                    <div id="detailBelanja"></div>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="m-0" style="height: 0.5px" />
                            <div class="card-body">
                                <div class="row mt-3">
                                    <div class="divider">
                                        <div class="divider-text text-primary text-capitalize"><b>Form Input
                                                {{ $jenis }}</b></div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-7 col-12">
                                        <div class="row mb-4">
                                            <label for="" class="text-primary text-capitalize">Jenis
                                                {{ $jenis }}</label>
                                            <div class="col-md-4">
                                                <div class="form-check mt-3">
                                                    <input class="form-check-input" name="cek_barang" type="radio"
                                                        value="barang baru" />
                                                    <label class="form-check-label text-capitalize" for="barangBaru">
                                                        {{ $jenis }} Baru
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-check mt-3">
                                                    <input class="form-check-input" name="cek_barang" type="radio"
                                                        value="dari database" />
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
                                                    <div class="form-group  col-6">
                                                        <label for="umur_ekonomis_baru" class="text-primary">Umur
                                                            Ekonomis</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.25" id="umur_ekonomis_baru"
                                                                class="form-control" placeholder="ex. 3">
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
                                                            <option value="{{ $item->id_satuan }}">
                                                                {{ $item->nama_satuan }}
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
                                                        @foreach ($units as $u)
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
                                                    <label for="id_barang"
                                                        class="text-primary text-capitalize">Nama</label>
                                                    <select class="form-select choices" id="id_barang">
                                                        <option value="" selected>Pilih {{ $jenis }}</p>
                                                        </option>
                                                        @foreach ($barang as $b)
                                                            <option value="{{ $b->id_barang }}">{{ $b->nama_barang }}
                                                            </option>
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
                                                            placeholder="Pilih {{ $jenis }} untuk melihat tanggal beli."
                                                            readonly>
                                                        <small class="text-primary"><i>Jika inventaris memiliki tanggal
                                                                beli atau memiliki stok maka anda harus memilih jenis
                                                                inventaris baru pada field jenis inventaris !</i></small>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="col-md-12 col-12">
                                                <div class="form-group">
                                                    <label for="stok" class="text-primary">Stok</label>
                                                    <input type="text" id="stok" class="form-control"
                                                        placeholder="Pilih {{ $jenis }} untuk melihat stok."
                                                        readonly>
                                                </div>
                                            </div>
                                            @if ($jenis === 'inventaris')
                                                <div class="col-md-12 col-12">
                                                    <div class="form-group col-6">
                                                        <label for="umur_ekonomis" class="text-primary">Umur
                                                            Ekonomis</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.25" id="umur_ekonomis"
                                                                class="form-control"
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
                                                        placeholder="Pilih {{ $jenis }} untuk melihat satuan."
                                                        class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-12">
                                                <div class="form-group">
                                                    <label for="jenis_barang" class="text-primary">Jenis</label>
                                                    <input type="text" id="jenis_barang"
                                                        placeholder="Pilih {{ $jenis }} untuk melihat jenis."
                                                        class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-12">
                                                <div class="form-group">
                                                    <label for="nama_unit" class="text-primary">Unit</label>
                                                    <input type="text" id="nama_unit"
                                                        placeholder="Pilih {{ $jenis }} untuk melihat unit."
                                                        class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-12">
                                        <div class="row mb-3">
                                            <div class="col-md-12 col-12">
                                                <div class="form-group">
                                                    <label for="jumlah" class="form-label text-primary">Qty</label>
                                                    <input type="number" step="0.25"
                                                        placeholder="Masukkan jumlah pengadaan {{ $jenis }}."
                                                        id="qty" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-12">
                                                <div class="form-group">
                                                    <label for="harga" class="form-label text-primary">Harga
                                                        Beli</label>
                                                    <input type="text"
                                                        placeholder="Masukkan harga beli {{ $jenis }}."
                                                        id="harga_beli" class="form-control format-rupiah">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3 mb-3">
                                    <div class="col-lg-3 col-md-3 col-sm-3">
                                        <button type="button" class="btn btn-sm btn-outline-primary addToChartBtn"><i
                                                class="bi bi-basket"></i>
                                            Tambah Ke Keranjang</button>
                                    </div>
                                </div>
                                <hr class="m-0" style="height: 0.5px" />
                                <div class="row mt-3">
                                    <label for="keranjangTabel" class="form-label text-primary"><i
                                            class="bi bi-cart-check"></i> <b>Tabel
                                            Keranjang</b></label>
                                    <div class="table table-responsive p-3">
                                        <table class="table table-info" id="keranjangTabel">
                                            <thead>
                                                <tr>
                                                    <th>Nama</th>
                                                    <th>Jenis</th>
                                                    <th>Qty</th>
                                                    <th>Harga</th>
                                                    <th>Subtotal</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <input type="hidden" class="form-control  @error('data_barang') is-invalid @enderror"
                                        name="data_barang" id="dataBarang">
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
                                            <label for="" class="text-primary">Total Belanja</label>
                                            <input
                                                class="form-control text-dark no-box @error('total_transaksi') is-invalid @enderror"
                                                id="total_transaksi" style="text-align: right" name="total_transaksi"
                                                readonly>
                                            @error('total_transaksi')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="m-0" style="height: 0.5px" />
                            <div class="card-body">
                                <div class="row row mt-3">
                                    <div class="col">
                                        <div class="row mb-3">
                                            <div class="col">
                                                <label for="nameBackdrop" class="form-label text-primary">Tanggal
                                                    Transaksi</label>
                                                <input type="date" id="nameBackdrop" name="tgl_transaksi"
                                                    class="form-control @error('tgl_transaksi') is-invalid @enderror"
                                                    placeholder="Masukkan Tanggal">
                                                @error('tgl_transaksi')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col">
                                                <label for="id_penyedia" class="form-label  text-primary">Vendor</label>
                                                <select name="id_penyedia" id="id_penyedia"
                                                    class="selectpicker w-100 @error('id_penyedia') is-invalid @enderror"
                                                    data-style="btn-outline-secondary" data-live-search="true">
                                                    <option value="">Pilih Vendor</option>
                                                    @foreach ($vendor as $v)
                                                        <option value="{{ $v->id_penyedia }}">{{ $v->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('id_penyedia')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col mb-3">
                                                <label for="nota_transaksi" class="form-label  text-primary">Nota
                                                    Transaksi</label>
                                                <div class="input-group">
                                                    <input type="file"
                                                        class="form-control @error('nota_transaksi') is-invalid @enderror"
                                                        name="nota_transaksi" id="inputGroupFile03"
                                                        aria-describedby="inputGroupFileAddon03" aria-label="Upload">
                                                    @error('nota_transaksi')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="row">
                                            <div class="col mb-3">
                                                <label for="nameBackdrop" class="form-label  text-primary">Nomor</label>
                                                <input type="hidden" id="routeUrl"
                                                    data-route="{{ route($routeDetail) }}" />
                                                <input type="hidden" name="unit" value="{{ $unit }}">
                                                <input type="hidden" name="tpk" value="{{ $tpk }}">
                                                <input type="hidden" name="jenis_transaksi" value="Pengadaan Barang">
                                                <input type="hidden" name="jenis" value="{{ $jenis }}">
                                                <input type="text" id="nameBackdrop" name="nomor"
                                                    value="{{ $nomor }}"
                                                    class="form-control @error('nomor') is-invalid @enderror"
                                                    placeholder="Masukkan Nomor Tagihan">
                                                @error('nomor')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <label for="nameBackdrop" class="form-label  text-primary">Nomor
                                                    Bukti</label>
                                                <input type="text" name="no_bukti" id=""
                                                    class="form-control @error('no_bukti') is-invalid @enderror"
                                                    placeholder="Masukkan Nomor Bukti.">
                                                @error('no_bukti')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <x-form.metode-belanja :akunBelanja="$dataAkunBelanja" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                <a type="button" href="{{ route($route) }}"
                                    class="btn btn-light-secondary me-1 mb-1">Kembali</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
@section('pageScript')
    <script>
        var barangs = @json($barang);
        var satuans = @json($satuan);
    </script>
    <script src="{{ asset('assets/admin') }}/js/siakku-custom/belanja-barang.js"></script>
    @if ($jenis === 'inventaris')
        <script src="{{ asset('assets/admin') }}/js/siakku-custom/pengadaan-inventaris.js"></script>
    @else
        <script src="{{ asset('assets/admin') }}/js/siakku-custom/pengadaan-persediaan.js"></script>
    @endif
    <script src="{{ asset('assets/admin') }}/js/siakku-service/kafta-helpers-a.js"></script>
@endsection
