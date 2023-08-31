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
                                <form class="form" action="{{ route('mdu-coa.update', $coa->id_coa) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="card shadow-none bg-transparent border border-primary">
                                                <div class="card-body">
                                                    <small>
                                                        <p>Berikut Klasifikasi Header Akun COA:</p>
                                                        <table class="table table-hover table-bordered">
                                                            <thead class="table-secondary">
                                                                <tr>
                                                                    <th>Nama</th>
                                                                    <th>Header</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Akun Harta (Asset)</td>
                                                                    <td>1</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Akun Modal</td>
                                                                    <td>2</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Akun Kewajiban (Hutang)</td>
                                                                    <td>3</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Akun Beban (Biaya)</td>
                                                                    <td>4</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Harga Pokok Penjualan</td>
                                                                    <td>5</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Pendapatan</td>
                                                                    <td>8</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="header" class="text-primary">Header Akun</label><br>
                                                <div class="form-check form-check-inline mt-3">
                                                    <input class="form-check-input @error('header') is-invalid @enderror"
                                                        type="radio" name="header" id="header1" value="1"
                                                        {{ $coa->header == '1' ? 'checked' : '' }} />
                                                    <label class="form-check-label" for="header1">1</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input @error('header') is-invalid @enderror"
                                                        type="radio" name="header" id="header2" value="2"
                                                        {{ $coa->header == '2' ? 'checked' : '' }} />
                                                    <label class="form-check-label" for="header2">2</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input @error('header') is-invalid @enderror"
                                                        type="radio" name="header" id="header3" value="3"
                                                        {{ $coa->header == '3' ? 'checked' : '' }} />
                                                    <label class="form-check-label" for="header3">3</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input @error('header') is-invalid @enderror"
                                                        type="radio" name="header" id="header4" value="4"
                                                        {{ $coa->header == '4' ? 'checked' : '' }} />
                                                    <label class="form-check-label" for="header4">4</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input @error('header') is-invalid @enderror"
                                                        type="radio" name="header" id="header5" value="5"
                                                        {{ $coa->header == '5' ? 'checked' : '' }} />
                                                    <label class="form-check-label" for="header5">5</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input @error('header') is-invalid @enderror"
                                                        type="radio" name="header" id="header8" value="8"
                                                        {{ $coa->header == '8' ? 'checked' : '' }} />
                                                    <label class="form-check-label" for="header8">8</label>
                                                    @error('header')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="kode" class="text-primary">Kode Akun</label>
                                                <input type="text" name="kode"
                                                    class="form-control @error('kode') is-invalid @enderror"
                                                    placeholder="Masukkan Kode Akun" value="{{ $coa->kode }}">
                                                @error('kode')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="nama" class="text-primary">Nama Akun</label>
                                                <input type="text" name="nama"
                                                    class="form-control @error('nama') is-invalid @enderror"
                                                    placeholder="Masukkan Nama Akun" value="{{ $coa->nama }}">
                                                @error('nama')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="kategori" class="text-primary">Kategori</label>
                                                <select name="kategori"
                                                    class="choices form-select @error('kategori') is-invalid @enderror">
                                                    <option value="{{ $coa->kategori }}" selected>{{ $coa->kategori }}
                                                    </option>
                                                    <option value="Aktiva Lancar">Aktiva Lancar</option>
                                                    <option value="Aktiva Tetap">Aktiva Tetap</option>
                                                    <option value="Penyertaan">Penyertaan</option>
                                                    <option value="Passiva Lancar">Passiva Lancar</option>
                                                    <option value="Modal Sendiri">Modal Sendiri</option>
                                                    <option value="Pendapatan">Pendapatan</option>
                                                    <option value="Biaya">Biaya</option>
                                                </select>
                                                @error('kategori')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="subkategori" class="text-primary">Sub Kategori
                                                    (Opsional)</label>
                                                <select name="subkategori"
                                                    class="choices form-select @error('subkategori') is-invalid @enderror">
                                                    <option value="{{ $coa->subkategori }}" selected>
                                                        {{ $coa->subkategori }}</option>
                                                    <option value="Kas & Bank">Kas & Bank</option>
                                                    <option value="Piutang">Piutang</option>
                                                    <option value="Penjualan Barang">Penjualan Barang</option>
                                                    <option value="Pendapatan Bunga">Pendapatan Bunga</option>
                                                    <option value="Pendapatan Lainnya">Pendapatan Lainnya</option>
                                                    <option value="Biaya Langsung">Biaya Langsung</option>
                                                    <option value="Biaya Tidak Langsung">Biaya Tidak Langsung</option>
                                                    <option value="Simpanan">Simpanan</option>
                                                    <option value="Dana SHU">Dana SHU</option>
                                                    <option value="HPP">HPP</option>
                                                </select>
                                                @error('subkategori')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                            <a type="button" href="{{ route('mdu-coa') }}"
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
