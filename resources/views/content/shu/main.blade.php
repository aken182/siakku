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
                                    <x-button.master-data-button :routecreate="$routeCreate" :routeimport="$routeImport" />
                                </div>
                                <div class="row">
                                    <x-shu.table-master class="table-master" :shu="$shu" :routee="$routeEdit"
                                        :routed="$routeDelete" />
                                </div>
                            @endif
                        </div>
                        <div class="tab-pane fade {{ $tipe == 'transaksi' ? 'show active' : '' }}" role="tabpanel">
                            Integer interdum diam eleifend metus lacinia, quis
                            gravida eros mollis. Fusce non sapien sit amet magna
                            dapibus ultrices. Morbi tincidunt magna ex, eget
                            faucibus sapien bibendum non. Duis a mauris ex. Ut
                            finibus risus sed massa mattis porta. Aliquam sagittis
                            massa et purus efficitur ultricies. Integer pretium
                            dolor at sapien laoreet ultricies. Fusce congue et lorem
                            id convallis. Nulla volutpat tellus nec molestie
                            finibus. In nec odio tincidunt eros finibus ullamcorper.
                            Ut sodales, dui nec posuere finibus, nisl sem aliquam
                            metus, eu accumsan lacus felis at odio. Sed lacus quam,
                            convallis quis condimentum ut, accumsan congue massa.
                            Pellentesque et quam vel massa pretium ullamcorper vitae
                            eu tortor.
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
