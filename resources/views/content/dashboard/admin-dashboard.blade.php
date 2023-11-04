@extends('layouts.contentSidebarLayout')
@section('title', "$title")
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>{{ $title }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-9">
                @if (Auth::check() && Auth::user()->hasPermissionTo('unit-pertokoan'))
                    <div class="row">
                        <h5>Unit Pertokoan</h5>
                    </div>
                    <div class="row">
                        <div class="col-6 col-lg-4 col-md-6">
                            <div class="card">
                                <div class="card-body px-3 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="stats-icon purple">
                                                <i class="iconly-boldShow"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <h6 class="text-muted font-semibold">Kas & Bank</h6>
                                            <h6 class="font-extrabold mb-0">{{ formatAccountingDecimal($kasBankToko) }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-4 col-md-6">
                            <div class="card">
                                <div class="card-body px-3 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="stats-icon blue">
                                                <i class="iconly-boldProfile"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <h6 class="text-muted font-semibold">Simpanan</h6>
                                            <h6 class="font-extrabold mb-0">{{ formatAccountingDecimal($simpananToko) }}
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-4 col-md-6">
                            <div class="card">
                                <div class="card-body px-3 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="stats-icon red">
                                                <i class="iconly-boldProfile"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <h6 class="text-muted font-semibold">Piutang Barang</h6>
                                            <h6 class="font-extrabold mb-0">
                                                {{ formatAccountingDecimal($piutangBarangToko) }}
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-4 col-md-6">
                            <div class="card">
                                <div class="card-body px-3 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="stats-icon green">
                                                <i class="iconly-boldProfile"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <h6 class="text-muted font-semibold">Pendapatan Tahun {{ date('Y') }}
                                            </h6>
                                            <h6 class="font-extrabold mb-0">{{ formatAccountingDecimal($pendapatanToko) }}
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-4 col-md-6">
                            <div class="card">
                                <div class="card-body px-3 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="stats-icon purple">
                                                <i class="iconly-boldProfile"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <h6 class="text-muted font-semibold">Belanja Tahun {{ date('Y') }}</h6>
                                            <h6 class="font-extrabold mb-0">{{ formatAccountingDecimal($belanjaToko) }}
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-4 col-md-6">
                            <div class="card">
                                <div class="card-body px-3 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="stats-icon blue">
                                                <i class="iconly-boldProfile"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <h6 class="text-muted font-semibold">Estimasi SHU Tahun {{ date('Y') }}
                                            </h6>
                                            <h6 class="font-extrabold mb-0">{{ formatAccountingDecimal($shuToko) }}
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-12 col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <a href="{{ route('lut-laba-rugi') }}" data-bs-toggle="tooltip" data-bs-offset="0,4"
                                        data-bs-placement="top" data-bs-html="true"
                                        title="Klik disini untuk melihat laporan laba rugi.">
                                        <h4 class="text-primary">Grafik Laba Rugi Tahun {{ date('Y') }} - Unit
                                            Pertokoan
                                        </h4>
                                    </a>
                                </div>
                                <div class="card-body">
                                    <div id="chart-laba-rugi-toko"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if (Auth::check() && Auth::user()->hasPermissionTo('unit-simpan-pinjam'))
                    <div class="row">
                        <h5>Unit Simpan Pinjam</h5>
                    </div>
                    <div class="row">
                        <div class="col-6 col-lg-4 col-md-6">
                            <div class="card">
                                <div class="card-body px-3 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="stats-icon purple">
                                                <i class="iconly-boldShow"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <h6 class="text-muted font-semibold">Kas & Bank</h6>
                                            <h6 class="font-extrabold mb-0">{{ formatAccountingDecimal($kasBankSp) }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-4 col-md-6">
                            <div class="card">
                                <div class="card-body px-3 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="stats-icon blue">
                                                <i class="iconly-boldProfile"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <h6 class="text-muted font-semibold">Simpanan</h6>
                                            <h6 class="font-extrabold mb-0">{{ formatAccountingDecimal($simpananSp) }}
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-4 col-md-6">
                            <div class="card">
                                <div class="card-body px-3 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="stats-icon red">
                                                <i class="iconly-boldBookmark"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <h6 class="text-muted font-semibold">Piutang Pinjaman</h6>
                                            <h6 class="font-extrabold mb-0">
                                                {{ formatAccountingDecimal($piutangPinjamanSp) }}
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-4 col-md-6">
                            <div class="card">
                                <div class="card-body px-3 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="stats-icon green">
                                                <i class="iconly-boldProfile"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <h6 class="text-muted font-semibold">Pendapatan Tahun {{ date('Y') }}
                                            </h6>
                                            <h6 class="font-extrabold mb-0">{{ formatAccountingDecimal($pendapatanSp) }}
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-4 col-md-6">
                            <div class="card">
                                <div class="card-body px-3 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="stats-icon purple">
                                                <i class="iconly-boldProfile"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <h6 class="text-muted font-semibold">Belanja Tahun {{ date('Y') }}</h6>
                                            <h6 class="font-extrabold mb-0">{{ formatAccountingDecimal($belanjaSp) }}
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-4 col-md-6">
                            <div class="card">
                                <div class="card-body px-3 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="stats-icon blue">
                                                <i class="iconly-boldProfile"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <h6 class="text-muted font-semibold">Estimasi SHU Tahun {{ date('Y') }}
                                            </h6>
                                            <h6 class="font-extrabold mb-0">{{ formatAccountingDecimal($shuSp) }}
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <a href="{{ route('lus-laba-rugi') }}" data-bs-toggle="tooltip" data-bs-offset="0,4"
                                        data-bs-placement="top" data-bs-html="true"
                                        title="Klik disini untuk melihat laporan laba rugi.">
                                        <h4 class="text-primary">Grafik Laba Rugi Tahun {{ date('Y') }} - Unit Simpan
                                            Pinjam</h4>
                                    </a>
                                </div>
                                <div class="card-body">
                                    <div id="chart-laba-rugi-sp"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-12 col-lg-3">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('mdu-anggota') }}" data-bs-toggle="tooltip" data-bs-offset="0,4"
                            data-bs-placement="top" data-bs-html="true" title="Klik disini untuk melihat data anggota.">
                            <h4 class="text-primary">Anggota : {{ array_sum($anggota) . ' orang' }}</h4>
                        </a>
                    </div>
                    <div class="card-body">
                        <div id="chart-anggota"></div>
                    </div>
                </div>
                @if (Auth::check() && Auth::user()->hasPermissionTo('unit-pertokoan'))
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route('lut-gudang') }}" data-bs-toggle="tooltip" data-bs-offset="0,4"
                                data-bs-placement="top" data-bs-html="true"
                                title="Klik disini untuk melihat gudang pertokoan.">
                                <h4 class="text-primary">Persediaan Unit Pertokoan</h4>
                            </a>
                        </div>
                        <div class="card-body">
                            <div id="chart-persediaan-toko"></div>
                        </div>
                    </div>
                @endif
                @if (Auth::check() && Auth::user()->hasPermissionTo('unit-simpan-pinjam'))
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route('lus-simpanan') }}" data-bs-toggle="tooltip" data-bs-offset="0,4"
                                data-bs-placement="top" data-bs-html="true"
                                title="Klik disini untuk melihat laporan simpanan.">
                                <h4 class="text-primary">Simpanan Unit Simpan Pinjam</h4>
                            </a>
                        </div>
                        <div class="card-body">
                            <div id="chart-simpanan-sp"></div>
                        </div>
                    </div>
                @endif

            </div>
        </section>
    </div>
