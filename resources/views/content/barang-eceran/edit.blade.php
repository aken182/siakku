@extends('layouts.contentSidebarLayout')
@section('title', "$title")
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>{{ $title }}</h3>
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
        <!-- // Basic multiple Column Form section start -->
        <section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Form Edit Stok</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form" action="{{ route($routeUpdate, $barang->id_eceran) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="row">
                                        <div class="col mb-3">
                                            <label class="text-primary" for="id_barang">Nama Barang</label>
                                            <input class="form-control" id="konversi" name="konversi" type="hidden"
                                                value="{{ $barang->id_eceran }}" readonly>
                                            <input class="form-control" name="id_barang" type="hidden"
                                                value="{{ $barang->id_barang }}" readonly>
                                            <input class="form-control" name="kode_barang" type="hidden"
                                                value="{{ $barang->barang->kode_barang }}" readonly>
                                            <input class="form-control" name="nama_barang" type="hidden"
                                                value="{{ $barang->barang->nama_barang }}" readonly>
                                            <input class="form-control"readonly type="text"
                                                value="{{ $barang->barang->kode_barang }}-{{ $barang->barang->nama_barang }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="divider">
                                            <div class="divider-text">
                                                <label class="text-primary">Stok Awal</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col mb-3">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="text-primary" for="stok">Stok Grosir</label>
                                                    <div class="input-group">
                                                        <input class="form-control" id="stok_sebelum" name="stok"
                                                            type="number" step="0.25"
                                                            value="{{ $barang->barang->stok }}" onKeyUp="hitungUpdate()"
                                                            readonly>
                                                        <input class="form-control" name="satuan" type="text"
                                                            value="{{ $barang->barang->satuan->nama_satuan }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="text-primary" for="stok">Stok Eceran</label>
                                                    <div class="input-group">
                                                        <input class="form-control" id="stokk_sebelum" name="stok_konversi"
                                                            type="number" step="0.25" value="{{ $barang->stok }}"
                                                            onKeyUp="hitungUpdate()" readonly>
                                                        <input class="form-control" name="satuan_konversi" type="text"
                                                            value="{{ $barang->satuan->nama_satuan }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="divider">
                                            <div class="divider-text">
                                                <label class="text-primary">Konversi Stok</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col mb-3">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="text-primary" for="tambah_stok">Stok Grosir</label>
                                                    <div class="input-group">
                                                        <input
                                                            class="form-control @error('tambah_stok') is-invalid @enderror"
                                                            id="tambah_stok" name="tambah_stok" type="number"
                                                            step="0.25" onKeyUp="hitungUpdate()"
                                                            placeholder="Masukkan stok grosir.">
                                                        <input class="form-control" type="text"
                                                            value="{{ $barang->barang->satuan->nama_satuan }}" readonly>
                                                        @error('tambah_stok')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="row">
                                                        <i class='bx bx-chevrons-right'></i>
                                                        <input class="form-control" id="standar_nilai"
                                                            name="standar_nilai" step="0.25" type="hidden"
                                                            value="{{ $barang->standar_nilai }}"
                                                            onKeyUp="hitungUpdate()">
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <label class="text-primary" for="hasil_tambah">Stok Eceran</label>
                                                    <div class="input-group">
                                                        <input class="form-control" id="hasil_tambah" name="hasil_tambah"
                                                            type="number" step="0.25" placeholder="Hasil" readonly>
                                                        <input class="form-control" type="text"
                                                            value="{{ $barang->satuan->nama_satuan }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="divider">
                                            <div class="divider-text">
                                                <label class="text-primary">Stok Setelah Konversi</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col mb-3">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="text-primary" for="sisa_stok">Stok Grosir</label>
                                                    <div class="input-group">
                                                        <input
                                                            class="form-control @error('sisa_stok') is-invalid @enderror"
                                                            id="sisa_stok_update" name="sisa_stok" type="number"
                                                            step="0.25" placeholder="Hasil" readonly>
                                                        @error('sisa_stok')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                        <input class="form-control" type="text"
                                                            value="{{ $barang->barang->satuan->nama_satuan }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="text-primary" for="sisa_stokkon">Stok Eceran</label>
                                                    <div class="input-group">
                                                        <input class="form-control" id="sisa_stokkon_update"
                                                            name="sisa_stokkon" type="number" step="0.25"
                                                            placeholder="Hasil" readonly>
                                                        <input class="form-control" type="text"
                                                            value="{{ $barang->satuan->nama_satuan }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                            <a type="button" href="{{ route($routeMain) }}"
                                                class="btn btn-light-secondary me-1 mb-1">Keluar</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- // Basic multiple Column Form section end -->
    </div>
@endsection
@section('pageScript')
    <script src=" {{ asset('assets/admin') }}/js/siakku-custom/goods-edit-convert.js"></script>
@endsection
