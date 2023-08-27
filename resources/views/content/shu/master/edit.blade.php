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
                                <form class="form" action="{{ route($routeUpdate, $shu->id_shu) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="text-primary">Nama Alokasi</label>
                                                <input type="text"
                                                    class="form-control @error('nama') is-invalid @enderror"
                                                    placeholder="Masukkan nama alokasi dana." value="{{ $shu->nama }}"
                                                    name="nama">
                                                @error('nama')
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                                <input type="hidden" name="unit" value="{{ $shu->unit }}" />
                                                <input type="hidden" name="nilai_bagi" value="{{ $shu->nilai_bagi }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <label class="text-primary">Persentase</label>
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="input-group mb-3">
                                                        <input type="number" step="0.25" class="form-control"
                                                            placeholder="ex.30" value="{{ $shu->persen }}" name="persen">
                                                        <span
                                                            class="input-group-text @error('persen') is-invalid @enderror">%</span>
                                                        @error('persen')
                                                            <span class="invalid-feedback" role="alert">
                                                                {{ $message }}
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                            <a type="button" href="{{ $routeMaster }}"
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
