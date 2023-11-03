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
                    <div class="card bg-gradient-ltr">
                        @if (isset($pengajuan->status_pencairan))
                            <div class="ribbon ribbon-top-right">
                                <span class="text-capitalize"
                                    style="background-color: {{ $pengajuan->status_pencairan == 'sudah cair' ? 'forestgreen' : 'goldenrod' }} ">{{ $pengajuan->status_pencairan }}
                                </span>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-6">
                                <img src="{{ asset('assets/admin') }}/images/logo/logo-kpri.png" width="350px">
                            </div>
                            <div class="col-md-5 d-flex justify-content-end">
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <h3 class="text-light" style="text-align: right">Pengajuan Pinjaman</h3>
                                    </div>
                                    <div class="col-12">
                                        <h6 class="text-light" style="text-align: right">#{{ $pengajuan->kode }}</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                    </div>
                    <div class="row m-0">
                        <div class="col-6">
                            <small class="text-dark"> Kel. Puken Tobi Wangi Bao, Larantuka<br>
                                Flores Timur, Nusa Tenggara Timur. <br>Kode Pos : 86218
                            </small>
                        </div>
                        <div class="col-6 d-flex justify-content-end">
                            <table class="text-bold">
                                @if (isset($pengajuan->tgl_acc))
                                    <tr>
                                        <td>
                                            <small class="text-dark">Tanggal Acc</small>
                                        </td>
                                        <td>
                                            <small class="text-dark text-capitalize"> :
                                                {{ date('d-m-Y', strtotime($pengajuan->tgl_acc)) }}</small>
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td>
                                        <small class="text-dark">Persetujuan</small>
                                    </td>
                                    <td>
                                        <small class="text-dark text-capitalize"> :
                                            {{ $pengajuan->status }}</small>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <hr class="border border-primary m-0">
                    <hr class="border border-primary m-0">
                    <hr class="border border-primary m-0">
                    <hr class="border border-primary m-0">
                </div>
                <div class="card-body">
                    <div class="row mb-2 text-dark">
                        <p>Nama Pengaju : {{ $pengajuan->anggota->nama }}</p>
                        <p>Tempat Tugas : {{ $pengajuan->anggota->tempat_tugas }}</p>
                    </div>
                    @if (isset($pengajuan->keterangan))
                        <div class="row text-dark">
                            <div class="col-md-6 col-sm-12 col-lg-6">
                                <p>Keterangan :</p>
                                <p>{{ $pengajuan->keterangan }}</p>
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="row">
                                <h5>Detail Kemampuan Angsuran</h5>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead class="bg-secondary text-light">
                                                <tr>
                                                    <th>Keterangan</th>
                                                    <th>Nominal</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-dark text-capitalize">
                                                <tr>
                                                    <td>Gaji perbulan</td>
                                                    <td style="text-align: right">{{ cek_uang($pengajuan->gaji_perbulan) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Potongan rutin perbulan</td>
                                                    <td style="text-align: right">
                                                        {{ cek_uang($pengajuan->potongan_perbulan) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Cicilan lain perbulan</td>
                                                    <td style="text-align: right">
                                                        {{ cek_uang($pengajuan->cicilan_perbulan) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Biaya hidup perbulan</td>
                                                    <td style="text-align: right">
                                                        {{ cek_uang($pengajuan->biaya_perbulan) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Sisa penghasilan perbulan</td>
                                                    <td style="text-align: right">
                                                        {{ cek_uang($pengajuan->sisa_penghasilan) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Persentase kempuan bayar</td>
                                                    <td style="text-align: right">{{ $pengajuan->perkiraan . '%' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-capitalize"><b>Kemampuan bayar pinjaman perbulan</b>
                                                    </td>
                                                    <td style="text-align: right">
                                                        <b>{{ cek_uang($pengajuan->kemampuan_bayar) }}</b>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="row">
                                <h5>Detail Pengajuan</h5>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead class="bg-secondary text-light">
                                                <tr>
                                                    <th>Keterangan</th>
                                                    <th>Nominal</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-dark text-capitalize">
                                                <tr>
                                                    <td><b>Jumlah pengajuan pinjaman</b></td>
                                                    <td style="text-align: right">
                                                        <b>{{ cek_uang($pengajuan->jumlah_pinjaman) }}</b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Jangka waktu</td>
                                                    <td style="text-align: right">
                                                        {{ $pengajuan->jangka_waktu . ' bulan' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Bunga</td>
                                                    <td style="text-align: right">
                                                        {{ $pengajuan->bunga . ' %' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Asuransi</td>
                                                    <td style="text-align: right">
                                                        {{ cek_uang($pengajuan->asuransi) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Kapitalisasi</td>
                                                    <td style="text-align: right">
                                                        {{ cek_uang($pengajuan->kapitalisasi) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>Total Pinjaman yang Diterima</b></td>
                                                    <td style="text-align: right">
                                                        <b>{{ cek_uang($pengajuan->total_pinjaman) }}</b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Angsuran bunga perbulan</td>
                                                    <td style="text-align: right">
                                                        {{ cek_uang($pengajuan->angsuran_bunga) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Angsuran pokok perbulan</td>
                                                    <td style="text-align: right">
                                                        {{ cek_uang($pengajuan->angsuran_pokok) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-capitalize"><b>Total angsuran perbulan</b>
                                                    </td>
                                                    <td style="text-align: right">
                                                        <b>{{ cek_uang($pengajuan->total_angsuran) }}</b>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 d-flex justify-content-end">
                            <a type="button" href="javascript:history.back()"
                                class="btn btn-light-secondary me-1 mb-1">Kembali</a>
                            <a type="button" href="#" class="btn btn-primary me-1 mb-1">Download</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
