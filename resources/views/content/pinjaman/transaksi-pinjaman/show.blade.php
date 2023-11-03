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
                        @if (isset($d->transaksi->tipe))
                            <div class="ribbon ribbon-top-right">
                                @if ($d->status == 'belum lunas')
                                    <span class="text-capitalize"
                                        style="background-color:{{ $d->transaksi->tipe == 'kadaluwarsa' ? '#ff3e1d' : 'darkgoldenrod' }} ">{{ $d->transaksi->tipe == 'kadaluwarsa' ? 'kadaluwarsa' : $d->status }}
                                    </span>
                                @else
                                    <span class="text-capitalize"
                                        style="background-color:{{ $d->transaksi->tipe == 'kadaluwarsa' ? '#ff3e1d' : 'forestgreen' }} ">{{ $d->transaksi->tipe == 'kadaluwarsa' ? 'kadaluwarsa' : $d->status }}
                                    </span>
                                @endif
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
                                        <h6 class="text-light" style="text-align: right">#{{ $d->transaksi->kode }}
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
                                            {{ $d->transaksi->no_bukti }}</small>
                                    </td>
                                </tr>
                                @if (isset($d->transaksi->tgl_transaksi))
                                    <tr>
                                        <td>
                                            <small class="text-dark">Tanggal Transaksi</small>
                                        </td>
                                        <td>
                                            <small class="text-dark text-capitalize"> :
                                                {{ date('d-m-Y', strtotime($d->transaksi->tgl_transaksi)) }}</small>
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
                    @if (isset($d->transaksi->kode_pny))
                        <div class="row mb-2">
                            <small
                                class="text-primary"><b><i>{{ $d->transaksi->tipe === 'penyesuaian' ? 'Penyesuaian Transaksi ' . $d->transaksi->kode_pny : '' }}</b></i>
                            </small>
                        </div>
                    @endif
                    <div class='row mb-2 pb-1'>
                        <h5 class='text-capitalize text-success'>Detil Pinjaman</h5>
                        <div class='col-lg-12 col-md-12'>
                            <table class='table table-borderless'>
                                <tr>
                                    <td>Nama Anggota</td>
                                    <td class='text-capitalize text-dark' style='text-align: right'>
                                        {{ $d->anggota->nama }}</td>
                                </tr>
                                <tr>
                                    <td>Tempat Tugas</td>
                                    <td class='text-capitalize text-dark' style='text-align: right'>
                                        {{ $d->anggota->tempat_tugas }}</td>
                                </tr>
                                <tr>
                                    <td>Total Pinjaman</td>
                                    <td style='text-align: right' class='text-dark'>{{ cek_uang($d->total_pinjaman) }}</td>
                                </tr>
                                @isset($d->pinjam_tindis)
                                    <tr>
                                        <td>Penambahan Pinjaman</td>
                                        <td style='text-align: right' class='text-dark'>{{ cek_uang($d->pinjam_tindis) }}</td>
                                    </tr>
                                @endisset
                                <tr>
                                    <td>Saldo Pokok</td>
                                    <td style='text-align: right' class='text-dark'>{{ cek_uang($d->saldo_pokok) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Saldo Bunga</td>
                                    <td style='text-align: right' class='text-dark'>{{ cek_uang($d->saldo_bunga) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Keterangan</td>
                                    <td class='text-capitalize text-dark' style='text-align: right'>
                                        {{ $d->transaksi->keterangan }}</td>
                                </tr>
                                <tr>
                                    <td>Nota Transaksi</td>
                                    <td class='text-capitalize text-dark' style='text-align: right'><button type="button"
                                            class="btn btn-sm btn-outline-info" data-bs-toggle="modal"
                                            data-bs-target="#modalScrollable">Lihat Nota
                                            Transaksi</button></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <p class='text-success'><strong>Jurnal Pinjaman:</strong></p>
                            <table class='table table-striped table-bordered mb-1'>
                                <thead class='table table-success'>
                                    <tr>
                                        <td>Rekening</td>
                                        <td>Ref</td>
                                        <td>Debet</td>
                                        <td>Kredit</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jurnal as $j)
                                        <tr>
                                            @if ($j->posisi_dr_cr === 'debet')
                                                <td>{{ $j->coa->nama }}</td>
                                                <td style='text-align:center'>{{ $j->coa->kode }}</td>
                                                <td style='text-align:right'>{{ cek_uang($j->nominal) }}</td>
                                                <td style='text-align:center'>-</td>
                                            @else
                                                <td>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $j->coa->nama }}
                                                </td>
                                                <td style='text-align:center'>{{ $j->coa->kode }}</td>
                                                <td style='text-align:center'>-</td>
                                                <td style='text-align:right'>{{ cek_uang($j->nominal) }}</td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @isset($d->pinjam_tindis)
                        <div class="row mb-3">
                            <div class="col">
                                <h6 class='text-success'>Detail Pinjam Tindis</h6>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="table-secondary text-dark">
                                            <tr>
                                                <th>Kode Pinjaman</th>
                                                <th>Tanggal Pinjam</th>
                                                <th>Keterangan</th>
                                                <th>Besar Pinjaman</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pinjamtindis as $p)
                                                <tr>
                                                    <td><a href="/pinjaman/unit-sp/show-angsuran/{{ Crypt::encrypt($p->transaksi->id_transaksi) }}"
                                                            class="{{ $p->transaksi->tipe == 'kadaluwarsa' ? 'text-danger' : 'text-primary' }}"
                                                            data-bs-toggle="tooltip" data-bs-offset="0,4"
                                                            data-bs-placement="top" data-bs-html="true"
                                                            title="<i class='bi bi-show' ></i> <span>{{ $p->transaksi->tipe == 'kadaluwarsa' ? 'Detil Pinjaman Kadaluwarsa' : 'Detil Pinjaman' }}</span>">{{ $p->transaksi->kode }}</a>
                                                    </td>
                                                    <td>{{ date('d-m-Y', strtotime($p->transaksi->tgl_transaksi)) }}</td>
                                                    <td class="text-capitalize">{{ $p->transaksi->keterangan }}</td>
                                                    <td style="text-align:right"
                                                        class="{{ $p->transaksi->tipe == 'kadaluwarsa' ? 'text-danger' : '' }}">
                                                        {{ $p->transaksi->tipe == 'kadaluwarsa' ? 'Kadaluwarsa' : buatrp($p->besar_pinjaman) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endisset
                    <div class="row mb-3">
                        <div class="col">
                            <h6 class='text-success'>Detail Pembayaran Pinjaman</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover dataTable">
                                    <thead class="table-secondary text-dark">
                                        <tr>
                                            <th>Kode Bayar</th>
                                            <th>Tanggal Bayar</th>
                                            <th>Keterangan</th>
                                            <th>Angsuran Pokok</th>
                                            <th>Angsuran Bunga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pembayaran as $p)
                                            <tr>
                                                <td><a href="/pinjaman/unit-sp/show-angsuran/{{ Crypt::encrypt($p->transaksi->id_transaksi) }}"
                                                        class="{{ $p->transaksi->tipe == 'kadaluwarsa' ? 'text-danger' : 'text-primary' }}"
                                                        data-bs-toggle="tooltip" data-bs-offset="0,4"
                                                        data-bs-placement="top" data-bs-html="true"
                                                        title="<i class='bi bi-show' ></i> <span>{{ $p->transaksi->tipe == 'kadaluwarsa' ? 'Detil Pembayaran Kadaluwarsa' : 'Detil Pembayaran' }}</span>">{{ $p->transaksi->kode }}</a>
                                                </td>
                                                <td>{{ date('d-m-Y', strtotime($p->transaksi->tgl_transaksi)) }}</td>
                                                <td class="text-capitalize">{{ $p->transaksi->keterangan }}</td>
                                                <td style="text-align:right"
                                                    class="{{ $p->transaksi->tipe == 'kadaluwarsa' ? 'text-danger' : '' }}">
                                                    {{ $p->transaksi->tipe == 'kadaluwarsa' ? 'Kadaluwarsa' : buatrp($p->angsuran_pokok) }}
                                                </td>
                                                <td style="text-align:right"
                                                    class="{{ $p->transaksi->tipe == 'kadaluwarsa' ? 'text-danger' : '' }}">
                                                    {{ $p->transaksi->tipe == 'kadaluwarsa' ? 'Kadaluwarsa' : buatrp($p->angsuran_bunga) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
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
                        <h6 class="card-subtitle text-muted">{{ $d->transaksi->nota_transaksi }}</h6>
                        <img class="img-fluid d-flex mx-auto my-4"
                            src="{{ asset('storage/nota-pinjaman/' . $d->transaksi->nota_transaksi) }}"
                            alt="Card image cap">
                        <p class="card-text text-capitalize">{{ $d->transaksi->keterangan }}</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Keluar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
