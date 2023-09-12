@extends('layouts.contentSidebarLayout')
@section('title', 'Anggota')
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Anggota</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Anggota</li>
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
                    <h4>Manajemen Anggota</h4>
                    @php
                        $routeCreate = route('mdu-anggota.create');
                        $routeImport = route('mdu-anggota.form-import');
                        $routeExcel = route('mdu-anggota.export-excel');
                        $routePdf = route('mdu-anggota.export-pdf');
                    @endphp
                    <x-button.master-data-button :routecreate="$routeCreate" :routeimport="$routeImport" :routeexcel="$routeExcel" :routepdf="$routePdf" />
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            {{ $dataTable->table() }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('pageScript')
    {{ $dataTable->scripts() }}
@endsection
