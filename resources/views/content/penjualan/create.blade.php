@extends('layouts.contentSidebarLayout')
@section('title', "$title")
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>{{ $title }}</h3>
                    <p class="text-subtitle text-muted">Form Transaksi Penjualan unit {{ $unit }} - TPK
                        {{ $tpk }}</p>
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
                <form action="{{ route('ptk-penjualan.store-barang') }}" method="POST" enctype="multipart/form-data">
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
                                <x-panduan.panduan-penjualan-hasil-jasa :title="$title">
                                </x-panduan.panduan-penjualan-hasil-jasa>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <label class="form-label text-primary"><b>Jenis Penjualan</b></label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-check mt-3">
                                                <label class="form-check-label" for="penjualanBaru">
                                                    Penjualan Baru
                                                </label>
                                                <input class="form-check-input @error('cek_penjualan') is-invalid @enderror"
                                                    name="cek_penjualan" type="radio" value="baru" id="penjualanBaru" />
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-check mt-3">
                                                <label class="form-check-label" for="penjualanPenyesuaian">
                                                    Penyesuaian
                                                </label>
                                                <input class="form-check-input @error('cek_penjualan') is-invalid @enderror"
                                                    name="cek_penjualan" type="radio" value="penyesuaian"
                                                    id="penjualanPenyesuaian" />
                                                @error('cek_penjualan')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3 detail-penyesuaian-penjualan">
                                    <label class="form-label text-primary"><b>Penjualan yang Disesuaikan</b></label>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <select name="id_penjualan_penyesuaian" id="invoicePenyesuaianPenjualan"
                                                    class="form-select choices invoicePenyesuaianPenjualan @error('id_penjualan_penyesuaian') is-invalid @enderror">
                                                    <option value="">Pilih Nomor Transaksi..</option>
                                                    @foreach ($pnypenjualan as $p)
                                                        <option value="{{ $p->id_transaksi }}">{{ $p->kode }}</option>
                                                    @endforeach
                                                </select>
                                                @error('id_penjualan_penyesuaian')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <button class="btn btn-outline-primary me-1" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#collapseDetailPenyesuaianPenjualan"
                                                    aria-expanded="false"
                                                    aria-controls="collapseDetailPenyesuaianPenjualan"><i
                                                        class='bx bx-show'></i>
                                                    Lihat Detail
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="collapse mt-3" id="collapseDetailPenyesuaianPenjualan">
                                        <div class="row">
                                            <div class="d-flex p-3 border">
                                                <span>
                                                    <div class="detailPenjualan"></div>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="m-0" style="height: 0.5px" />
                            <div class="card-body">
                                <div class="row mt-3">
                                    <div class="col">
                                        <div class="row mb-3">
                                            <div class="col">
                                                <label for="cek_barang" class="form-label text-primary">Jenis Barang</label>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-check mt-3">
                                                            <input class="form-check-input" name="cek_barang" type="radio"
                                                                value="barang grosir" id="barangGrosir" />
                                                            <label class="form-check-label" for="barangGrosir">
                                                                Barang Grosir
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="form-check mt-3">
                                                            <input class="form-check-input" name="cek_barang"
                                                                type="radio" value="barang eceran" id="barangEceran" />
                                                            <label class="form-check-label" for="barangEceran">
                                                                Barang Eceran
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3 field-grosir">
                                            <div class="col">
                                                <label for="barang_grosir" class="form-label text-primary">Barang
                                                    Grosir</label>
                                                <select name="id_grosir" class="choices form-select select-barang"
                                                    id="id_grosir">
                                                    <option value="" selected>Pilih Barang</option>
                                                    @foreach ($barangGrosir as $g)
                                                        <option value="{{ $g->id_barang }}">{{ $g->nama_barang }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3 field-eceran">
                                            <div class="col">
                                                <label for="barang_eceran" class="form-label text-primary">Barang
                                                    Eceran</label>
                                                <select name="id_eceran" id="id_eceran"
                                                    class="choices form-select select-barang">
                                                    <option value="" selected>Pilih Barang</option>
                                                    @foreach ($barangEceran as $g)
                                                        <option value="{{ $g->id_eceran }}">
                                                            {{ $g->barang->nama_barang }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <span id="namaBarang" hidden></span>
                                        <div class="row mb-3">
                                            <div class="col">
                                                <label for="stok_barang" class="form-label text-primary">Stok
                                                    Barang</label>
                                                <div class="input-group">
                                                    <input type="text" id="stokBarang"
                                                        placeholder="Pilih barang untuk melihat stok."
                                                        class="form-control"readonly>
                                                    <span class="input-group-text" id="satuanBarang"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col">
                                                <label for="harga_barang" class="form-label text-primary">Harga
                                                    Barang</label>
                                                <input type="text" id="hargaBarang"
                                                    placeholder="Pilih barang untuk melihat harganya."
                                                    class="form-control"readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="row mb-3">
                                            <div class="col">
                                                <label for="kuantitas" class="form-label text-primary">Kuantitas</label>
                                                <input type="number" step="0.25"
                                                    placeholder="Masukkan kuantitas barang." id="kuantitas"
                                                    class="form-control">
                                                <small id="validasiQty" class="text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col">
                                                <label for="harga_jual" class="form-label text-primary">Harga Jual</label>
                                                <input type="text" placeholder="Masukkan harga jual barang."
                                                    id="hargaJual" class="form-control format-rupiah">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-3">
                                        <button type="button" class="btn btn-sm btn-outline-primary addToChartBtn"><i
                                                class="bi bi-plus"></i>Tambah Ke Keranjang</button>
                                    </div>
                                </div>
                            </div>
                            <hr class="m-0" style="height: 0.5px" />
                            <div class="card-body">
                                <div class="row mt-3">
                                    <label for="keranjangTabel" class="form-label text-primary"><i class="bi bi-bag"></i>
                                        <b>Tabel Keranjang</b></label>
                                    <div class="table table-responsive p-3">
                                        <table class="table table-info" id="keranjangTabel">
                                            <thead>
                                                <tr>
                                                    <th>Nama</th>
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
                                            <label for="" class="text-primary">Total Penjualan</label>
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
                                            <div class="col mb-3">
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
                                        <x-pendapatan.pembeli-atribut :pegawai="$pegawai" />
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
                                                <input type="hidden" name="unit" value="{{ $unit }}">
                                                <input type="hidden" name="tpk" value="{{ $tpk }}">
                                                <input type="hidden" name="jenis_transaksi" value="Penjualan Barang">
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
                                            <div class="col mb-3">
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
                                            <x-form.metode-pembayaran :kasBank="$dataKasBank" />
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
        var barangs = @json($barangGrosir);
        var konversis = @json($barangEceran);
    </script>
    <script src="{{ asset('assets/admin') }}/js/siakku-custom/penjualan-barang.js"></script>
    <script src="{{ asset('assets/admin') }}/js/siakku-custom/penyesuaian-penjualan-barang.js"></script>
    <script src="{{ asset('assets/admin') }}/js/siakku-service/kafta-helpers-a.js"></script>
@endsection
