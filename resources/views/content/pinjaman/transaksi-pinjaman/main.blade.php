@extends('layouts.contentSidebarLayout')
@section('title', "$title")
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>{{ $title }}</h3>
                    <p class="text-subtitle text-muted">Daftar Transaksi {{ $title }} unit {{ $unit }}</p>
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
                    <h4 class="card-title">Manajemen {{ $title }}</h4>
                    <div class="btn-group mb-1">
                        <div class="dropdown">
                            <button class="btn btn-outline-primary btn-sm dropdown-toggle me-1" type="button"
                                id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false"><i class="bi bi-plus"></i>Tambah Pinjaman
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="{{ $createBaru }}">Pinjaman Baru</a>
                                <a class="dropdown-item" href="{{ $createPinjamTindis }}">Pinjam Tindis</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <input type="hidden" id="routeUrl" data-route="{{ route($routeList) }}" />
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover main-table">
                                <thead class="table-success">
                                    <tr>
                                        <th>Nomor Transaksi</th>
                                        <th>Tanggal Transaksi</th>
                                        <th>Keterangan</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('pageScript')
    <script src="{{ asset('assets/admin') }}/js/siakku-custom/datatable-main-transaksi.js"></script>
@endsection
