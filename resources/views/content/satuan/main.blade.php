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
                    <x-button.master-data-button :routecreate="$routeCreate" :routeimport="$routeImport" :routeexcel="$routeExcel" :routepdf="$routePdf" />
                </div>
                <div class="card-body">
                    <table class="table table-striped dataTable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Satuan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @forelse ($satuan as $a)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $a->nama_satuan }}</td>
                                    <td>
                                        @php
                                            $routeEdit = route('mdu-satuan.edit', $a->id_satuan);
                                            $routeDelete = route('mdu-satuan.destroy', $a->id_satuan);
                                        @endphp
                                        <x-table.action :routeedit="$routeEdit" :routedelete="$routeDelete" />
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" style="text-align: center">Data Kosong.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
@endsection
