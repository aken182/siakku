@extends('layouts.contentSidebarLayout')
@section('title', "$title")
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>{{ $title }}</h3>
                    <p class="text-subtitle text-muted">{{ $title . ' Unit ' . $unit }}</p>
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
                <div class="card-header text-uppercase">
                    {{-- <div style="position: relative;">
                        <a class="btn btn-sm btn-outline-danger" type="button"
                            href="{{ route($route_pdf, ['bulan' => $post['bulan'], 'tahun' => $post['tahun']]) }}"
                            style="position: absolute; top: 0; right: 0;"><span
                                class="tf-icons bx bxs-file-pdf"></span>&nbsp;Download PDF</a>
                    </div> --}}
                    <h6 class="text-center">{{ $title }}</h6>
                    <h6 class="text-center">{{ $title2 }}</h6>
                    <h6 class="text-center">{{ $title3 }}</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col">
                            <div class="table-responsive">
                                <input type="hidden" id="route-list" data-route="{{ route($routeList) }}" />
                                <table class="table table-bordered table-hover" id="aktiva-table">
                                    <thead class="table-success">
                                        <tr>
                                            <th rowspan="2">No.</th>
                                            <th rowspan="2">Nama Barang</th>
                                            <th rowspan="2">Jenis Barang</th>
                                            <th rowspan="2">Jumlah Barang</th>
                                            <th rowspan="2">Tahun Pembelian</th>
                                            <th colspan="2" style="text-align: center">Harga Perolehan</th>
                                            <th rowspan="2">Total Perolehan</th>
                                            <th colspan="2" style="text-align: center">Penyusutan</th>
                                            <th rowspan="2">Total Penyusutan</th>
                                            <th rowspan="2">Nilai Buku</th>
                                            <th rowspan="2">Masa Manfaat</th>
                                        </tr>
                                        <tr>
                                            <th>TH.SBL</th>
                                            <th>TH.BJLN</th>
                                            <th>TH.SBL</th>
                                            <th>TH.BJLN</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('pageScript')
    <script src="{{ asset('assets/admin') }}/js/siakku-custom/aktiva-table.js"></script>
@endsection
