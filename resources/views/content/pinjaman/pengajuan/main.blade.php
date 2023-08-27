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
                                <th>Jumlah Pengajuan</th>
                                <th>Status</th>
                                <th>Tanggal Acc</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pengajuan as $a)
                                <tr>
                                    <td>{{ $a->kode }}</td>
                                    <td>{{ $a->anggota->nama }}</td>
                                    <td>{{ buatrp($a->jumlah_pinjaman) }}</td>
                                    <td class="text-capitalize">
                                        @if ($a->status === 'belum acc')
                                            <form action="{{ route('pp-pengajuan.konfirmasi', $a->id_pengajuan) }}"
                                                method="post">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="acc">
                                                <input type="hidden" name="status_pencairan" value="belum cair">
                                                <button type="submit" class="btn btn-sm btn-success"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Klik tombol ini untuk Acc Pengajuan!">Konfirmasi !</button>
                                            </form>
                                        @else
                                            <span
                                                class="badge {{ $a->status_pencairan == 'sudah cair' ? 'bg-success' : 'bg-warning' }}">
                                                {{ $a->status_pencairan }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge {{ $a->tgl_acc == null ? 'bg-danger' : 'bg-success' }}">
                                            {{ $a->tgl_acc == null ? 'Belum Acc' : date('d-m-Y', strtotime($a->tgl_acc)) }}
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            $routeEdit = route('pp-pengajuan.edit', $a->id_pengajuan);
                                            $routeDelete = route('pp-pengajuan.destroy', $a->id_pengajuan);
                                            $routeShow = route('pp-pengajuan.show', $a->id_pengajuan);
                                        @endphp
                                        <x-table.action :routeedit="$routeEdit" :routedelete="$routeDelete" :routeshow="$routeShow" />
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
