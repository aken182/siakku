@extends('layouts.contentSidebarLayout')
@section('title', "$title")
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>{{ $title }}</h3>
                    <p class="text-subtitle text-muted text-capitalize">{{ $title }} unit {{ $unit }}</p>
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
                    <div class="row mb-3">
                        <label class="text-success text-uppercase"><b>a. Tpk Larantuka</b></label>
                    </div>
                    <x-laporan.gudang.card :konsumsi="$gdg['konsumsiLrtk']" :sandang="$gdg['sandangLrtk']" :kosmetik="$gdg['kosmetikLrtk']" :atm="$gdg['atmLrtk']"
                        :elektronik="$gdg['elektronikLrtk']" :bangunan="$gdg['bangunanLrtk']" :total="$gdg['saldoLrtk']" />
                    <div class="row mb-3">
                        <x-laporan.gudang.table :route="$routeList" :tpk="'lrtk'" />
                    </div>
                    <div class="row mb-3">
                        <label class="text-success text-uppercase"><b>b. Tpk Pasar Baru</b></label>
                    </div>
                    <x-laporan.gudang.card :konsumsi="$gdg['konsumsiPsr']" :sandang="$gdg['sandangPsr']" :kosmetik="$gdg['kosmetikPsr']" :atm="$gdg['atmPsr']"
                        :elektronik="$gdg['elektronikPsr']" :bangunan="$gdg['bangunanPsr']" :total="$gdg['saldoPsr']" />
                    <div class="row mb-3">
                        <x-laporan.gudang.table :route="$routeList" :tpk="'psr'" />
                    </div>
                    <div class="row mb-3">
                        <label class="text-success text-uppercase"><b>c. Tpk Waiwerang</b></label>
                    </div>
                    <x-laporan.gudang.card :konsumsi="$gdg['konsumsiWrg']" :sandang="$gdg['sandangWrg']" :kosmetik="$gdg['kosmetikWrg']" :atm="$gdg['atmWrg']"
                        :elektronik="$gdg['elektronikWrg']" :bangunan="$gdg['bangunanWrg']" :total="$gdg['saldoWrg']" />
                    <div class="row mb-3">
                        <x-laporan.gudang.table :route="$routeList" :tpk="'wrg'" />
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('pageScript')
    <script src="{{ asset('assets/admin') }}/js/siakku-custom/gudang-service.js"></script>
    <script src="{{ asset('assets/admin') }}/js/siakku-service/gudang-datatable.js"></script>
@endsection
