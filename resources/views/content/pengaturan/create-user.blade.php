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
                <form class="card-body" action="{{ route($routeStore) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Nama</label>
                            <select name="id_anggota" id="id_anggota"
                                class="form-select selectpicker w-50 @error('id_anggota') is-invalid @enderror"
                                data-style="text-dark" data-live-search="true">
                                <option value="" selected>Masukkan Nama Anggota</option>
                                @foreach ($anggota as $a)
                                    <option value="{{ $a->id_anggota }}">{{ $a->nama }}</option>
                                @endforeach
                            </select>
                            @error('id_anggota')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label class="form-label" for="username">Username</label>
                            <input class="form-control @error('username') is-invalid @enderror" id="username"
                                name="username" type="text" value="{{ old('username') }}" placeholder="ex: John12">
                            @error('username')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-password-toggle">
                            <label class="form-label" for="basic-default-password12">Password</label>
                            <div class="input-group">
                                <input class="form-control @error('password') is-invalid @enderror" id="password"
                                    name="password" type="password" aria-describedby="basic-default-password2"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                <span class="input-group-text cursor-pointer" id="basic-default-password2"><i
                                        class="bx bx-hide"></i></span>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label class="form-label" for="role">Role</label>
                            <select
                                class="form-select choices @error('role') is-invalid
                            @enderror"
                                name="role">
                                <option selected>Pilih Role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach

                            </select>
                            @error('role')
                                <div class="invalid-feedback"> {{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary me-1 mb-1">Simpan</button>
                            <a type="button" href="{{ route('pengaturan-user') }}"
                                class="btn btn-light-secondary me-1 mb-1">Keluar</a>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>

@endsection
