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
                                <form class="form" action="{{ route('mdu-berita.update', $berita->id_berita) }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PATCH')
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-primary">Tanggal Berita</label>
                                                <input type="date"
                                                    class="form-control @error('tgl_berita') is-invalid @enderror"
                                                    placeholder="Masukkan tanggal berita." value="{{ $berita->tgl_berita }}"
                                                    name="tgl_berita">
                                                @error('tgl_berita')
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-primary">Judul Berita</label>
                                                <input type="text"
                                                    class="form-control @error('judul_berita') is-invalid @enderror"
                                                    placeholder="Masukkan judul berita." value="{{ $berita->judul_berita }}"
                                                    name="judul_berita">
                                                @error('judul_berita')
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                                <input type="hidden" class="form-control"
                                                    value="{{ $berita->slug_berita }}" name="slug" readonly>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-primary">Isi Berita</label>
                                                <textarea name="isi_berita" id="defaultNews" cols="30"
                                                    class="form-control @error('isi_berita') is-invalid @enderror" rows="10">{{ $berita->isi_berita }}</textarea>
                                                @error('isi_berita')
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-primary">Nama Penulis</label>
                                                <input type="text" value="{{ $berita->penulis }}"
                                                    class="form-control @error('penulis') is-invalid @enderror"
                                                    placeholder="Masukkan nama penulis." name="penulis">
                                                @error('penulis')
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-primary">Gambar Berita</label>
                                                <input type="file"
                                                    class="form-control @error('file_gambar') is-invalid @enderror"
                                                    id="inputGroupFile04" aria-describedby="inputGroupFileAddon04"
                                                    name="file_gambar" aria-label="Upload">
                                                @error('file_gambar')
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                            <a type="button" href="{{ route('mdu-berita') }}"
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
