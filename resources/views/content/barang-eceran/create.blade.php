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
                            <h4 class="card-title">Form Tambah Konversi</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form" action="{{ route($routeStore) }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="text-primary" for="id_barang">Nama Barang</label>
                                                <select class="form-select choices @error('id_barang') is-invalid @enderror"
                                                    id="id_barang" name="id_barang">
                                                    <option value="" selected>Pilih Barang</option>
                                                    @foreach ($barang as $item)
                                                        <option value="{{ $item->id_barang }}">
                                                            {{ $item->kode_barang }} - {{ $item->nama_barang }}</option>
                                                    @endforeach
                                                </select>
                                                @error('id_barang')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="text-primary" for="stok">Stok Grosir Awal</label>
                                                <input class="form-control" id="namabarang" name="nama_barang"
                                                    type="hidden" readonly>
                                                <input class="form-control" id="kodebarang" name="kode_barang"
                                                    type="hidden" readonly>
                                                <div class="input-group">
                                                    <input class="form-control" id="stok" name="stok" step="0.25"
                                                        type="number" placeholder="Stok Awal" onKeyUp="hitung()" readonly>
                                                    <input class="form-control" id="satuan" name="satuan" type="text"
                                                        placeholder="Satuan Stok" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="text-primary" for="harga_barang">Harga Barang Grosir</label>
                                                <input class="form-control" id="harga_barang" name="harga_barang"
                                                    type="text" placeholder="Harga Barang" onKeyUp="hitung()" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="text-primary" for="harga_jual">Harga Jual Grosir</label>
                                                <input class="form-control" id="harga_jual" name="harga_jual" type="text"
                                                    placeholder="Harga Jual" onKeyUp="hitung()" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="divider divider-primary">
                                            <div class="divider-text">
                                                <h6>GROSIR <i class="menu-icon tf-icons bx bx-transfer"></i> ECERAN</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col mb-3">
                                                <div class="divider">
                                                    <div class="divider-text">
                                                        <label class="text-primary" for="id_satuan">Satuan Eceran</label>
                                                    </div>
                                                </div>
                                                <select class="form-select choices @error('id_satuan') is-invalid @enderror"
                                                    id="id_satuan" name="id_satuan">
                                                    <option value="" selected>Pilih Satuan</option>
                                                    @foreach ($satuan as $item)
                                                        <option value="{{ $item->id_satuan }}">{{ $item->nama_satuan }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('id_satuan')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col mb-3">
                                                <div class="divider">
                                                    <div class="divider-text">
                                                        <label class="text-primary" for="standar">Standar
                                                            Konversi</label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                            <input class="form-control" type="number" step="0.25"
                                                                value="1.00" placeholder="standar grosir" readonly>
                                                            <input class="form-control" id="standar" type="text"
                                                                aria-label="nama satuan" placeholder="Satuan Stok Grosir"
                                                                readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <label class="text-primary text-dark" for="persamaan">
                                                            <h4>=</h4>
                                                        </label>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="input-group">
                                                            <input
                                                                class="form-control @error('standar_nilai') is-invalid @enderror"
                                                                id="standar_nilai" name="standar_nilai" type="number"
                                                                step="0.25" onKeyUp="hitung()"
                                                                placeholder="Standar eceran" />
                                                            <input class="form-control" id="standar_konversi"
                                                                name="standar_konversi" type="text"
                                                                aria-label="nama satuan konversi"
                                                                placeholder="Satuan Stok Eceran" readonly>
                                                            @error('standar_nilai')
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
                                    <div class="row">
                                        <div class="col mb-3">
                                            <div class="divider">
                                                <div class="divider-text">
                                                    <label class="text-primary" for="id_satuan">Konversi Stok</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                        <input
                                                            class="form-control @error('jumlah_konversi') is-invalid @enderror"
                                                            id="jumlah_konversi" name="jumlah_konversi" type="number"
                                                            step="0.25" onKeyUp="hitung()"
                                                            placeholder="Jumlah Konversi">
                                                        <input class="form-control" id="standar2" type="text"
                                                            placeholder="Satuan Stok Grosir" readonly>
                                                        @error('jumlah_konversi')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <label class="text-primary text-bold" for="jumlah_konversi">
                                                        <h4>=</h4>
                                                    </label>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="input-group">
                                                        <input
                                                            class="form-control @error('stok_konversi') is-invalid @enderror"
                                                            id="stok_konversi" name="stok_konversi" type="number"
                                                            step="0.25" placeholder="Hasil Konversi" readonly>
                                                        <input class="form-control" id="standar_konversi2" type="text"
                                                            aria-label="nama satuan konversi"
                                                            placeholder="Satuan Stok Ecer" readonly>
                                                        @error('stok_konversi')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col mb-3">
                                            <hr class="m-0" style="border-top:1px solid cornflowerblue">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="col mb-3">
                                                <label class="text-primary" for="sisa_stok">Stok Grosir Akhir</label>
                                                <div class="row">
                                                    <div class="input-group">
                                                        <input
                                                            class="form-control @error('sisa_stok') is-invalid @enderror"
                                                            id="sisa_stok" name="sisa_stok" type="number"
                                                            step="0.25" placeholder="Sisa Stok" readonly>
                                                        <input class="form-control" id="standar3" type="text"
                                                            aria-label="sisa stok" readonly>
                                                        @error('sisa_stok')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="col mb-3">
                                                <label class="text-primary" for="harga_barang_konversi">Harga Barang
                                                    Eceran</label>
                                                <input
                                                    class="form-control @error('harga_barang_konversi') is-invalid @enderror"
                                                    id="harga_barang_konversi" name="harga_barang_konversi"
                                                    type="text" placeholder="Harga barang Eceran" readonly>
                                                @error('harga_barang_konversi')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="col mb-3">
                                                <label class="text-primary" for="harga_jual_konversi">Harga Jual
                                                    Eceran</label>
                                                <input
                                                    class="form-control
                                                  @error('harga_jual_konversi') is-invalid @enderror"
                                                    id="harga_jual_konversi" name="harga_jual_konversi" type="text"
                                                    placeholder="Masukkan Harga Jual">
                                                @error('harga_jual_konversi')
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
    <script>
        var barangJson = @json($barang);
        var satuanJson = @json($satuan);
    </script>
    <script src=" {{ asset('assets/admin') }}/js/siakku-custom/goods-add-convert.js"></script>
@endsection
