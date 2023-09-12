@extends('layouts.contentSidebarLayout')
@section('title', "$title")
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>{{ $title }}</h3>
                    <p class="text-subtitle text-muted">Daftar Transaksi Penjualan unit {{ $unit }}</p>
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
                    <h4 class="card-title">Manajemen Penjualan</h4>
                    <x-button.master-data-button :routecreate="$routeCreate" :createtitle="$createTitle" :createetitle="$createTitle2" :routecreatee="$routeCreate2" />
                </div>
                <div class="card-body">
                    <div class="row">
                        <input type="hidden" id="routeUrl" data-route="{{ route($routeList) }}" />
                        <table class="table table-bordered table-hover penjualan-table">
                            <thead class="table-primary">
                                <tr>
                                    <th>Nomor</th>
                                    <th>Tanggal</th>
                                    <th>Keterangan</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('pageScript')
    <script src="{{ asset('assets/admin') }}/js/siakku-custom/datatable-penjualan.js"></script>
@endsection
