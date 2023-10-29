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
                                <div class="row mb-3">
                                    <div class="col-sm-6 col-md-4 col-lg-4">
                                        <select class="form-select choices" id="id_anggota" name="id_anggota" required>
                                            <option value="" selected>Pilih Anggota</option>
                                            @foreach ($anggota as $item)
                                                <option value="{{ $item->id_anggota }}">{{ $item->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-6 col-md-3 col-lg-3">
                                        <select class="form-select choices" id="tahun" name="tahun" required>
                                            <option value="" selected>Pilih Tahun</option>
                                            @for ($i = date('Y'); $i >= date('Y') - 17; $i -= 1)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-sm-6 col-md-2 col-lg-2">
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
                    <h6 class="text-center text-uppercase text-dark">{{ $title }}</h6>
                    <h6 class="text-center text-uppercase text-dark">{{ $title2 }}</h6>
                    <h6 class="text-center text-uppercase text-dark">Unit {{ $unit }}</h6>
                    <h6 class="text-center text-uppercase text-dark">{{ $title3 }}</h6>
                </div>
                <div class="card-body">
                    @isset($dataAnggota)
                        <div class="row mb-3">
                            <div class="col">
                                <table class="table table-borderless">
                                    <tr>
                                        <td>
                                            <label class="text-dark"><b>Kode Anggota : {{ $dataAnggota->kode }}</b></label>
                                        </td>
                                        <td style="text-align: right">
                                            <label class="text-dark"><b>Alamat : {{ $dataAnggota->tempat_tugas }}</b></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="text-dark"><b>Nama Anggota : {{ $dataAnggota->nama }}</b></label>
                                        </td>
                                        <td style="text-align: right">
                                            <label class="text-dark"><b>Tanggal Masuk :
                                                    {{ date('d-m-Y', strtotime($dataAnggota->tgl_masuk)) }}</b></label>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    @endisset
                    @if ($unit === 'Pertokoan')
                        <x-laporan.simpanan.kartu-toko :tahun="$tahun" :lp="$lp" :tahunlalu="$tahunLalu" />
                    @endif
                    @if ($unit === 'Simpan Pinjam' && $title === 'Laporan Simpanan')
                        <x-laporan.simpanan.simpanan-sp :tahun="$tahun" :lp="$lp" :tahunlalu="$tahunLalu"
                            :hari="$hari" :bulan="$bulan" />
                    @endif
                    @if ($unit === 'Simpan Pinjam' && $title === 'Laporan Simpanan Sukarela Berbunga')
                        <x-laporan.simpanan.simpanan-spb :tahun="$tahun" :lp="$lp" :hari="$hari"
                            :bulan="$bulan" />
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection
