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
                    <div class="row">
                        <div class="col">
                            <a class="btn btn-sm btn-outline-primary" type="button" href="{{ $routeCreate }}">Tambah
                                Data</a>
                            <a class="btn btn-sm btn-outline-success" type="button" href="{{ $routeExcel }}">Export
                                Excel</a>
                            <a class="btn btn-sm btn-outline-danger" type="button" href="{{ $routePdf }}">Export
                                PDF</a>
                            <a class="btn btn-sm btn-outline-success" type="button" href="{{ $routeImport }}">Import
                                Excel</a>
                        </div>
                    </div>
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
                                        <x-table.action />
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
