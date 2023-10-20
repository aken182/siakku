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
                                            @for ($i = 2024; $i >= 2024 - 17; $i -= 1)
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
                    <h6 class="text-center text-uppercase">{{ $title4 }}</h6>
                </div>
                <div class="card-body">
                    @if ($unit === 'Pertokoan')
                        <x-laporan.laba-rugi.pertokoan :lap="$laporan" :bulanini="$namaBulanIni" :tahun="$tahun"
                            :bulanlalu="$namaBulanLalu" />
                    @endif
                    @if ($unit === 'Simpan Pinjam')
                        <x-laporan.laba-rugi.simpan-pinjam :lap="$laporan" :bulanlalu="$namaBulanLalu" :bulanini="$namaBulanIni"
                            :tahun="$tahun" />
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection
