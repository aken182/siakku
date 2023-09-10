@extends('layouts.contentSidebarLayout')
@section('title', "$title")
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>{{ $title }}</h3>
                    <p class="text-subtitle text-muted">Daftar Transaksi Unit {{ $unit }}</p>
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
                    <h4 class="card-title">History Transaksi</h4>
                    <x-button.master-data-button :routecreate="$routeCreate" />
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <th>No.Transaksi</th>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th>Jumlah</th>
                            </thead>
                            <tbody>
                                @forelse ($transaksi as $item)
                                    <tr>
                                        <td><a href="{{ route($routeShow, Crypt::encrypt($item->id_transaksi)) }}"
                                                class="{{ $item->tipe == 'kadaluwarsa' ? 'text-danger' : 'text-primary' }}"
                                                data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top"
                                                data-bs-html="true"
                                                title="<i class='bx bx-show bx-xs' ></i> <span>{{ $item->tipe == 'kadaluwarsa' ? 'Detail Transaksi Kadaluwarsa' : 'Detail Transaksi' }}</span>">{{ $item->kode }}</a>
                                        </td>
                                        <td>{{ date('d-m-Y', strtotime($item->tgl_transaksi)) }}</td>
                                        <td>{{ $item->keterangan }}</td>
                                        <td style="text-align: right">{{ buatrp($item->total) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" style="text-align: center">Data Kosong.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col">
                                <div class="demo-inline-spacing">
                                    <nav aria-label="Page navigation">
                                        {{ $transaksi->WithQueryString()->links() }}
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
