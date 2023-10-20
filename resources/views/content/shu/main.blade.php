@extends('layouts.contentSidebarLayout')
@section('title', "$title")
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>{{ $title }}</h3>
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
                    <h5 class="card-title">Unit {{ $unit }}</h5>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link {{ $tipe == 'master' ? 'active' : '' }}" href="{{ $routeMaster }}"
                                role="tab">Master
                                SHU</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link {{ $tipe == 'transaksi' ? 'active' : '' }}" href="{{ $routeTransaksi }}"
                                role="tab">Pembagian SHU</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade {{ $tipe == 'master' ? 'show active' : '' }}" role="tabpanel">
                            @if ($tipe === 'master')
                                <div class="row mt-3 mb-3">
                                    <h6>Manajemen Master SHU</h6>
                                </div>
                                <div class="row mt-3 mb-3">
                                    <x-button.master-data-button :routecreate="$routeCreate" :routeimport="$routeImport" />
                                </div>
                                <div class="row">
                                    <x-shu.table-master class="table-master" :shu="$shu" :routee="$routeEdit"
                                        :routed="$routeDelete" />
                                </div>
                            @endif
                        </div>
                        <div class="tab-pane fade {{ $tipe == 'transaksi' ? 'show active' : '' }}" role="tabpanel">
                            @if ($tipe === 'transaksi')
                                <div class="row mt-3 mb-3">
                                    <h6>Manajemen Pembagian SHU</h6>
                                </div>
                                <div class="row mt-3 mb-3">
                                    <x-button.master-data-button :routecreate="$routeCreate" :createtitle="$createTitle" :modal="$modal" />
                                </div>
                                <div class="row">
                                    <x-data-table.transaksi :route="$routeList" />
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @if ($tipe === 'transaksi')
        <x-shu.modal-info-shu :estimasi="$estimasi" :route="$routeGrafik" :unit="$unit" />
    @endif
@endsection
@section('pageScript')
    @if ($tipe === 'transaksi')
        <script src="{{ asset('assets/admin') }}/js/siakku-custom/datatable-transaksi.js"></script>
        <script src="{{ asset('assets/admin') }}/vendors/apexcharts/apexcharts.js"></script>
        <script src="{{ asset('assets/admin') }}/js/siakku-custom/grafik-estimasi-shu.js"></script>
    @endif
@endsection
