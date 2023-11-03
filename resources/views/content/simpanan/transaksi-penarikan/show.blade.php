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
                                            <td>Nama Simpanan yang Ditarik</td>
                                            <td>: {{ $nama_penarikan }}</td>
                                        </tr>
                                        @if ($jenis_penarikan != 'umum')
                                            <tr>
                                                <td>Jenis Penarikan</td>
                                                <td>:
                                                    {{ $jenis_penarikan === 'sukarela berbunga' ? 'Penarikan Pokok' : 'Penarikan Bunga' }}
                                                </td>
                                            </tr>
                                            @if (isset($bunga))
                                                <tr>
                                                    <td>Bunga Simpanan/bulan</td>
                                                    <td>: {{ buatrp($bunga) }}</td>
                                                </tr>
                                            @endif
                                            @if (isset($ppn))
                                                <tr>
                                                    <td>PPN</td>
                                                    <td>: {{ buatrp($ppn) }}</td>
                                                </tr>
                                            @endif
                                        @endif
                                        <tr>
                                            <td>Jumlah Penarikan</td>
                                            <td>: {{ buatrp($jumlah_penarikan) }}</td>
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
                        <h5 class="text-success">Jurnal Penarikan Simpanan</h5>
                        <div class='table-responsive'>
                            <table class='table table-hover table-bordered'>
                                <thead class='table table-success'>
                                    <tr>
                                        <td>Rekening</td>
                                        <td>Ref</td>
                                        <td>Debet</td>
                                        <td>Kredit</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jurnal as $item)
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
                            <a type="button" href="javascript:history.back()"
                                class="btn btn-light-secondary me-1 mb-1">Kembali</a>
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
                        <img class="img-fluid d-flex mx-auto my-4" src="{{ asset('storage/nota-penarikan/' . $nota) }}"
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
