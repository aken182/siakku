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
                <div class="row mb-5">
                    <div class="col-md-12 col-lg-12 mb-3">
                        <div class="card shadow-none border border-grey mb-3">
                            <div class="card-header">
                                Form Jurnal
                            </div>
                            <div class="card-body">
                                <form action="" method="get">
                                    @csrf
                                    <div class="content">
                                        <div class="content-body">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <select class="form-select choices" name="bulan" id="bulan"
                                                        required>
                                                        <option value="" selected>Pilih Bulan</option>
                                                        @for ($i = 1; $i <= 12; $i++)
                                                            <option value="{{ $i }}">{{ bulan_indonesia($i) }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="col-sm-4">
                                                    <select name="tahun" id="tahun" class="form-select choices"
                                                        required>
                                                        <option value="" selected>Pilih Tahun</option>
                                                        @for ($i = date('Y'); $i >= date('Y') - 17; $i -= 1)
                                                            <option value="{{ $i }}">{{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="col-sm-4">
                                                    <button type="submit"
                                                        class="btn rounded-pill btn-outline-primary">Cari</button>
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
                                            href="{{ route($route_pdf, ['bulan' => $post['bulan'], 'tahun' => $post['tahun']]) }}"><span
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
                                <div class="table-responsive">
                                    <table class="table table-hover dataTable">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Nomor</th>
                                                <th>Rekening</th>
                                                <th>Ref</th>
                                                <th>Debet</th>
                                                <th>Kredit</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">
                                            @foreach ($jurnals as $jurnal)
                                                <tr>
                                                    <td>{{ date('d/m/Y', strtotime($jurnal->transaksi->tgl_transaksi)) }}
                                                    </td>
                                                    @if ($jurnal->posisi_dr_cr == 'debet')
                                                        <td>
                                                            <a href="{{ route($route_detail, ['id' => Crypt::encrypt($jurnal->transaksi->id_transaksi), 'detail' => $jurnal->transaksi->detail_tabel, 'unit' => $jurnal->transaksi->unit]) }}"
                                                                class="{{ $jurnal->transaksi->tipe == 'kadaluwarsa' ? 'text-danger' : 'text-primary' }}"
                                                                data-bs-toggle="tooltip" data-bs-offset="0,4"
                                                                data-bs-placement="top" data-bs-html="true"
                                                                title="<i class='bx bx-show bx-xs' ></i> <span>{{ $jurnal->transaksi->tipe == 'kadaluwarsa' ? 'Detail Transaksi Kadaluwarsa' : 'Detail Transaksi' }}</span>">{{ $jurnal->transaksi->kode }}
                                                            </a>
                                                        </td>
                                                        <td>{{ $jurnal->coa->nama }}</td>
                                                        <td>{{ $jurnal->coa->kode }}</td>
                                                        <td style="text-align:right">{{ buatrp($jurnal->nominal) }}</td>
                                                        <td>-</td>
                                                    @else
                                                        <td><a href="{{ route($route_detail, ['id' => Crypt::encrypt($jurnal->transaksi->id_transaksi), 'detail' => $jurnal->transaksi->detail_tabel, 'unit' => $jurnal->transaksi->unit]) }}"
                                                                class="{{ $jurnal->transaksi->tipe == 'kadaluwarsa' ? 'text-danger' : 'text-primary' }}"
                                                                data-bs-toggle="tooltip" data-bs-offset="0,4"
                                                                data-bs-placement="top" data-bs-html="true"
                                                                title="<i class='bx bx-show bx-xs' ></i> <span>{{ $jurnal->transaksi->tipe == 'kadaluwarsa' ? 'Detail Transaksi Kadaluwarsa' : 'Detail Transaksi' }}</span>">{{ $jurnal->transaksi->kode }}</a>
                                                        </td>
                                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $jurnal->coa->nama }}
                                                        </td>
                                                        <td>{{ $jurnal->coa->kode }}</td>
                                                        <td>-</td>
                                                        <td style="text-align:right">{{ buatrp($jurnal->nominal) }}</td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot class="table-primary">
                                            <tr>
                                                <th colspan="4" class="text-dark">Total</th>
                                                <th style="text-align: right" class="text-dark">
                                                    {{ buatrp($debet_seluruh) }}</th>
                                                <th style="text-align: right" class="text-dark">
                                                    {{ buatrp($kredit_seluruh) }}</th>
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

{{-- @section('pageScript')

@endsection --}}
