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
                            <h4 class="card-title">Form Edit</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form" action="{{ route($routeUpdate, $barang->id_barang) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="nama_barang" class="text-primary">Nama</label>
                                                <input type="hidden" name="posisi_pi" value="{{ $barang->posisi_pi }}">
                                                <input type="text" id="nama_barang" name="nama_barang"
                                                    class="form-control @error('nama_barang') is-invalid @enderror"
                                                    placeholder="{{ $barang->posisi_pi === 'persediaan' ? 'Masukkan Nama Persediaan' : 'Masukkan Nama Inventaris' }}"
                                                    value="{{ $barang->nama_barang }}">
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
                                                    <option value="{{ $barang->id_satuan }}" selected>
                                                        {{ $barang->satuan->nama_satuan }}</option>
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
                                                    <option value="{{ $barang->jenis_barang }}" selected>
                                                        {{ $barang->jenis_barang }}</option>
                                                    @if ($barang->posisi_pi === 'persediaan')
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
                                                    <option value="{{ $barang->id_unit }}" selected>
                                                        {{ $barang->unit->nama }}</option>
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
                                                    value="{{ buatrp($barang->harga_barang) }}"
                                                    class="form-control format-rupiah">
                                            </div>
                                        </div>
                                        @if ($barang->posisi_pi === 'inventaris')
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="tgl_beli" class="text-primary">Tanggal Beli
                                                        (Opsional)</label>
                                                    <input type="date" name="tgl_beli" value="{{ $barang->tgl_beli }}"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="stok" class="text-primary">Stok
                                                        (Opsional)</label>
                                                    <input type="number" step="0.25" name="stok"
                                                        class="form-control" value="{{ $barang->stok }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="nilai_saat_ini" class="text-primary">Nilai Buku
                                                        (Opsional)</label>
                                                    <input type="text" name="nilai_saat_ini"
                                                        value="{{ buatrp($barang->nilai_saat_ini) }}"
                                                        class="form-control format-rupiah">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group  col-6">
                                                    <label for="umur_ekonomis" class="text-primary">Umur Ekonomis</label>
                                                    <div class="input-group">
                                                        <input type="number" step="0.25" name="umur_ekonomis"
                                                            value="{{ $barang->umur_ekonomis }}"
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
                                                    <input class="form-check-input" type="checkbox" id="cek_status"
                                                        {{ $barang->status_konversi == 'T' ? '' : 'checked' }}>
                                                    <label class="form-check-label" for="cek_status">Saya mengkonversi
                                                        {{ $barang->posisi_pi }} ini.
                                                    </label>
                                                </div>
                                                <input type="hidden" name="status_konversi"
                                                    value="{{ $barang->status_konversi }}" id="status_konversi">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="harga_jual" class="text-primary">Harga Jual (Opsional)</label>
                                                <div class="form-check form-switch mb-2">
                                                    <input class="form-check-input" type="checkbox" id="cek_harga_jual"
                                                        {{ $barang->harga_jual > 0 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="cek_harga_jual">Saya menjual
                                                        {{ $barang->posisi_pi }} ini.
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12" id="harga_jual_common">
                                            <div class="form-group">
                                                <input type="text" id="harga_jual" name="harga_jual"
                                                    class="form-control format-rupiah @error('harga_jual') is-invalid @enderror"
                                                    placeholder="Masukkan Harga Jual"
                                                    value="{{ buatrp($barang->harga_jual) }}">
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
