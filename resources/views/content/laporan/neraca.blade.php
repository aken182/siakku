@extends('layouts.contentSidebarLayout')
@section('title', "$title")
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>{{ $title }}</h3>
                    <p class="text-subtitle text-muted text-capitalize">Laporan {{ $title }}</p>
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
                                    <div class="col-sm-4">
                                        <select class="form-select choices" id="bulan" name="bulan" required>
                                            <option value="" selected>Pilih Bulan</option>
                                            @for ($i = 1; $i <= 12; $i++)
                                                <option value="{{ $i }}">{{ bulan_indonesia($i) }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <select class="form-select choices" id="tahun" name="tahun" required>
                                            <option value="" selected>Pilih Tahun</option>
                                            @for ($i = 2024; $i >= date('Y') - 17; $i -= 1)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <button class="btn rounded-pill btn-primary" type="submit">Cari</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <hr class="m-0" style="height: 0.5px" />
                <div class="card-header">
                    <h6 class="text-center text-uppercase">{{ $title2 }}</h6>
                    <h6 class="text-center text-uppercase">{{ $title }}</h6>
                    <h6 class="text-center text-uppercase">{{ $title3 }}</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-lg-6">
                            <table class="table table-bordered table-hover">
                                <thead class="table-success">
                                    <tr class="text-uppercase">
                                        <th>No. Perk</th>
                                        <th>Keterangan</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><b>I.</b></td>
                                        <td class="text-uppercase"><b>Aktiva Lancar</b></td>
                                        <td></td>
                                    </tr>
                                    @foreach ($lap['aktivaLancar'] as $al)
                                        @if ($al->total_saldo > 0)
                                            <tr>
                                                <td>{{ $al->kode }}</td>
                                                <td>{{ $al->nama }}</td>
                                                <td style="text-align: right">{{ cekUangDecimal($al->total_saldo) }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    <tr>
                                        <td>-</td>
                                        <td class="text-uppercase"><b>Jumlah Aktiva Lancar</b></td>
                                        <td style="text-align: right">
                                            <b>{{ cekUangDecimal($lap['totalAktivaLancar']) }}</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>II.</b></td>
                                        <td class="text-uppercase"><b>Aktiva Tetap</b></td>
                                        <td></td>
                                    </tr>
                                    @foreach ($lap['aktivaTetap'] as $at)
                                        <tr>
                                            <td>{{ $at->kode }}</td>
                                            <td>{{ $at->nama }}</td>
                                            <td style="text-align: right">{{ cekUangDecimal($at->total_saldo) }}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td>-</td>
                                        <td class="text-uppercase"><b>Jumlah Aktiva Tetap</b></td>
                                        <td style="text-align: right"><b>{{ cekUangDecimal($lap['totalAktivaTetap']) }}</b>
                                        </td>
                                    </tr>
                                    @foreach ($lap['penyusutan'] as $p)
                                        <tr>
                                            <td>{{ $p->kode }}</td>
                                            <td>{{ $p->nama }}</td>
                                            <td style="text-align: right">{{ cekUangDecimal($p->total_saldo) }}</td>
                                        </tr>
                                    @endforeach
                                    @isset($lap['penyertaan'])
                                        <tr>
                                            <td><b>III.</b></td>
                                            <td class="text-uppercase"><b>Penyertaan</b></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>020</td>
                                            <td>Penyertaan Pada PKPRI</td>
                                            <td style="text-align: right"><b>{{ cekUangDecimal($lap['penyertaan']) }}</b></td>
                                        </tr>
                                    @endisset
                                    <tr>
                                        <td>-</td>
                                        <td class="text-uppercase"><b>Total Aktiva</b></td>
                                        <td style="text-align: right"><b>{{ cekUangDecimal($lap['totalAktiva']) }}</b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6 col-sm-12 col-lg-6">
                            <table class="table table-bordered table-hover">
                                <thead class="table-success">
                                    <tr class="text-uppercase">
                                        <th>No. Perk</th>
                                        <th>Keterangan</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><b>IV.</b></td>
                                        <td class="text-uppercase"><b>Passiva Lancar</b></td>
                                        <td></td>
                                    </tr>
                                    @foreach ($lap['passivaLancar'] as $pl)
                                        @if ($pl->total_saldo != 0)
                                            <tr>
                                                <td>{{ $pl->kode }}</td>
                                                <td>{{ $pl->nama }}</td>
                                                <td style="text-align: right">{{ cekUangDecimal($pl->total_saldo) }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    <tr>
                                        <td>-</td>
                                        <td class="text-uppercase"><b>Jumlah Passiva Lancar</b></td>
                                        <td style="text-align: right">
                                            <b>{{ cekUangDecimal($lap['totalPassivaLancar']) }}</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>V.</b></td>
                                        <td class="text-uppercase"><b>Modal Sendiri</b></td>
                                        <td></td>
                                    </tr>
                                    @foreach ($lap['modalSendiri'] as $ms)
                                        @if ($ms['total_saldo'] != 0)
                                            <tr>
                                                <td>{{ $ms['kode'] }}</td>
                                                <td>{{ $ms['nama'] }}</td>
                                                <td style="text-align: right">{{ cekUangDecimal($ms['total_saldo']) }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    <tr>
                                        <td>-</td>
                                        <td class="text-uppercase"><b>Jumlah Modal Sendiri</b></td>
                                        <td style="text-align: right">
                                            <b>{{ cekUangDecimal($lap['totalModalSendiri']) }}</b>
                                        </td>
                                    </tr>
                                    {{-- @foreach ($lap['biayaTidakLangsung'] as $btl)
                                        <tr>
                                            <td>{{ $btl->kode }}</td>
                                            <td>{{ $btl->nama }}</td>
                                            <td style="text-align: right">{{ cekUangDecimal($btl->total_saldo * -1) }}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td>-</td>
                                        <td class="text-uppercase"><b>Jumlah</b></td>
                                        <td style="text-align: right"><b>{{ cekUangDecimal($lap['totalBiayaTidakLangsung'] * -1) }}</b></td>
                                    </tr> --}}
                                    <tr>
                                        <td>-</td>
                                        <td class="text-uppercase"><b>Total Passiva</b></td>
                                        <td style="text-align: right"><b>{{ cekUangDecimal($lap['totalPassiva']) }}</b>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
