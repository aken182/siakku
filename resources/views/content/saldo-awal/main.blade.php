@extends('layouts.contentSidebarLayout')
@section('title', "$title")
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3 class="text-capitalize">{{ $title }}</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item active text-capitalize" aria-current="page">{{ $title }}</li>
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
                    <h4 class="card-title">Unit {{ $unit }}</h4>
                </div>
                <div class="card-body">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link {{ $active != 'import' ? 'active text-primary' : 'text-secondary' }}"
                                href="{{ route($routeMain) }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $active === 'import' ? 'active text-primary' : 'text-secondary' }}"
                                href="#">Import
                                Saldo Awal</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $childTitle }}</h4>
                </div>
                <div class="card-body">
                    @switch($active)
                        @case('home')
                            @if ($jenis === 'coa')
                                <x-saldo-awal.views.saldo-awal :transaksi="$transaksi" :edit="$routeEdit" />
                            @else
                                <x-saldo-awal.views.saldo-awal-barang :transaksi="$transaksi" :edit="$routeEdit" :jenis="$jenis" />
                            @endif
                        @break

                        @case('form-tanggal')
                            <x-saldo-awal.form.create-tanggal-mulai :store="$routeStore" />
                        @break

                        @case('create')
                            <x-saldo-awal.form.create-main-transaksi :coa="$coa" :barang="$barang" :jenis="$jenis"
                                :main="$routeMain" :store="$routeStore" :tanggal="$tgl_transaksi" :satuan="$satuan" :unit="$unitBarang" />
                        @break

                        @case('edit')
                            @php
                                $coa = $coa ?? '';
                                $barang = $barang ?? '';
                                $unitBarang = $unitBarang ?? '';
                                $satuan = $satuan ?? '';
                                $detail = $detail ?? '';
                                $debet = $totalDebet ?? '';
                                $kredit = $totalKredit ?? '';
                            @endphp
                            <x-saldo-awal.form.edit-main-transaksi :coa="$coa" :jenis="$jenis" :main="$routeMain"
                                :barang="$barang" :unit="$unitBarang" :satuan="$satuan" :detail="$detail" :store="$routeStore"
                                :kredit="$kredit" :debet="$debet" :tanggal="$tgl_transaksi" :idtransaksi="$id_transaksi" />
                        @break

                        @case('import')
                            <x-saldo-awal.views.saldo-awal />
                        @break

                        @default
                    @endswitch
                </div>
            </div>
        </section>
    </div>
@endsection
