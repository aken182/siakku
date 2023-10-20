@extends('layouts.contentSidebarLayout')
@section('title', "$title")
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>{{ $title }}</h3>
                    <p class="text-subtitle text-muted">Form Transaksi {{ $title }} Unit {{ $unit }}</p>
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
            <form action="{{ route($routeStore) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Form Transaksi</h5>
                        <div class="col-12 d-flex justify-content-end">
                            <button class="btn rounded-pill btn-icon btn-outline-info" type="button"
                                data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false"
                                title="Panduan" aria-controls="collapseExample"><span class='bi bi-info-circle'>
                                    Panduan</span>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <x-panduan.panduan-transfer-saldo-kasbank :title="$title">
                        </x-panduan.panduan-transfer-saldo-kasbank>
                        <div class="row mb-3">
                            <div class="row mb-3">
                                <label class="form-label text-capitalize text-primary"><b>Jenis
                                        Transaksi</b></label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-check mt-3">
                                            <input class="form-check-input @error('cek_penyesuaian') is-invalid @enderror"
                                                name="cek_penyesuaian" type="radio" value="baru" id="transaksiBaru" />
                                            <label class="form-check-label" for="transaksiBaru">
                                                Transaksi Baru
                                            </label>
                                            @error('cek_penyesuaian')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-check mt-3">
                                            <input class="form-check-input @error('cek_penyesuaian') is-invalid @enderror"
                                                name="cek_penyesuaian" type="radio" value="penyesuaian"
                                                id="transaksiPenyesuaian" />
                                            <label class="form-check-label" for="transaksiPenyesuaian">
                                                Penyesuaian
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3 detail-penyesuaian">
                                <label class="form-label text-capitalize text-primary">Transaksi yang
                                    Disesuaikan</label>
                                <div class="col-md-12 mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="hidden" id="penyesuaian-route"
                                                data-route="{{ route($routeDetailPenyesuaian) }}" />
                                            <select name="id_penyesuaian" id="id-penyesuaian"
                                                class="form-select choices invoicePenyesuaian @error('id_penyesuaian') is-invalid @enderror">
                                                <option value="">Pilih Nomor Transaksi..</option>
                                                @foreach ($penyesuaian as $p)
                                                    <option value="{{ $p->id_transaksi }}">{{ $p->kode }}
                                                    </option>
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
                                <div class="col-md-12">
                                    <div class="collapse" id="collapseDetailPenyesuaian">
                                        <div class="row">
                                            <div class="d-flex p-3 border">
                                                <span>
                                                    <div id="detailTransaksi"></div>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            {{-- <div class="col-md-6 col-sm-6 col-lg-6">
                                <label for="tgl_transaksi" class="form-label text-capitalize text-primary">Tanggal
                                    Transaksi</label>
                                <input type="date" id="tgl_transaksi" name="tgl_transaksi"
                                    class="form-control @error('tgl_transaksi') is-invalid @enderror"
                                    placeholder="Masukkan Tanggal Transaksi.." />
                                @error('tgl_transaksi')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div> --}}
                            <div class="col-md-6 col-sm-6 col-lg-6">
                                <label for="tahun_shu" class="form-label text-capitalize text-primary">Tahun Buku</label>
                                <select name="tahun_shu" id="tahun_shu"
                                    class="form-select choices @error('tahun_shu') is-invalid @enderror">
                                    <option value="" selected>Pilih Tahun Pembukuan</option>
                                    @for ($i = date('Y'); $i >= date('Y') - 17; $i -= 1)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                                @error('tahun_shu')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <button type="button" class="btn btn-sm btn-outline-primary lihat-jurnal"><i
                                        class="bi bi-card-list"></i> Lihat Jurnal SHU</button>
                                <input type="hidden" id="jurnal-route" data-route="{{ route($routeJurnal) }}" />
                            </div>
                        </div>
                        <div class="row mb-3 show-jurnal">
                            <div class="col">
                                <input type="hidden" name="total_transaksi" id="total-transaksi">
                                <div id="detailJurnal"></div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6 mb-3">
                                <label for="nomor_transaksi" class="form-label text-capitalize text-primary">Nomor
                                    Transaksi</label>
                                <input type="text" id="nomor_transaksi" name="nomor"
                                    class="form-control @error('nomor') is-invalid @enderror" value="{{ $nomor }}"
                                    placeholder="Masukkan Nomor Transaksi.." />
                                @error('nomor')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-6 mb-3">
                                <label for="keterangan" class="form-label text-capitalize text-primary">Keterangan</label>
                                <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" cols="30"
                                    rows="3" placeholder="Masukkan Keterangan"></textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                            <a type="button" href="{{ route($routeMain) }}"
                                class="btn btn-light-secondary me-1 mb-1">Kembali</a>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection
@section('pageScript')
    <script src="{{ asset('assets/admin') }}/js/siakku-custom/penyesuaian-transaksi-shu.js"></script>
    <script src="{{ asset('assets/admin') }}/js/siakku-custom/transaksi-shu.js"></script>
@endsection
