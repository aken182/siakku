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
        <section id="multiple-column-form">
            <div class="card">
                <form class="card-body" action="{{ route($routeUpdate, $role->id) }}" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="row">
                        <div class="col mb-3">
                            <label class="form-label" for="name">Nama</label>
                            <input class="form-control
                                 @error('name') is-invalid @enderror"
                                id="name" name="name" type="text" value="{{ $role->name }}"
                                placeholder="ex: admin-unit-simpan-pinjam">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label class="form-label" for="description">Keterangan</label>
                            <input class="form-control @error('description') is-invalid @enderror" id="description"
                                name="description" type="text" value="{{ $role->description }}"
                                placeholder="ex: Admin Unit Simpan Pinjam">
                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary me-1 mb-1">Simpan</button>
                            <a type="button" href="{{ route('pengaturan-otoritas') }}"
                                class="btn btn-light-secondary me-1 mb-1">Keluar</a>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
