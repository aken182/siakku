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
                            <h4 class="card-title">Form Tambah</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form" action="{{ route($routeStore) }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="nama_barang" class="text-primary">Nama</label>
                                                <input type="hidden" name="posisi_pi" value="{{ $posisi }}">
                                                <input type="text" id="nama_barang" name="nama_barang"
                                                    class="form-control @error('nama_barang') is-invalid @enderror"
                                                    placeholder="{{ $posisi === 'persediaan' ? 'Masukkan Nama Persediaan' : 'Masukkan Nama Inventaris' }}"
                                                    value="{{ old('nama_barang') }}">
                                                @error('nama_barang')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="id_satuan" class="text-primary">Satuan</label>
                                                <select name="id_satuan"
                                                    class="form-select choices @error('id_satuan') is-invalid @enderror">
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
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="jenis_barang" class="text-primary">Jenis</label>
                                                <select name="jenis_barang"
                                                    class="choices form-select @error('jenis_barang') is-invalid @enderror">
                                                    <option value="" selected>Pilih Jenis</option>
                                                    @if ($posisi === 'persediaan')
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
                                                @error('jenis_barang')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="id_unit" class="text-primary">Unit</label>
                                                <select name="id_unit"
                                                    class="form-select choices @error('id_unit') is-invalid @enderror">
                                                    <option value="" selected>Pilih Unit</option>
                                                    @foreach ($unit as $u)
                                                        <option value="{{ $u->id_unit }}">{{ $u->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('id_unit')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="harga_barang" class="text-primary">Harga Barang
                                                    (Opsional)</label>
                                                <input type="text" name="harga_barang"
                                                    class="form-control format-rupiah">
                                            </div>
                                        </div>
                                        @if ($posisi === 'inventaris')
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="tgl_beli" class="text-primary">Tanggal Beli
                                                        (Opsional)</label>
                                                    <input type="date" name="tgl_beli" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="stok" class="text-primary">Stok
                                                        (Opsional)</label>
                                                    <input type="number" step="0.25" name="stok"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="nilai_saat_ini" class="text-primary">Nilai Buku
                                                        (Opsional)</label>
                                                    <input type="text" name="nilai_saat_ini"
                                                        class="form-control format-rupiah">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group  col-6">
                                                    <label for="umur_ekonomis" class="text-primary">Umur Ekonomis</label>
                                                    <div class="input-group">
                                                        <input type="number" step="0.25" name="umur_ekonomis"
                                                            class="form-control @error('umur_ekonomis') is-invalid @enderror"
                                                            placeholder="ex. 3">
                                                        <input class="form-control" value="tahun" readonly>
                                                        @error('umur_ekonomis')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="cek_status" class="text-primary">Status Konversi
                                                    (Opsional)</label>
                                                <div class="form-check form-switch mb-2">
                                                    <input class="form-check-input" type="checkbox" id="cek_status">
                                                    <label class="form-check-label" for="cek_status">Saya mengkonversi
                                                        {{ $posisi }} ini.
                                                    </label>
                                                </div>
                                                <input type="hidden" name="status_konversi" value="T"
                                                    id="status_konversi">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="harga_jual" class="text-primary">Harga Jual (Opsional)</label>
                                                <div class="form-check form-switch mb-2">
                                                    <input class="form-check-input" type="checkbox" id="cek_harga_jual">
                                                    <label class="form-check-label" for="cek_harga_jual">Saya menjual
                                                        {{ $posisi }} ini.
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12" id="harga_jual_common">
                                            <div class="form-group">
                                                <input type="text" id="harga_jual" name="harga_jual"
                                                    class="form-control format-rupiah @error('harga_jual') is-invalid @enderror"
                                                    placeholder="Masukkan Harga Jual" value="{{ old('harga_jual') }}">
                                                @error('harga_jual')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
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
    <script src=" {{ asset('assets/admin') }}/js/siakku-custom/goods-master.js"></script>
@endsection
