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
                <div class="card-header">
                    <x-button.master-data-button :routecreate="$routeCreate" :routeimport="$routeImport" :routeexcel="$routeExcel" :routepdf="$routePdf" />
                </div>
                <div class="card-body">
                    <input type="hidden" id="routeUrl" data-route="{{ route($routeList) }}" />
                    <table class="table table-hover" id="yajra-datatable">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Jenis</th>
                                <th>TPK</th>
                                <th>Kuantitas</th>
                                <th>Harga</th>
                                @if ($posisi === 'inventaris')
                                    <th>Nilai Buku</th>
                                    <th>Umur Ekonomis</th>
                                @endif
                                <th>Harga Jual</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('pageScript')
    @if ($posisi === 'persediaan')
        <script type="text/javascript" src="{{ asset('assets/admin') }}/js/siakku-custom/datatable-persediaan.js"></script>
    @else
        <script type="text/javascript" src="{{ asset('assets/admin') }}/js/siakku-custom/datatable-inventaris.js"></script>
    @endif
@endsection
