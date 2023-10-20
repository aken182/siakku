@extends('layouts.contentSidebarLayout')
@section('title', "$title")
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>{{ $title }}</h3>
                    <p class="text-subtitle text-muted">Buku Besar Unit {{ $unit }}</p>
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
                <div class="row mb-5">
                    <div class="col-md-12 col-lg-12 mb-3">
                        <div class="card shadow-none border border-grey mb-3">
                            <div class="card-header">
                                Form Buku Besar
                            </div>
                            <div class="card-body">
                                <form action="" method="get">
                                    @csrf
                                    <div class="content">
                                        <div class="content-body">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <select name="id_coa" id="id_coa" class="form-select choices"
                                                        required>
                                                        <option value="">Pilih Akun</option>
                                                        @foreach ($coas as $coa)
                                                            <option value="{{ $coa->id_coa }}">{{ $coa->nama }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-sm-3">
                                                    <select class="form-select choices" name="bulan" id="bulan"
                                                        required>
                                                        <option value="" selected>Pilih Bulan</option>
                                                        @for ($i = 1; $i <= 12; $i++)
                                                            <option value="{{ $i }}">{{ bulan_indonesia($i) }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="col-sm-3">
                                                    <select name="tahun" id="tahun" class="form-select choices"
                                                        required>
                                                        <option value="" selected>Pilih Tahun</option>
                                                        @for ($i = date('Y'); $i >= date('Y') - 17; $i -= 1)
                                                            <option value="{{ $i }}">{{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="col-sm-3">
                                                    <button type="submit"
                                                        class="btn rounded-pill btn-primary">Cari</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <hr class="m-0" style="height: 0.5px" />
                            <div class="card-body">
                                <div class="card-header">
                                    <div style="position: relative;">
                                        <a type="button" class="btn btn-sm btn-outline-danger"
                                            style="position: absolute; top: 0; right: 0;"
                                            href="{{ route($route_pdf, ['bulan' => $post['bulan'], 'tahun' => $post['tahun'], 'id_coa' => $post['id_coa']]) }}"><span
                                                class="tf-icons bx bxs-file-pdf"></span>&nbsp;Download PDF</a>
                                    </div>
                                    <div class="row">
                                        <span class="text-center"><b>{{ $title }}</b></span>
                                    </div>
                                    <div class="row">
                                        <span class="text-center"><b>{{ $title2 }}</b></span>
                                    </div>
                                    <div class="row">
                                        <span class="text-center"><b>{{ $title3 }}</b></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row mb-3">
                                            <div class="col-10">
                                                <table class="table table-borderless">
                                                    <tbody>
                                                        <tr>
                                                            <td><b>Kode</b></td>
                                                            <td><b>: {{ $kode }}</b></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Nama</b></td>
                                                            <td><b>: {{ $nama }}</b></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Kategori</b></td>
                                                            <td><b>: {{ $kategori }}</b></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive text-nowrap">
                                    <table class="table table-striped table-bordered dataTable">
                                        <thead class="table-primary">
                                            <tr>
                                                <th style="text-align:center">Tanggal</th>
                                                <th style="text-align:center">Keterangan</th>
                                                <th style="text-align:center">Ref</th>
                                                <th style="text-align:center">Debet</th>
                                                <th style="text-align:center">Kredit</th>
                                                <th style="text-align:center">Saldo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $total = 0;
                                            @endphp
                                            <tr>
                                                <td></td>
                                                <td><b>Saldo Awal</b></td>
                                                <td style="text-align:center">V</td>
                                                <td></td>
                                                <td></td>
                                                @php
                                                    foreach ($saldo_awal as $saldo) {
                                                        if ($saldo->header == 1 or $saldo->header == 4) {
                                                            $xsaldo = $saldo->total_debet - $saldo->total_kredit;
                                                        } else {
                                                            $xsaldo = $saldo->total_kredit - $saldo->total_debet;
                                                        }
                                                        $total += $xsaldo;
                                                    }
                                                @endphp
                                                <td style="text-align:right"><b>{{ buatrp($total) }}</b></td>
                                            </tr>
                                            @foreach ($buku_besar as $value)
                                                <tr>
                                                    <td style="text-align:center">
                                                        {{ date('d/m/Y', strtotime($value->transaksi->tgl_transaksi)) }}
                                                    </td>
                                                    <td><a href="{{ route($route_detail, ['id' => Crypt::encrypt($value->transaksi->id_transaksi), 'detail' => $value->transaksi->jenis_transaksi, 'unit' => $value->transaksi->unit]) }}"class="{{ $value->transaksi->tipe == 'kadaluwarsa' ? 'text-danger' : 'text-primary' }}"
                                                            data-bs-toggle="tooltip" data-bs-offset="0,4"
                                                            data-bs-placement="top" data-bs-html="true"
                                                            title="<i class='bx bx-show bx-xs' ></i> <span>{{ $value->transaksi->tipe == 'kadaluwarsa' ? 'Detail Transaksi Kadaluwarsa' : 'Detail Transaksi' }}</span>">{{ $value->transaksi->keterangan }}</a>
                                                    </td>
                                                    <td style="text-align:center">{{ $value->coa->kode }}</td>
                                                    @if ($value->posisi_dr_cr == 'debet')
                                                        <td style="text-align:right">{{ buatrp($value->nominal) }}</td>
                                                        <td style="text-align:right">-</td>
                                                    @else
                                                        <td style="text-align:right">-</td>
                                                        <td style="text-align:right">{{ buatrp($value->nominal) }}</td>
                                                    @endif
                                                    @if ($value->posisi_dr_cr == 'debet')
                                                        @if ($value->coa->header == 1 or $value->coa->header == 4)
                                                            @php
                                                                $total = $total + $value->nominal;
                                                            @endphp
                                                            <td style="text-align:right">{{ buatrp($total) }}</td>
                                                        @else
                                                            @php
                                                                $total = $total - $value->nominal;
                                                            @endphp
                                                            <td style="text-align:right">{{ buatrp($total) }}</td>
                                                        @endif
                                                    @else
                                                        @if ($value->coa->header == 1 or $value->coa->header == 4)
                                                            @php
                                                                $total = $total - $value->nominal;
                                                            @endphp
                                                            <td style="text-align:right">{{ buatrp($total) }}</td>
                                                        @else
                                                            @php
                                                                $total = $total + $value->nominal;
                                                            @endphp
                                                            <td style="text-align:right">{{ buatrp($total) }}</td>
                                                        @endif
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td></td>
                                                <td><b>Saldo Akhir</b></td>
                                                <td style="text-align:center">V</td>
                                                <td></td>
                                                <td></td>
                                                <td style="text-align:right"><b>{{ buatrp($total) }}</b></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
