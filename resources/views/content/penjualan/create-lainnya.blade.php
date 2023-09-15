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
                <form action="{{ route('ptk-penjualan.store-lainnya') }}" method="POST" enctype="multipart/form-data">
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
                                                <input class="form-check-input @error('cek_penjualan') is-invalid @enderror"
                                                    name="cek_penjualan" type="radio" value="baru" id="penjualanBaru" />
                                                <label class="form-check-label" for="penjualanBaru">
                                                    Penjualan Baru
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-check mt-3">
                                                <input class="form-check-input @error('cek_penjualan') is-invalid @enderror"
                                                    name="cek_penjualan" type="radio" value="penyesuaian"
                                                    id="penjualanPenyesuaian" />
                                                <label class="form-check-label" for="penjualanPenyesuaian">
                                                    Penyesuaian
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    @error('cek_penjualan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
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
                                <div class="row mt-3">
                                    <div class="col">
                                        <div class="row">
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
                                        <x-form.metode-pembayaran :kasBank="$dataKasBank" />
                                        <div class="row">
                                            <div class="col mb-3">
                                                <label for="nota_transaksi" class="form-label text-primary">Nota
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
                                                <label for="nameBackdrop" class="form-label text-primary">Nomor</label>
                                                <input type="hidden" name="tpk" value="{{ $tpk }}">
                                                <input type="hidden" name="unit" value="{{ $unit }}">
                                                <input type="hidden" name="jenis_transaksi" value="Penjualan Lainnya">
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
                                        <div class="jns-pembeli">
                                            <x-pendapatan.pembeli-atribut :pegawai="$pegawai" />
                                        </div>
                                        <div class="row">
                                            <div class="col mb-3">
                                                <label for="nameBackdrop" class="form-label text-primary">Sumber
                                                    Pendapatan</label>
                                                <select id="id_kredit" name="id_kredit"
                                                    class="form-select choices @error('id_kredit') is-invalid @enderror">
                                                    <option value="" selected>Pilih Kode - Nama Akun</option>
                                                    @foreach ($coa as $c)
                                                        <option value="{{ $c->id_coa }}">
                                                            {{ $c->kode . ' - ' . $c->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('id_kredit')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col mb-3">
                                                <label for="nameBackdrop"
                                                    class="form-label text-primary">Keterangan</label>
                                                <textarea name="keterangan" id="" cols="25" rows="3"
                                                    class="form-control @error('keterangan') is-invalid @enderror"></textarea>
                                                @error('keterangan')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="m-0" style="height: 0.5px" />
                            <hr class="m-0" style="height: 0.5px" />
                            <hr class="m-0" style="height: 0.5px" />
                            <div class="card-body">
                                <div class="row mt-3">
                                    <label for="keranjangTabel" class="form-label text-primary"><i class="bi bi-bag"></i>
                                        <b>Detail Transaksi</b></label>
                                    <table id="table-data" class="table table-borderless table-sm mb-3">
                                        <thead class="table-dark text-light">
                                            <tr>
                                                <th>Nama</th>
                                                <th style="width:120px">Jenis</th>
                                                <th style="width:100px">Qty</th>
                                                <th style="width:180px">Satuan</th>
                                                <th style="width:180px">Harga Satuan</th>
                                                <th style="width:180px">Total</th>
                                                <th style="width:50px">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="row-multi-insert">
                                                <td><input class="form-control @error('data') is-invalid @enderror"
                                                        type="text" name="data[0][nama]" required>
                                                    @error('data')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <select name="data[0][jenis]" class="form-select" required>
                                                        <option value="" selected>Pilih</option>
                                                        <option value="Hasil">Hasil</option>
                                                        <option value="Jasa">Jasa</option>
                                                    </select>
                                                </td>
                                                <td><input class="form-control" type="number" id="qty0"
                                                        step="0.25" name="data[0][kuantitas]" onKeyUp="hitung(0)"
                                                        required>
                                                </td>
                                                <td>
                                                    <select name="data[0][satuan]" class="form-select choices" required>
                                                        <option value="" selected>Pilih</option>
                                                        @foreach ($satuans as $satuan)
                                                            <option value="{{ $satuan->id_satuan }}">
                                                                {{ $satuan->nama_satuan }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td><input class="form-control format-rupiah" type="text"
                                                        name="data[0][harga]" id="harga0" onKeyUp="hitung(0)"
                                                        style="text-align: right;" required>
                                                </td>
                                                <td><input class="form-control" type="text" id="total0"
                                                        name="data[0][total]" style="text-align: right;" readonly>
                                                </td>
                                                <td><button type="button"
                                                        class="btn btn-sm btn-outline-danger remove-row"><span
                                                            class="bi bi-trash"></span></button></td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5" style="text-align:right">
                                                    <h5 class="text-dark">Total Penjualan</h5>
                                                </td>
                                                <td style="text-align:right">
                                                    <h5 id="total_semua"></h5>
                                                    <input type="hidden" name="total_transaksi"
                                                        class="form-control @error('total_transaksi') is-invalid @enderror"
                                                        id="total_transaksi">
                                                    @error('total_transaksi')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <div class="row">
                                        <div class="col mb-3">
                                            <button type="button" class="btn btn-sm btn-outline-primary"
                                                id="add-row"><span class="bi bi-plus"></span>&nbsp;Tambah
                                                Baris</button>
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
        var satuanJson = @json($satuans);
    </script>
    <script src="{{ asset('assets/admin') }}/js/siakku-custom/penjualan-lainnya.js"></script>
    <script src="{{ asset('assets/admin') }}/js/siakku-custom/penyesuaian-penjualan-lainnya.js"></script>
    <script src="{{ asset('assets/admin') }}/js/siakku-service/kafta-helpers-a.js"></script>
@endsection
