@extends('layouts.contentSidebarLayout')
@section('title', "$title")
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>{{ $title }}</h3>
                    <p class="text-subtitle text-muted">Form Transaksi {{ $title }} unit {{ $unit }}</p>
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
                <form action="{{ $routeStore }}" method="POST" enctype="multipart/form-data">
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
                                    <label class="form-label text-primary"><b>Jenis Simpanan</b></label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-check mt-3">
                                                <label class="form-check-label" for="simpananBaru">
                                                    Simpanan Baru
                                                </label>
                                                <input class="form-check-input @error('cek_simpanan') is-invalid @enderror"
                                                    name="cek_simpanan" type="radio" value="baru" id="simpananBaru" />
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-check mt-3">
                                                <label class="form-check-label" for="simpananPenyesuaian">
                                                    Penyesuaian
                                                </label>
                                                <input class="form-check-input @error('cek_simpanan') is-invalid @enderror"
                                                    name="cek_simpanan" type="radio" value="penyesuaian"
                                                    id="simpananPenyesuaian" />
                                                @error('cek_simpanan')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3 detail-penyesuaian-simpanan">
                                    <label class="form-label text-primary"><b>Simpanan yang Disesuaikan</b></label>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <select name="id_penyesuaian" id="invoicePenyesuaian"
                                                    class="form-select choices invoicePenyesuaian @error('id_penyesuaian') is-invalid @enderror">
                                                    <option value="">Pilih Nomor Transaksi..</option>
                                                    @foreach ($pnySimpanan as $p)
                                                        <option value="{{ $p->id_transaksi }}">{{ $p->kode }}</option>
                                                    @endforeach
                                                </select>
                                                @error('id_penyesuaian')
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
                                                    <div class="detailSimpanan"></div>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if ($unit === 'Simpan Pinjam')
                                <hr class="m-0" style="height: 0.5px" />
                                <div class="card-body">
                                    <div class="row mt-3">
                                        <div class="col">
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <label for="id_simpanan" class="form-label text-primary">Nama
                                                        Simpanan</label>
                                                    <select class="choices form-select select-barang" id="id_simpanan">
                                                        <option value="" selected>Pilih Simpanan</option>
                                                        @foreach ($masterSimpanan as $s)
                                                            <option value="{{ $s->id_simpanan }}">{{ $s->nama }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <label for="harga_barang" class="form-label text-primary">Besar
                                                        Simpanan/Bulan</label>
                                                    <input type="text" id="jumlahPerBulan"
                                                        placeholder="Pilih simpanan untuk melihat besar simpanan/bulan."
                                                        class="form-control"readonly>
                                                    <input type="hidden" id="namaSimpanan" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <label for="jumlah" class="form-label text-primary">Jumlah
                                                        Simpanan</label>
                                                    <input type="text" placeholder="Masukkan jumlah setoran."
                                                        id="jumlahSimpan" class="form-control format-rupiah">
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
                                        <label for="keranjangTabel" class="form-label text-primary"><i
                                                class="bi bi-bag"></i>
                                            <b>Tabel Keranjang</b></label>
                                        <div class="table table-responsive p-3">
                                            <table class="table table-info" id="keranjangTabel">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama</th>
                                                        <th>Jumlah</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <input type="hidden"
                                            class="form-control  @error('data_simpanan') is-invalid @enderror"
                                            name="data_simpanan" id="dataSimpanan">
                                        @error('data_simpanan')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-9" style="text-align: right"></div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="" class="text-primary">Total Simpanan</label>
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
                            @endif
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
                                                <label class="text-primary form-label" for="id_anggota">Nama
                                                    Anggota</label>
                                                <select
                                                    class="form-select choices @error('id_anggota') is-invalid @enderror"
                                                    name="id_anggota">
                                                    <option value="">Pilih nama anggota</option>
                                                    @forelse ($anggota as $a)
                                                        <option value="{{ $a->id_anggota }}">{{ $a->nama }}
                                                        </option>
                                                    @empty
                                                        <option class="text-warning" value="">Anggota tidak
                                                            ditemukan</option>
                                                    @endforelse
                                                </select>
                                                @error('id_anggota')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        @if ($unit === 'Pertokoan')
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <label for="total_transaksi" class="form-label  text-primary">Jumlah
                                                        Setoran</label>
                                                    <input type="text" name="total_transaksi"
                                                        class="form-control format-rupiah @error('total_transaksi') is-invalid @enderror"
                                                        placeholder="Masukkan jumlah setoran simpanan.">
                                                    @error('total_transaksi')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        @endif
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
                                                <label for="nomor" class="form-label  text-primary">Nomor</label>
                                                <input type="hidden" id="routeUrl"
                                                    data-route="{{ route($routeDetail) }}" />
                                                <input type="hidden" name="unit" value="{{ $unit }}">
                                                <input type="hidden" name="jenis_transaksi"
                                                    value="{{ $title }}">
                                                <input type="text" id="nomor" name="nomor"
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
                                        <div class="row mb-2">
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
                                        <x-form.metode-pembayaran :kasBank="$dataKasBank" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                <a type="button" href="{{ route($routeMain) }}"
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
    <script src="{{ asset('assets/admin') }}/js/siakku-custom/main-simpanan.js"></script>
    <script src="{{ asset('assets/admin') }}/js/siakku-service/kafta-helpers-a.js"></script>
    <script src="{{ asset('assets/admin') }}/js/siakku-custom/penyesuaian-simpanan.js"></script>
    @if ($unit === 'Simpan Pinjam')
        <script>
            var mS = @json($masterSimpanan);
        </script>
        <script src="{{ asset('assets/admin') }}/js/siakku-custom/simpanan-sp.js"></script>
    @endif
@endsection
