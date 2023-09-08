@extends('layouts.contentSidebarLayout')
@section('title', "$title")
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>{{ $title }}</h3>
                    <p class="text-subtitle text-muted">A pretty helpful component for give message to user</p>
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
                    <div class="table-responsive">
                        <table class="table table-hover dataTable">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Jenis</th>
                                    <th>TPK</th>
                                    <th>Kuantitas</th>
                                    <th>Harga Satuan</th>
                                    @if ($posisi === 'inventaris')
                                        <th>Nilai Buku</th>
                                        <th>Umur Ekonomis</th>
                                    @endif
                                    <th>Harga Jual/Satuan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($barang as $a)
                                    <tr>
                                        <td>{{ $a->kode_barang }}</td>
                                        <td>{{ $a->nama_barang }}</td>
                                        <td>{{ $a->jenis_barang }}</td>
                                        <td>{{ $a->unit->nama }}</td>
                                        @if ($a->stok == null || $a->stok == 0)
                                            <td><span class="badge bg-danger">Stok kosong !</span></td>
                                        @else
                                            <td>{{ $a->stok . ' ' . $a->satuan->nama_satuan }}</td>
                                        @endif
                                        <td>{{ cek_uang($a->harga_barang) . '/' . $a->satuan->nama_satuan }}</td>
                                        @if ($posisi === 'inventaris')
                                            <td>{{ cek_uang($a->nilai_saat_ini) . '/' . $a->satuan->nama_satuan }}</td>
                                            <td>{{ $a->umur_ekonomis }} tahun</td>
                                        @endif
                                        <td>{{ cek_uang($a->harga_jual) . '/' . $a->satuan->nama_satuan }}</td>
                                        <td>
                                            @php
                                                $routee = route($routeEdit, $a->id_barang);
                                                $routed = route($routeDelete, $a->id_barang);
                                            @endphp
                                            <x-table.action :routeedit="$routee" :routedelete="$routed" />
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ $posisi === 'inventaris' ? '10' : '8' }}"
                                            style="text-align: center">
                                            Data Kosong.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