@endsection

@section('pageScript')
    <script>
        var anggota = @json($anggota);
    </script>
    @if (Auth::check() && Auth::user()->hasPermissionTo('unit-pertokoan'))
        <script>
            var labaRugiToko = @json($lrToko);
            var bulanLrToko = @json($bulanLrToko);
            var persediaanSaldo = @json($persediaanSaldo);
            var persediaanNama = @json($persediaanNama);
        </script>
    @endif
    @if (Auth::check() && Auth::user()->hasPermissionTo('unit-simpan-pinjam'))
        <script>
            var labaRugiSp = @json($lrSp);
            var bulanLrSp = @json($bulanLrSp);
            var keysSimpananSp = @json($keysSimpananSp);
            var valuesSimpananSp = @json($valuesSimpananSp);
        </script>
    @endif

    <script src="{{ asset('assets/admin') }}/vendors/apexcharts/apexcharts.js"></script>
    <script src="{{ asset('assets/admin') }}/js/pages/main-dashboard.js"></script>
    @if (Auth::check() && Auth::user()->hasPermissionTo('unit-simpan-pinjam'))
        <script src="{{ asset('assets/admin') }}/js/pages/sp-dashboard.js"></script>
    @endif
    @if (Auth::check() && Auth::user()->hasPermissionTo('unit-pertokoan'))
        <script src="{{ asset('assets/admin') }}/js/pages/toko-dashboard.js"></script>
    @endif
@endsection
