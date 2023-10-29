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
                                    <div class="col-sm-6">
                                        <select class="form-select choices" id="id_pinjaman" name="id_pinjaman" required>
                                            <option value="" selected>Pilih Data Pinjaman</option>
                                            @foreach ($pinjaman as $p)
                                                <option value="{{ $p->id_pinjaman }}">
                                                    {{ $p->transaksi->kode . ' - ' . $p->anggota->nama . ' - ' . buatrp($p->total_pinjaman) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <select class="form-select choices" id="tahun" name="tahun" required>
                                            <option value="" selected>Pilih Tahun</option>
                                            @for ($i = date('Y'); $i >= date('Y') - 17; $i -= 1)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
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
                    <h6 class="text-center text-uppercase">{{ $title }}</h6>
                    <h6 class="text-center text-uppercase">{{ $title2 }}</h6>
                    <h6 class="text-center text-uppercase">Unit {{ $unit }}</h6>
                    <h6 class="text-center text-uppercase">{{ $title3 }}</h6>
                </div>
                <div class="card-body">
                    @isset($dataAnggota)
                        <div class="row mb-3">
                            <div class="col">
                                <table class="table table-borderless">
                                    <tr>
                                        <td>
                                            <label class="text-dark"><b>Kode Anggota : {{ $dataAnggota['kode'] }}</b></label>
                                        </td>
                                        <td style="text-align: right">
                                            <label class="text-dark"><b>Total Pinjaman :
                                                    {{ cek_uang($dataAnggota['total_pinjaman']) }}</b></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="text-dark"><b>Nama Anggota : {{ $dataAnggota['nama'] }}</b></label>
                                        </td>
                                        <td style="text-align: right">
                                            <label class="text-dark"><b>Tanggal Pinjam :
                                                    {{ date('d-m-Y', strtotime($dataAnggota['tgl_pinjam'])) }}</b></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="text-dark"><b>Alamat : {{ $dataAnggota['alamat'] }}</b></label>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    @endisset
                    <div class="row mb-3">
                        <div class="col">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-success">
                                        <tr>
                                            <th rowspan="2" style="text-align:center">TANGGAL</th>
                                            <th rowspan="2" style="text-align:center">NOMOR BUKTI</th>
                                            <th rowspan="2" style="text-align:center">BESARNYA PINJAMAN</th>
                                            <th colspan="2" style="text-align:center">ANGSURAN PINJAMAN</th>
                                            <th colspan="2" style="text-align:center">SALDO PINJAMAN</th>
                                        </tr>
                                        <tr>
                                            <th style="text-align:center">POKOK</th>
                                            <th style="text-align:center">BUNGA</th>
                                            <th style="text-align:center">POKOK</th>
                                            <th style="text-align:center">BUNGA</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="5"><b>SALDO AWAL PER 31 DESEMBER {{ $tahunLalu }}</b></td>
                                            <td style="text-align:right"><b>{{ cek_uang($lp['saldoAwalPokok']) }}</b></td>
                                            <td style="text-align:right"><b>{{ cek_uang($lp['saldoAwalBunga']) }}</b></td>
                                        </tr>
                                        @forelse ($lp['utama'] as $item)
                                            <tr>
                                                <td style="text-align: center">
                                                    {{ date('d-m-Y', strtotime($item['tgl_transaksi'])) }}
                                                </td>
                                                <td style="text-align: center">{{ $item['no_bukti'] }}</td>
                                                <td style="text-align: right">{{ cek_uang($item['besar_pinjaman']) }}</td>
                                                <td style="text-align: right">{{ cek_uang($item['angsuran_pokok']) }}</td>
                                                <td style="text-align: right">{{ cek_uang($item['angsuran_bunga']) }}</td>
                                                <td style="text-align: right">{{ cek_uang($item['saldo_pokok']) }}</td>
                                                <td style="text-align: right">{{ cek_uang($item['saldo_bunga']) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" style="text-align: center">Data Kosong !</td>
                                            </tr>
                                        @endforelse
                                        <tr>
                                            <td colspan="5">
                                                <b class="text-uppercase">SALDO AKHIR PER
                                                    {{ "$hari $namaBulanIni $tahun" }}</b>
                                            </td>
                                            <td style="text-align:right"><b>{{ cek_uang($lp['saldoAkhirPokok']) }}</b>
                                            </td>
                                            <td style="text-align:right"><b>{{ cek_uang($lp['saldoAkhirBunga']) }}</b>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
