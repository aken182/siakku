@extends('layouts.contentSidebarLayout')

@section('title', "Pengaturan - $title")
{{-- <link href="assets/vendor/fonts/boxicons1.css" rel="stylesheet" /> --}}

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
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#modalCenter" type="button">
                                Tambah {{ $title }}
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead class="table-success">
                                        <tr>
                                            <th>No.</th>
                                            <th>Role</th>
                                            <th>Keterangan</th>
                                            <th style="text-align: center">Tanggal Aktif</th>
                                            <th style="text-align: center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($roleData as $field)
                                            <tr>
                                                <td>{{ $no++ . '.' }}</td>
                                                <td>{{ $field->name }}</td>
                                                <td>{{ $field->description }}</td>
                                                <td style="text-align: center"><span
                                                        class="badge bg-info">{{ $field->updated_at }}</span></td>
                                                <td style="text-align: center">
                                                    @php
                                                        $routeDelete = route($routeDlt, $field->id);
                                                        $routeEdit = route($routeEdt, $field->id);
                                                    @endphp
                                                    <x-table.action :routeedit="$routeEdit" :routedelete="$routeDelete" />
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- Modal Form input create hak akses-->
    <form class="modal-content" action="{{ route('pengaturan-otoritas.store') }}" method="post">
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
                                <label class="form-label" for="name">Nama</label>
                                <input
                                    class="form-control
                                     @error('name') is-invalid @enderror"
                                    id="name" name="name" type="text" value="{{ old('name') }}"
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
                                    name="description" type="text" value="{{ old('description') }}"
                                    placeholder="ex: Admin Unit Simpan Pinjam">
                                @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
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

    <!-- Basic Layout -->
@endsection
