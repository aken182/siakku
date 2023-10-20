@extends('layouts.contentSidebarLayout')
@section('title', "$title")
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>{{ $title }}</h3>
                    <p class="text-subtitle text-muted text-capitalize">Laporan {{ $title }}</p>
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
                    Form Laporan
                </div>
                <div class="card-body">
                    <form action="" method="get">
                        @csrf
                        <div class="content">
                            <div class="content-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <select class="form-select choices" id="bulan" name="bulan" required>
                                            <option value="" selected>Pilih Bulan</option>
                                            @for ($i = 1; $i <= 12; $i++)
                                                <option value="{{ $i }}">{{ bulan_indonesia($i) }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <select class="form-select choices" id="tahun" name="tahun" required>
                                            <option value="" selected>Pilih Tahun</option>
                                            @for ($i = date('Y'); $i >= date('Y') - 17; $i -= 1)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <button class="btn rounded-pill btn-primary" type="submit">Cari</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <hr class="m-0" style="height: 0.5px" />
                <div class="card-header">
                    {{-- <div style="position: relative;">
                        <a class="btn btn-sm btn-outline-danger" type="button"
                            href="{{ route($route_pdf, ['bulan' => $post['bulan'], 'tahun' => $post['tahun']]) }}"
                            style="position: absolute; top: 0; right: 0;"><span
                                class="tf-icons bx bxs-file-pdf"></span>&nbsp;Download PDF</a>
                    </div> --}}
                    <h6 class="text-center text-uppercase">{{ $title2 }}</h6>
                    <h6 class="text-center text-uppercase">{{ $title }}</h6>
                    <h6 class="text-center text-uppercase">{{ $title3 }}</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover table-bordered tabelLaporan">
                            <thead class="table-success">
                                <tr>
                                    <th rowspan="2">Kode</th>
                                    <th rowspan="2">Nama</th>
                                    <th colspan="2" style="text-align: center">Saldo</th>
                                </tr>
                                <tr>
                                    <th>Debet</th>
                                    <th>Kredit</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @php
                                    $debetSeluruh = 0;
                                    $kreditSeluruh = 0;
                                @endphp
                                @foreach ($kategories as $k)
                                    <tr>
                                        <td class="text-dark"><strong>{{ $k->kategori }}</strong></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    @foreach ($neracas as $neraca)
                                        @if ($k->kategori == $neraca->kategori)
                                            <tr>
                                                <td style="text-align:center">
                                                    <a href="{{ route($routeBukuBesar, ['id_coa' => $neraca->id_coa, 'bulan' => $post['bulan'], 'tahun' => $post['tahun']]) }}"
                                                        class="text-primary" data-bs-toggle="tooltip" data-bs-offset="0,4"
                                                        data-bs-placement="top" data-bs-html="true"
                                                        title="Detail Akun">{{ $neraca->kode }}
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{ route($routeBukuBesar, ['id_coa' => $neraca->id_coa, 'bulan' => $post['bulan'], 'tahun' => $post['tahun']]) }}"
                                                        class="text-primary" data-bs-toggle="tooltip" data-bs-offset="0,4"
                                                        data-bs-placement="top" data-bs-html="true"
                                                        title="Detail Akun">{{ $neraca->nama }}
                                                    </a>
                                                </td>
                                                @if ($neraca->header == 1 || $neraca->header == 4)
                                                    @php
                                                        $totalDebet = $neraca->total_debet - $neraca->total_kredit;
                                                        $debetSeluruh += $totalDebet;
                                                    @endphp
                                                    <td style="text-align:right">{{ buatrp($totalDebet) }}</td>
                                                    <td style="text-align:center">-</td>
                                                @else
                                                    @php
                                                        $totalKredit = $neraca->total_kredit - $neraca->total_debet;
                                                        $kreditSeluruh += $totalKredit;
                                                    @endphp
                                                    <td style="text-align:center">-</td>
                                                    <td style="text-align:right">{{ buatrp($totalKredit) }}</td>
                                                @endif
                                            </tr>
                                        @endif
                                    @endforeach
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2" class="text-primary">Total</td>
                                    <td style="text-align: right" class="text-primary">{{ buatrp($debetSeluruh) }}</td>
                                    <td style="text-align: right" class="text-primary">{{ buatrp($kreditSeluruh) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
