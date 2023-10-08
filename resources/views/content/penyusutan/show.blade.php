@extends('layouts.contentSidebarLayout')
@section('title', "$title")
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>{{ $title }}</h3>
                    <p class="text-subtitle text-muted">Detail Transaksi {{ $title }} Unit {{ $unit }}</p>
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
                        @if (isset($tipe))
                            <div class="ribbon ribbon-top-right">
                                <span class="text-capitalize"
                                    style="background-color: {{ $tipe == 'kadaluwarsa' ? 'red' : 'forestgreen' }} ">
                                    {{ $tipe }}
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
                                        <h3 class="text-light" style="text-align: right">{{ $title }}</h3>
                                    </div>
                                    <div class="col-12">
                                        <h6 class="text-light" style="text-align: right">#{{ $invoice }}
                                        </h6>
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
                                @isset($no_bukti)
                                    <tr>
                                        <td>
                                            <small class="text-dark">No. Bukti</small>
                                        </td>
                                        <td>
                                            <small class="text-dark text-capitalize"> :
                                                {{ $no_bukti }}</small>
                                        </td>
                                    </tr>
                                @endisset
                                @if (isset($tglTransaksi))
                                    <tr>
                                        <td>
                                            <small class="text-dark"><b>Tanggal Transaksi</b></small>
                                        </td>
                                        <td>
                                            <small class="text-dark text-capitalize"> :
                                                <b>{{ date('d-m-Y', strtotime($tglTransaksi)) }}</b></small>
                                        </td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                    <hr class="border border-primary m-0">
                    <hr class="border border-primary m-0">
                    <hr class="border border-primary m-0">
                    <hr class="border border-primary m-0">
                </div>
                <div class="card-body">
                    @if (isset($invoice_penyesuaian))
                        <div class="row mb-2">
                            <small
                                class="text-primary"><b><i>{{ $tipe === 'penyesuaian' ? 'Penyesuaian Transaksi ' . $invoice_penyesuaian : '' }}</b></i>
                            </small>
                        </div>
                    @endif
                    <div class='row mb-2 pb-1'>
                        <div class='col-lg-8 col-md-6'>
                            <table class='table table-borderless'>
                                <tr>
                                    <td>Keterangan</td>
                                </tr>
                                <tr>
                                    <td class='text-capitalize text-dark'>
                                        {{ $deskripsi . ' unit ' . $unit }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class='row mb-2 pb-1 bg-theme-dark'>
                        <p class="text-success"><strong>Detail Penyusutan:</strong></p>
                        <div class='table-responsive'>
                            <table class='table table-hover table-bordered'>
                                <thead class='table table-success'>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Tgl. Beli</th>
                                        <th>Harga Beli</th>
                                        <th>Qty</th>
                                        <th>Nilai Penyusutan</th>
                                        <th>Nilai Buku</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @forelse ($detailPenyusutan as $d)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $d->id_eceran ? $d->barang->nama_barang . ' (Eceran)' : $d->barang->nama_barang }}
                                            </td>
                                            <td>{{ date('d/m/Y', strtotime($d->barang->tgl_beli)) }}</td>
                                            <td style="text-align: right">
                                                {{ $d->id_eceran ? cek_uang($d->barang_eceran->harga_barang) : cek_uang($d->barang->harga_barang) }}
                                            </td>
                                            <td>{{ $d->qty . ' ' . $d->satuan->nama_satuan }}</td>
                                            <td style="text-align: right">{{ cek_uang($d->harga_penyusutan) }}</td>
                                            <td style="text-align: right">{{ cek_uang($d->harga_brg_sekarang) }}</td>
                                            <td style="text-align: right">{{ cek_uang($d->subtotal) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8">Tidak Ada Transaksi.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="7">
                                            <h5 class="text-dark">Total Penyusutan</h5>
                                        </td>
                                        <td style="text-align: right">
                                            <h5 class="text-dark">{{ cek_uang($totalTransaksi) }}</h5>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class='row mb-2 pb-1 bg-theme-dark'>
                        <p class="text-success"><strong>Jurnal Penyusutan:</strong></p>
                        <div class='table-responsive'>
                            <table class='table table-hover table-bordered'>
                                <thead class='table table-success'>
                                    <tr>
                                        <td>Rekening</td>
                                        <td>Ref</td>
                                        <td>Debet</td>
                                        <td>Kredit</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jurnals as $item)
                                        <tr>
                                            @if ($item->posisi_dr_cr === 'debet')
                                                <td>{{ $item->coa->nama }}</td>
                                                <td style='text-align:center'>{{ $item->coa->kode }}</td>
                                                <td style='text-align:right'>{{ cek_uang($item->nominal) }}</td>
                                                <td style='text-align:center'>-</td>
                                            @else
                                                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $item->coa->nama }}
                                                </td>
                                                <td style='text-align:center'>{{ $item->coa->kode }}</td>
                                                <td style='text-align:center'>-</td>
                                                <td style='text-align:right'>{{ cek_uang($item->nominal) }}</td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 d-flex justify-content-end">
                            <a type="button" href="{{ route($mainRoute) }}"
                                class="btn btn-light-secondary me-1 mb-1">Keluar</a>
                            <a type="button" href="#" class="btn btn-primary me-1 mb-1">Download</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
