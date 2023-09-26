@extends('layouts.contentSidebarLayout')
@section('title', "$title")
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>{{ $title }}</h3>
                    <p class="text-subtitle text-muted text-capitalize">Form Transaksi
                        {{ $jenis === 'umum' ? $title : $title . ' ' . $jenis }} unit
                        {{ $unit }}</p>
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
                                    <label class="form-label text-primary"><b>Jenis Transaksi</b></label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-check mt-3">
                                                <label class="form-check-label" for="penarikanBaru">
                                                    Transaksi Baru
                                                </label>
                                                <input class="form-check-input @error('cek_penarikan') is-invalid @enderror"
                                                    name="cek_penarikan" type="radio" value="baru" id="penarikanBaru" />
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-check mt-3">
                                                <label class="form-check-label" for="penarikanPenyesuaian">
                                                    Penyesuaian
                                                </label>
                                                <input class="form-check-input @error('cek_penarikan') is-invalid @enderror"
                                                    name="cek_penarikan" type="radio" value="penyesuaian"
                                                    id="penarikanPenyesuaian" />
                                                @error('cek_penarikan')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3 detail-penyesuaian-penarikan">
                                    <label class="form-label text-primary"><b>Transaksi yang Disesuaikan</b></label>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <select name="id_penyesuaian" id="invoicePenyesuaian"
                                                    class="form-select choices invoicePenyesuaian @error('id_penyesuaian') is-invalid @enderror">
                                                    <option value="">Pilih Nomor Transaksi..</option>
                                                    @foreach ($pnyPenarikan as $p)
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
                                                    <div class="detailPenarikan"></div>
                                                </span>
                                            </div>
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
                                                <label for="tgl_transaksi" class="form-label text-primary">Tanggal
                                                    Transaksi</label>
                                                <input type="date" id="tgl_transaksi" name="tgl_transaksi"
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
                                                    name="id_anggota" id="id-anggota">
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
                                        @if ($jenis === 'umum')
                                            <x-form.create-penarikan-umum :simpanan="$simpanan" :unit="$unit" />
                                        @endif
                                        @if ($jenis === 'sukarela berbunga')
                                            <x-form.create-penarikan-sbr />
                                        @endif
                                    </div>
                                    <div class="col">
                                        <div class="row">
                                            <div class="col mb-3">
                                                <label for="nomor" class="form-label  text-primary">Nomor</label>
                                                <input type="hidden" id="routeUrl"
                                                    data-route="{{ route($routeDetail) }}" />
                                                <input type="hidden" id="route-saldo"
                                                    data-route="{{ route($routeSaldo) }}" />
                                                <input type="hidden" name="unit" value="{{ $unit }}">
                                                <input type="hidden" name="jenis_transaksi"
                                                    value="{{ $jenis === 'umum' ? $title : 'Penarikan Simpanan Sukarela Berbunga' }}">
                                                <input type="hidden" name="jenis" value="{{ $jenis }}">
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
                                                <label for="no_bukti" class="form-label  text-primary">Nomor
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
                                        <div class="row mb-3">
                                            <div class="col">
                                                <label for="metode_transaksi" class="text-primary">Penarikan
                                                    Melalui</label>
                                                <select name="metode_transaksi"
                                                    class="form-select metode-transaksi @error('metode_transaksi') is-invalid @enderror">
                                                    <option value="" selected>Pilih Metode Penarikan</option>
                                                    <option value="Kas">Kas</option>
                                                    <option value="Bank">Bank</option>
                                                </select>
                                                @error('metode_transaksi')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3 akun-kas">
                                            <div class="col">
                                                <label for="id_kas" class="text-primary">Akun Kas</label>
                                                <select name="id_kas"
                                                    class="form-select @error('id_kas') is-invalid @enderror">
                                                    <option value="" selected>Pilih Akun Kas</option>
                                                    @foreach ($akunKas as $kas)
                                                        <option value="{{ $kas->id_coa }}">{{ $kas->nama }}</option>
                                                    @endforeach
                                                </select>
                                                @error('id_kas')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3 akun-bank">
                                            <div class="col">
                                                <label for="id_bank" class="text-primary">Akun Bank</label>
                                                <select name="id_bank"
                                                    class="form-select @error('id_bank') is-invalid @enderror">
                                                    <option value="" selected>Pilih Akun Bank</option>
                                                    @foreach ($akunBank as $bank)
                                                        <option value="{{ $bank->id_coa }}">{{ $bank->nama }}</option>
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
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary me-1 mb-1" id="btn-submit">Submit</button>
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
    <script src="{{ asset('assets/admin') }}/js/siakku-custom/main-penarikan.js"></script>
    <script src="{{ asset('assets/admin') }}/js/siakku-custom/penyesuaian-penarikan.js"></script>
    @if ($jenis === 'umum')
        <script src="{{ asset('assets/admin') }}/js/siakku-custom/penarikan-umum.js"></script>
    @endif
    @if ($jenis === 'sukarela berbunga')
        <script src="{{ asset('assets/admin') }}/js/siakku-custom/penarikan-srb.js"></script>
    @endif
@endsection
