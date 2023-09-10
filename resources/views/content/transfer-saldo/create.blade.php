@extends('layouts.contentSidebarLayout')
@section('title', "$title")
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>{{ $title }}</h3>
                    <p class="text-subtitle text-muted">Form Transaksi Unit {{ $unit }}</p>
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
                        <x-panduan.panduan-transfer-saldo-kasbank :title="'Transfer Saldo Kas & Bank'">
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
                            <div class="row mb-3 detail-penyesuaian-transfer">
                                <label class="form-label text-capitalize text-primary">Transaksi yang
                                    Disesuaikan</label>
                                <div class="col-md-12 mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <select name="id_penyesuaian"
                                                class="form-select choices invoicePenyesuaianTransfer @error('id_penyesuaian') is-invalid @enderror">
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
                                                    <div id="detailTransfer"></div>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6 mb-3">
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
                            </div>
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
                                <label for="id_pengirim" class="form-label text-capitalize text-primary">Dari</label>
                                <select class="form-select choices @error('id_pengirim') is-invalid @enderror"
                                    name="id_pengirim" id="pengirim">
                                    <option value="" selected>Pilih Akun Pengirim...</option>
                                    @foreach ($coa as $i)
                                        <option value="{{ $i->id_coa }}">{{ $i->nama }}</option>
                                    @endforeach
                                </select>
                                @error('id_pengirim')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-6 mb-3">
                                <label for="id_penerima" class="form-label text-capitalize text-primary">Kepada</label>
                                <select class="form-select choices @error('id_penerima') is-invalid @enderror"
                                    name="id_penerima" id="penerima">
                                    <option value="">Pilih Akun Penerima...</option>
                                    @foreach ($coa as $ii)
                                        <option value="{{ $ii->id_coa }}">{{ $ii->nama }}</option>
                                    @endforeach
                                </select>
                                @error('id_penerima')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-6 mb-2">
                                <div class="row tampilPengirim">
                                    <p class="text-primary">Saldo : <span id="saldo_pengirim"></span></p>
                                </div>
                            </div>
                            <div class="col-6 mb-2">
                                <div class="row tampilPenerima">
                                    <p class="text-primary">Saldo : <span id="saldo_penerima"></span></p>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="jumlah" class="form-label text-capitalize text-primary">Jumlah
                                    Transfer</label>
                                <input type="text" name="jumlah"
                                    class="form-control format-rupiah @error('jumlah') is-invalid @enderror"
                                    placeholder="Masukkan Jumlah Transfer..." />
                                @error('jumlah')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-6 mb-3">
                                <label for="no_bukti" class="form-label text-capitalize text-primary">Nomor
                                    Bukti</label>
                                <input type="text" id="no_bukti" name="no_bukti"
                                    class="form-control @error('no_bukti') is-invalid @enderror"
                                    placeholder="Masukkan Nomor Bukti.." />
                                @error('no_bukti')
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
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="nota_transaksi" class="form-label text-capitalize text-primary">Nota
                                    Transaksi</label>
                                <div class="input-group">
                                    <input type="file"
                                        class="form-control @error('nota_transaksi') is-invalid @enderror"
                                        name="nota_transaksi" id="inputGroupFile03"
                                        aria-describedby="inputGroupFileAddon03" aria-label="Upload" />
                                    @error('nota_transaksi')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
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
    <script>
        var saldoJson = @json($saldoAkun);
        var unit = @json($unit);
    </script>
    <script src="{{ asset('assets/admin') }}/js/siakku-custom/transfer-saldo.js"></script>
@endsection
