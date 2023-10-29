@extends('layouts.contentSidebarLayout')
@section('title', "$title")
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>{{ $title }}</h3>
                    <p class="text-subtitle text-muted">Form Pelunasan {{ $title }} Unit {{ $unit }}</p>
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
                <form action="{{ $storeRoute }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="card shadow-none bg-transparent border border-grey mb-3">
                            <div class="card-header">
                                <h5 class="card-title">Form Pelunasan</h5>
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
                                    <label class="form-label text-primary"><b>Jenis Pembayaran</b></label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-check mt-3">
                                                <label class="form-check-label" for="pembayaranBaru">
                                                    Pembayaran Baru
                                                </label>
                                                <input
                                                    class="form-check-input @error('cek_pembayaran') is-invalid @enderror"
                                                    name="cek_pembayaran" type="radio" value="baru"
                                                    id="pembayaranBaru" />
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-check mt-3">
                                                <label class="form-check-label" for="pembayaranPenyesuaian">
                                                    Penyesuaian
                                                </label>
                                                <input
                                                    class="form-check-input @error('cek_pembayaran') is-invalid @enderror"
                                                    name="cek_pembayaran" type="radio" value="penyesuaian"
                                                    id="pembayaranPenyesuaian" />
                                                @error('cek_pembayaran')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3 detail-penyesuaian-pembayaran">
                                    <label class="form-label text-primary"><b>Pembayaran yang Disesuaikan</b></label>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <select name="id_pny_pembayaran" id="invoicePenyesuaianPembayaran"
                                                    class="form-select choices invoicePenyesuaianPembayaran @error('id_pny_pembayaran') is-invalid @enderror">
                                                    <option value="">Pilih Nomor Transaksi..</option>
                                                    @foreach ($pnyPembayaran as $p)
                                                        <option value="{{ $p->id_detail }}">{{ $p->transaksi->kode }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('id_pny_pembayaran')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <button class="btn btn-outline-primary me-1" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#collapseDetailPenyesuaianPembayaran"
                                                    aria-expanded="false"
                                                    aria-controls="collapseDetailPenyesuaianPembayaran"><i
                                                        class='bx bx-show'></i>
                                                    Lihat Detail
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="collapse mt-3" id="collapseDetailPenyesuaianPembayaran">
                                            <div class="d-flex p-3 border">
                                                <span>
                                                    <div class="detailPembayaran"></div>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="m-0" style="height: 0.5px" />
                            <div class="card-body">
                                <div class="row mt-3">
                                    <label class="form-label text-primary"><b>Form Pembayaran</b></label>
                                </div>
                                <div class="row mt-3">
                                    <div class="col">
                                        <div class="row">
                                            <div class="col mb-3">
                                                <label for="no_bukti" class="form-label text-primary">Nomor
                                                    Bukti</label>
                                                <input type="text" name="no_bukti"
                                                    class="form-control @error('no_bukti') is-invalid @enderror"
                                                    placeholder="Masukkan Nomor Bukti.">
                                                @error('no_bukti')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        @if ($jenis === 'Pembayaran Piutang Penjualan')
                                            <x-form.create-pelunasan-penjualan :tagihan="$tagihan" />
                                        @endif
                                        @if ($jenis === 'Pembayaran Hutang Belanja')
                                            <x-form.create-pelunasan-belanja :tagihan="$tagihan" />
                                        @endif
                                        @if ($jenis === 'Pembayaran Piutang Penjualan' || $jenis === 'Pembayaran Hutang Belanja')
                                            <x-form.field-pelunasan-lainnya :jenis="$jenis" />
                                        @endif
                                        @if ($jenis === 'Pembayaran Pinjaman Anggota')
                                            <x-form.create-angsuran-pinjaman :tagihan="$tagihan" />
                                        @endif
                                        <div class="row">
                                            <div class="col mb-3">
                                                <label for="nota_transaksi" class="text-primary">Nota
                                                    Pembayaran</label>
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
                                                <label for="no_pembayaran" class="text-primary">Nomor Pembayaran</label>
                                                <input type="hidden" id="routeUrl"
                                                    data-route="{{ route($routeDetail) }}" />
                                                <input type="text"
                                                    class="form-control @error('no_pembayaran') is-invalid @enderror"
                                                    name="no_pembayaran" value="{{ $noPembayaran }}">
                                                @error('no_pembayaran')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                                <input type="hidden" name="unit" value="{{ $unit }}">
                                                <input type="hidden" name="routemain" value="{{ $route }}">
                                                <input type="hidden" name="jenis_transaksi"
                                                    value="{{ $jenis }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col mb-3">
                                                <label for="tgl_transaksi" class="text-primary">Tanggal Transaksi</label>
                                                <input type="date" name="tgl_transaksi"
                                                    placeholder="Masukkan Tanggal Pembayaran"
                                                    class="form-control @error('tgl_transaksi') is-invalid @enderror"
                                                    id="tgl_transaksi">
                                                @error('tgl_transaksi')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col mb-3">
                                                <label for="metode_transaksi" class="text-primary">Via Pembayaran</label>
                                                <select name="metode_transaksi"
                                                    class="form-select choices @error('metode_transaksi') is-invalid @enderror"
                                                    id="metode_transaksi">
                                                    <option value="">Pilih Via Pembayaran</option>
                                                    <option value="Kas">Cash</option>
                                                    <option value="Bank">Transfer Bank</option>
                                                </select>
                                                @error('metode_transaksi')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row" id="rekening_kas">
                                            <div class="col mb-3">
                                                <label for="id_kas" class="text-primary">Rekening Kas</label>
                                                <select name="id_kas"
                                                    class="form-select choices @error('id_kas') is-invalid @enderror"
                                                    id="id_kas">
                                                    <option value="" selected>Pilih Rekening Kas</option>
                                                    @foreach ($coas as $coa)
                                                        <option value="{{ $coa->id_coa }}">{{ $coa->nama }}</option>
                                                    @endforeach
                                                </select>
                                                @error('id_kas')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row" id="rekening_bank">
                                            <div class="col mb-3">
                                                <label for="id_bank" class="text-primary">Rekening Bank</label>
                                                <select name="id_bank"
                                                    class="form-select choices @error('id_bank') is-invalid @enderror"
                                                    id="id_bank">
                                                    <option value="" selected>Pilih Rekening Bank</option>
                                                    @foreach ($coass as $coa)
                                                        <option value="{{ $coa->id_coa }}">{{ $coa->nama }}</option>
                                                    @endforeach
                                                </select>
                                                @error('id_bank')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col mb-3">
                                                <label for="keterangan" class="text-primary">Keterangan</label>
                                                <textarea name="keterangan" id="keterangan" cols="30" rows="3"
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
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row mb-3">
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <a type="button" class="btn btn-outline-secondary"
                                    href="{{ route($route) }}">Keluar</a>
                                <button type="submit" class="btn btn-primary simpanBtn">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection

@section('pageScript')
    @if ($jenis === 'Pembayaran Piutang Penjualan' || $jenis === 'Pembayaran Hutang Belanja')
        <script>
            var tg = @json($tagihan);
        </script>
    @endif
    @if ($jenis === 'Pembayaran Piutang Penjualan')
        <script src="{{ asset('assets/admin') }}/js/siakku-custom/penyesuaian-pembayaran-tagihan-penjualan.js"></script>
        <script src="{{ asset('assets/admin') }}/js/siakku-custom/pembayaran-tagihan-penjualan.js"></script>
    @endif
    @if ($jenis === 'Pembayaran Hutang Belanja')
        <script src="{{ asset('assets/admin') }}/js/siakku-custom/penyesuaian-pembayaran-tagihan-belanja.js"></script>
        <script src="{{ asset('assets/admin') }}/js/siakku-custom/pembayaran-tagihan-belanja.js"></script>
    @endif
    @if ($jenis === 'Pembayaran Pinjaman Anggota')
        <script src="{{ asset('assets/admin') }}/js/siakku-custom/angsuran-pinjaman-pny.js"></script>
        <script src="{{ asset('assets/admin') }}/js/siakku-custom/angsuran-pinjaman.js"></script>
    @endif
@endsection
