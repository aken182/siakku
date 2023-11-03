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
                            <a class="btn btn-sm btn-outline-primary" href="{{ route($routeCreate) }}" type="button">
                                Tambah {{ $title }}
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="row px-4">
                    <div class="col px-4">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-success">
                                    <tr>
                                        <th style="text-align: center">No.</th>
                                        <th>Nama User</th>
                                        <th>Username</th>
                                        <th>Role</th>
                                        {{-- <th>Status</th> --}}
                                        <th>Tanggal Aktif</th>
                                        <th>Aksi</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($userData as $field)
                                        <tr>
                                            <td style="text-align: center">{{ $no++ . '.' }}</td>
                                            <td>{{ $field->nama }}</td>
                                            <td>{{ $field->username }}</td>
                                            <td class="text-capitalize">
                                                @foreach ($userHasRoles as $item)
                                                    @if ($item->model_id === $field->id)
                                                        {{ str_replace('-', ' ', $item->roles->name) }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            {{-- <td><span class="badge bg-success">{{ $field->status }}</span></td> --}}
                                            <td><span class="badge bg-info">{{ $field->updated_at }}</span></td>
                                            <td>
                                                @php
                                                    $routeDelete = route($routeDestroy, $field->id);
                                                    $routeEdt = route($routeEdit, Crypt::encrypt($field->id));
                                                @endphp
                                                <x-table.action :routeedit="$routeEdt" :routedelete="$routeDelete" />
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

@endsection
