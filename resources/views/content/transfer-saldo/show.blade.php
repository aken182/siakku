@extends('layouts.contentSidebarLayout')
@section('title', "$title")
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>{{ $title }}</h3>
                    <p class="text-subtitle text-muted">Detail Transaksi Unit {{ $unit }}</p>
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
                        @if (isset($details->transaksi->tipe))
                            <div class="ribbon ribbon-top-right">
                                <span class="text-capitalize"
                                    style="background-color: {{ $details->transaksi->tipe == 'kadaluwarsa' ? 'red' : 'forestgreen' }} ">
                                    {{ $details->transaksi->tipe == 'kadaluwarsa' ? 'Kadaluwarsa' : 'Lunas' }}
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
                                        <h6 class="text-light" style="text-align: right">#{{ $details->transaksi->kode }}
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
                                            {{ $details->transaksi->no_bukti }}</small>
                                    </td>
                                </tr>
                                @if (isset($details->transaksi->tgl_transaksi))
                                    <tr>
                                        <td>
                                            <small class="text-dark">Tanggal Transaksi</small>
                                        </td>
                                        <td>
                                            <small class="text-dark text-capitalize"> :
                                                {{ date('d-m-Y', strtotime($details->transaksi->tgl_transaksi)) }}</small>
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
                    @if (isset($details->transaksi->kode_pny))
                        <div class="row mb-2">
                            <small
                                class="text-primary"><b><i>{{ $details->transaksi->tipe === 'penyesuaian' ? 'Penyesuaian Transaksi ' . $details->transaksi->kode_pny : '' }}</b></i>
                            </small>
                        </div>
                    @endif
                    <div class='row mb-2 pb-1'>
                        <div class='col-lg-8 col-md-6'>
                            <table class='table table-borderless'>
                                <tr>
                                    <td>Pemindahan Dari</td>
                                    <td class='text-capitalize text-dark' style='text-align: right'>
                                        {{ $details->pengirim->nama }}</td>
                                </tr>
                                <tr>
                                    <td>Pemindahan Kepada</td>
                                    <td class='text-capitalize text-dark' style='text-align: right'>
                                        {{ $details->penerima->nama }}</td>
                                </tr>
                                <tr>
                                    <td>Jumlah Pemindahan Saldo</td>
                                    <td class='text-capitalize text-dark' style='text-align: right'>
                                        {{ cek_uang($details->transaksi->total) }}</td>
                                </tr>
                                <tr>
                                    <td>Keterangan</td>
                                    <td class='text-capitalize text-dark' style='text-align: right'>
                                        {{ $details->transaksi->keterangan }}</td>
                                </tr>
                                <tr>
                                    <td>Nota Transaksi</td>
                                    <td class='text-capitalize text-dark' style='text-align: right'>
                                        <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal"
                                            data-bs-target="#modalScrollable">
                                            Lihat Nota Transaksi
                                        </button>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class='row mb-2 pb-1 bg-theme-dark'>
                        <p class="text-success"><strong>Jurnal Pemindahan Saldo:</strong></p>
                        <div class='table-responsive text-nowrap pb-4'>
                            <table class='table table-striped table-bordered mb-1'>
                                <thead class='table table-primary'>
                                    <tr>
                                        <td>Rekening</td>
                                        <td>Ref</td>
                                        <td>Debet</td>
                                        <td>Kredit</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jurnals as $item)
                                        <tr>
                                            @if ($item->posisi_dr_cr === 'debet')
                                                <td>{{ $item->coa->nama }}</td>
                                                <td style='text-align:center'>{{ $item->coa->kode }}</td>
                                                <td style='text-align:right'>{{ cek_uang($item->nominal) }}</td>
                                                <td style='text-align:center'>-</td>
                                            @else
                                                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $item->coa->nama }}
                                                </td>
                                                <td style='text-align:center'>{{ $item->coa->kode }}</td>
                                                <td style='text-align:center'>-</td>
                                                <td style='text-align:right'>{{ cek_uang($item->nominal) }}</td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
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
                        <h6 class="card-subtitle text-muted">{{ $details->transaksi->nota_transaksi }}</h6>
                        <img class="img-fluid d-flex mx-auto my-4"
                            src="{{ asset('storage/nota-transfer-saldo/' . $details->transaksi->nota_transaksi) }}"
                            alt="Card image cap">
                        <p class="card-text">{{ $details->transaksi->keterangan }}</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Keluar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
