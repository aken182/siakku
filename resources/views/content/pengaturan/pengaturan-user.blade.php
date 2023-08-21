@extends('layouts.contentSidebarLayout')

@section('title', "Pengaturan - $title")

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Pengaturan {{ $title }}</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Pengaturan {{ $title }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content">
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-pills flex-column flex-md-row mb-3">
                        <li class="nav-item">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCenter"
                                type="button">
                                Tambah {{ $title }}
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="row px-4">
                    <div class="col px-4">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <th>Nama User</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Tanggal Aktif</th>
                                        <th>Aksi</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($userData as $field)
                                        <tr data-href="{{ route('pengaturan-user', $field->id) }}">
                                            <td>{{ $field->nama }}</td>
                                            <td>{{ $field->username }}</td>
                                            <td><span class="badge bg-success">{{ $field->status }}</span></td>
                                            <td><span class="badge bg-info">{{ $field->updated_at }}</span></td>
                                            <td>
                                                <x-table.action />
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <form class="modal-content" action="{{ route('pengaturan-user.storeUser') }}" method="post"
        enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="modalCenter" aria-hidden="true" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Tambah {{ $title }}</h5>
                        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label" for="nama">Nama</label>
                                <input
                                    class="form-control
                                     @error('nama') is-invalid @enderror"
                                    id="nama" name="nama" type="text" value="{{ old('nama') }}"
                                    placeholder="ex: John Fernandez">
                                @error('nama')
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
                            <div class="col mb-3">
                                <label class="form-label" for="foto_profil">Foto Profil</label>
                                <input class="form-control @error('foto_profil') is-invalid @enderror" id="foto_profil"
                                    name="foto_profil" type="file" value="{{ old('foto_profil') }}">
                                @error('foto_profil')
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
                                <label class="form-label" for="role">Pilih Role</label>
                                <select
                                    class="form-select @error('role') is-invalid
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

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-secondary" data-bs-dismiss="modal" type="button">Cancel</button>
                        <button class="btn btn-primary" type="submit">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection
