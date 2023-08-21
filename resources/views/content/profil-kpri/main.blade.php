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
                    <h4 class="card-title">Data Koperasi</h4>
                    <a type="button" href="{{ route('profil-koperasi.edit', $profil->id) }}"
                        class="btn btn-sm btn-outline-primary">Edit</a>
                </div>
                <div class="card-body">
                    <div class="table table-responsive">
                        <x-table.profil-koperasi :profil="$profil" />
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
