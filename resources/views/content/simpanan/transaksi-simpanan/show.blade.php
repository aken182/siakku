@extends('layouts.contentSidebarLayout')
@section('title', "$title")
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>{{ $title }}</h3>
                    <p class="text-subtitle text-muted">Detail Transaksi {{ $title }} Unit {{ $unit }}</p>
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
                    <div class="card bg-gradient-ltr">
                        @if (isset($tipe))
                            <div class="ribbon ribbon-top-right">
                                <span class="text-capitalize"
                                    style="background-color:{{ $tipe == 'kadaluwarsa' ? '#ff3e1d' : 'forestgreen' }} ">{{ $tipe === 'kadaluwarsa' ? 'kadaluwarsa' : 'Lunas' }}
                                </span>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-6">
                                <img src="{{ asset('assets/admin') }}/images/logo/logo-kpri.png" width="350px">
                            </div>
                            <div class="col-md-5 d-flex justify-content-end">
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <h3 class="text-light" style="text-align: right">{{ $title }}</h3>
                                    </div>
                                    <div class="col-12">
                                        <h6 class="text-light" style="text-align: right">#{{ $invoice }}
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                    </div>
                    <div class="row m-0">
                        <div class="col-6">
                            <small class="text-dark"> Kel. Puken Tobi Wangi Bao, Larantuka<br>
                                Flores Timur, Nusa Tenggara Timur. <br>Kode Pos : 86218
                            </small>
                        </div>
                        <div class="col-6 d-flex justify-content-end">
                            <table class="text-bold">
                                <tr>
                                    <td>
                                        <small class="text-dark">No. Bukti</small>
                                    </td>
                                    <td>
                                        <small class="text-dark text-capitalize"> :
                                            {{ $no_bukti }}</small>
                                    </td>
                                </tr>
                                @if (isset($tanggal))
                                    <tr>
                                        <td>
                                            <small class="text-dark">Tanggal Transaksi</small>
                                        </td>
                                        <td>
                                            <small class="text-dark text-capitalize"> :
                                                {{ date('d-m-Y', strtotime($tanggal)) }}</small>
                                        </td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                    <hr class="border border-primary m-0">
                    <hr class="border border-primary m-0">
                    <hr class="border border-primary m-0">
                    <hr class="border border-primary m-0">
                </div>
                <div class="card-body">
                    @if (isset($invoicePny))
                        <div class="row mb-2">
                            <small
                                class="text-primary"><b><i>{{ $tipe === 'penyesuaian' ? 'Penyesuaian Transaksi ' . $invoicePny : '' }}</b></i>
                            </small>
                        </div>
                    @endif
                    <div class="row mb-3">
                        <div class="col-md-7 col-xl-7 col-lg-7">
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table table-borderless text-dark">
                                        <tr>
                                            <td>Nama Anggota</td>
                                            <td>: {{ $nama }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tempat Tugas</td>
                                            <td>: {{ $alamat }}</td>
                                        </tr>
                                        <tr>
                                            <td>Keterangan</td>
                                            <td>: {{ $keterangan }}</td>
                                        </tr>
                                        <tr>
                                            <td>Nota Transaksi</td>
                                            <td>
                                                <div>:
                                                    <button type="button" class="btn btn-sm btn-outline-info"
                                                        data-bs-toggle="modal" data-bs-target="#modalScrollable">
                                                        Lihat Nota Transaksi
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <h5 class="text-success">Detail Setoran</h5>
                        <div class="table-responsive">
                            <table class="table table-flush-spacing-sm table-bordered">
                                <thead class="table-success text-dark">
                                    <tr>
                                        <th style="text-align: center">No.</th>
                                        <th>Nama Simpanan</th>
                                        @if ($jenis === 'sukarela berbunga')
                                            <th>Bunga Simpanan</th>
                                        @endif
                                        <th>Jumlah Setoran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($transaksis as $transaksi)
                                        <tr>
                                            <td style="text-align: center">{{ $no++ . '.' }}</td>
                                            @if (isset($transaksi->id_simpanan))
                                                <td>{{ $transaksi->simpanan->nama }}</td>
                                            @else
                                                <td>
                                                    {{ $jenis === 'umum' ? 'Simpanan Khusus Pertokoan' : 'Simpanan Sukarela Berbunga' }}
                                                </td>
                                            @endif
                                            @if ($jenis === 'sukarela berbunga')
                                                <td style="text-align:right">{{ buatrp($transaksi->bunga) }}</td>
                                            @endif
                                            <td style="text-align:right">{{ buatrp($transaksi->jumlah) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="{{ $jenis === 'sukarela berbunga' ? '3' : '2' }}"
                                            style="text-align: left;">
                                            <h5 style="font-weight:bold">Total</h5>
                                        </td>
                                        <td style="text-align: right;">
                                            <h5 style="font-weight:bold">{{ buatrp($total) }}</h5>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 d-flex justify-content-end">
                            <a type="button" href="{{ route($routeMain) }}"
                                class="btn btn-light-secondary me-1 mb-1">Keluar</a>
                            <a type="button" href="#" class="btn btn-primary me-1 mb-1">Download</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="modal fade" id="modalScrollable" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalScrollableTitle">Nota {{ $title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <h6 class="card-subtitle text-muted">{{ $nota }}</h6>
                        <img class="img-fluid d-flex mx-auto my-4" src="{{ asset('storage/nota-simpanan/' . $nota) }}"
                            alt="Card image cap">
                        <p class="card-text">{{ $keterangan }}</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Keluar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
