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
                    <h4 class="card-title">History Penjualan</h4>
                    <x-button.master-data-button :routecreate="$routeCreate" :createtitle="$createTitle" :createetitle="$createTitle2" :routecreatee="$routeCreate2" />
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Tanggal</th>
                                        <th>Transaksi</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @forelse ($pendapatans as $pendapatan)
                                        <tr>
                                            <td>
                                                <a class="{{ $pendapatan['tipe'] == 'kadaluwarsa' ? 'text-danger' : 'text-primary' }}"
                                                    data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top"
                                                    data-bs-html="true"
                                                    href="{{ route($routeDetailPendapatan, ['id' => Crypt::encrypt($pendapatan['id_transaksi']), 'detail' => $pendapatan['detail_tabel']]) }}"
                                                    title="<i class='bx bx-show bx-xs' ></i> <span>
                                                        {{ $pendapatan['tipe'] == 'kadaluwarsa' ? 'Detail Transaksi Kadaluwarsa' : 'Detail Transaksi' }}
                                                    </span>">
                                                    {{ $pendapatan['kode'] }}
                                                </a>
                                            </td>
                                            <td>{{ date('d-m-Y', strtotime($pendapatan['tgl_transaksi'])) }}</td>
                                            <td>{{ $pendapatan['keterangan'] }}</td>
                                            @if ($pendapatan['tipe'] == 'kadaluwarsa')
                                                <td class="text-danger text-capitalize">kadaluwarsa</td>
                                            @else
                                                @if ($pendapatan['status'] != 'lunas')
                                                    <td class="text-capitalize">
                                                        <a class="text-warning" data-bs-toggle="tooltip"
                                                            data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true"
                                                            href="{{ route('ptk-penjualan.create-pelunasan', ['detail_tabel' => $pendapatan['detail_tabel'], 'unit' => $unit]) }}"
                                                            title="<i class='bx bx-show bx-xs' ></i> <span>Lunasi Piutang !</span>">{{ $pendapatan['status'] }}</a>
                                                    </td>
                                                @else
                                                    <td class="text-capitalize">
                                                        <a class="text-success" data-bs-toggle="tooltip"
                                                            data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true"
                                                            href="{{ route('ptk-penjualan.show', ['id' => Crypt::encrypt($pendapatan['id_transaksi']), 'detail' => $pendapatan['detail_tabel']]) }}"
                                                            title="<i class='bx bx-show bx-xs' ></i> <span>Detail Transaksi</span>">
                                                            {{ $pendapatan['status'] }}
                                                        </a>
                                                    </td>
                                                @endif
                                            @endif
                                            <td style="text-align: right">{{ buatrp($pendapatan['total']) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td style="text-align: center" colspan="5">Data Kosong.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col">
                                    <div class="demo-inline-spacing">
                                        <nav aria-label="Page navigation">
                                            {!! $pendapatans->links() !!}
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
