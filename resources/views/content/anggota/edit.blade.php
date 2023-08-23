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
                                <form class="form" action="{{ route('mdu-anggota.update', $anggota->id_anggota) }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PATCH')
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="text-primary">Nama Anggota</label>
                                                <input type="text"
                                                    class="form-control @error('nama') is-invalid @enderror"
                                                    placeholder="Masukkan nama lengkap." value="{{ $anggota->nama }}"
                                                    name="nama">
                                                @error('nama')
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="text-primary">No. Induk (Opsional)</label>
                                                <input type="text"
                                                    class="form-control @error('no_induk') is-invalid @enderror"
                                                    placeholder="Masukkan no.induk."value="{{ $anggota->no_induk }}"
                                                    name="no_induk">
                                                @error('no_induk')
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="text-primary">Tempat Lahir (Opsional)</label>
                                                <input type="text"
                                                    class="form-control @error('tempat_lahir') is-invalid @enderror"
                                                    placeholder="Masukkan tempat lahir."
                                                    value="{{ $anggota->tempat_lahir }}" name="tempat_lahir">
                                                @error('tempat_lahir')
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="text-primary">Tanggal Lahir (Opsional)</label>
                                                <input type="date"
                                                    class="form-control @error('tgl_lahir') is-invalid @enderror"
                                                    placeholder="Masukkan tanggal lahir." value="{{ $anggota->tgl_lahir }}"
                                                    name="tgl_lahir">
                                                @error('tgl_lahir')
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="text-primary">Jenis Kelamin</label>
                                                <select name="jenis_kelamin"
                                                    class="form-select @error('jenis_kelamin') is-invalid @enderror">
                                                    <option value="{{ $anggota->jenis_kelamin }}" selected>
                                                        {{ $anggota->jenis_kelamin }}</option>
                                                    <option value="Laki-laki">Laki-laki</option>
                                                    <option value="Perempuan">Perempuan</option>
                                                </select>
                                                @error('jenis_kelamin')
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="text-primary">Pekerjaan</label>
                                                <input type="text"
                                                    class="form-control @error('pekerjaan') is-invalid @enderror"
                                                    placeholder="Masukkan pekerjaan." value="{{ $anggota->pekerjaan }}"
                                                    name="pekerjaan">
                                                @error('pekerjaan')
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="text-primary">Tempat Tugas</label>
                                                <input type="text"
                                                    class="form-control @error('tempat_tugas') is-invalid @enderror"
                                                    placeholder="Masukkan tempat tugas."
                                                    value="{{ $anggota->tempat_tugas }}" name="tempat_tugas">
                                                @error('tempat_tugas')
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="text-primary">Status</label>
                                                <select name="status"
                                                    class="form-select @error('status') is-invalid @enderror">
                                                    <option value="{{ $anggota->status }}" selected>
                                                        {{ $anggota->status }}</option>
                                                    <option value="Aktif">Aktif</option>
                                                    <option value="Tidak Aktif">Tidak Aktif</option>
                                                </select>
                                                @error('status')
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="text-primary">Level</label>
                                                <select name="level"
                                                    class="form-select @error('level') is-invalid @enderror">
                                                    <option value="{{ $anggota->level }}" selected>{{ $anggota->level }}
                                                    </option>
                                                    <option value="Karyawan">Karyawan</option>
                                                    <option value="Anggota">Anggota</option>
                                                </select>
                                                @error('level')
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="text-primary">Tanggal Masuk</label>
                                                <input type="date"
                                                    class="form-control @error('tgl_masuk') is-invalid @enderror"
                                                    placeholder="Masukkan Tanggal masuk."
                                                    value="{{ $anggota->tgl_masuk }}" name="tgl_masuk">
                                                @error('tgl_masuk')
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="text-primary">Tanggal Berhenti (Opsional)</label>
                                                <input type="date" class="form-control"
                                                    placeholder="Masukkan tanggal berhenti."
                                                    value="{{ $anggota->tgl_berhenti }}" name="tgl_berhenti">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="text-primary">Alasan Berhenti (Opsional)</label>
                                                <input type="text" class="form-control"
                                                    placeholder="Masukkan alasan berhenti."
                                                    value="{{ $anggota->alasan_berhenti }}" name="alasan_berhenti">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="text-primary">Pas Foto (Opsional)</label>
                                                <input type="file" class="form-control" id="inputGroupFile04"
                                                    aria-describedby="inputGroupFileAddon04" name="file_foto"
                                                    aria-label="Upload">
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                            <a type="button" href="{{ route('mdu-anggota') }}"
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
