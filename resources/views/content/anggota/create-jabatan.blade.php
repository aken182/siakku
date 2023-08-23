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
                                <form class="form" action="{{ route('mdu-jabatan.store') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="text-primary">Nama Anggota</label>
                                                <select name="id_anggota"
                                                    class="choices form-select @error('id_anggota') is-invalid @enderror">
                                                    <option value="" selected>Pilih Anggota</option>
                                                    @foreach ($anggota as $a)
                                                        <option value="{{ $a->id_anggota }}">{{ $a->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('id_anggota')
                                                    <span class="invalid-feedback">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="text-primary">Jabatan</label>
                                                <select name="jabatan"
                                                    class="choices form-select @error('jabatan') is-invalid @enderror">
                                                    <option value="" selected>Pilih</option>
                                                    <option value="Bendahara">Bendahara</option>
                                                    <option value="Ketua">Ketua</option>
                                                    <option value="Manajer">Manajer</option>
                                                    <option value="Sekretaris">Sekretaris</option>
                                                </select>
                                                @error('jabatan')
                                                    <span class="invalid-feedback">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="text-primary">Status</label>
                                                <select name="status"
                                                    class="choices form-select @error('status') is-invalid @enderror">
                                                    <option value="" selected>Pilih</option>
                                                    <option value="Aktif">Aktif</option>
                                                    <option value="Tidak Aktif">Tidak Aktif</option>
                                                </select>
                                                @error('status')
                                                    <span class="invalid-feedback">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                            <a type="button" href="{{ route('mdu-jabatan') }}"
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
