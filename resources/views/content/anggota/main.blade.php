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
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <x-button.master-data-button :routecreate="$routeCreate" :routeimport="$routeImport" :routeexcel="$routeExcel" :routepdf="$routePdf" />
                </div>
                <div class="card-body">
                    <table class="table table-striped dataTable">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Pekerjaan</th>
                                <th>Tempat Tugas</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($anggota as $a)
                                <tr>
                                    <td>{{ $a->kode }}</td>
                                    <td>{{ $a->nama }}</td>
                                    <td>{{ $a->pekerjaan }}</td>
                                    <td>{{ $a->tempat_tugas }}</td>
                                    <td>
                                        <span
                                            class="badge {{ $a->status == 'Aktif' ? 'bg-success' : 'bg-danger' }}">{{ $a->status }}</span>
                                    </td>
                                    <td>
                                        @php
                                            $routeEdit = route('mdu-anggota.edit', $a->id_anggota);
                                            $routeDelete = route('mdu-anggota.destroy', $a->id_anggota);
                                        @endphp
                                        <x-table.action :routeedit="$routeEdit" :routedelete="$routeDelete" />
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align: center">Data Kosong.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
@endsection
