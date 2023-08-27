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
        <!-- // Basic multiple Column Form section start -->
        <section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Form Tambah</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form" action="{{ route('pp-pengajuan.store') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="divider">
                                            <div class="divider-text text-primary">EVALUASI KEMAMPUAN ANGSURAN</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="text-primary">Nama Anggota</label>
                                                <select name="id_anggota"
                                                    class="choices form-select @error('id_anggota') is-invalid @enderror"
                                                    id="id_anggota">
                                                    <option value="" selected>Pilih Anggota</option>
                                                    @foreach ($anggota as $a)
                                                        <option value="{{ $a->id_anggota }}">{{ $a->nama }}</option>
                                                    @endforeach
                                                </select>
                                                @error('nama')
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="text-primary">Gaji</label>
                                                <input type="text"
                                                    class="form-control format-rupiah @error('gaji_perbulan') is-invalid @enderror"
                                                    placeholder="Masukkan nominal gaji tetap/bulan." id="gaji_perbulan"
                                                    name="gaji_perbulan" onKeyUp="hitung()">
                                                @error('gaji_perbulan')
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="text-primary">Potongan</label>
                                                <input type="text"
                                                    class="form-control format-rupiah @error('potongan_perbulan') is-invalid @enderror"
                                                    placeholder="Masukkan nominal potongan rutin/bulan."
                                                    id="potongan_perbulan" name="potongan_perbulan" onKeyUp="hitung()">
                                                @error('potongan_perbulan')
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="text-primary">Cicilan</label>
                                                <input type="text"
                                                    class="form-control format-rupiah @error('cicilan_perbulan') is-invalid @enderror"
                                                    placeholder="Masukkan nominal cicilan lain/bulan." id="cicilan_perbulan"
                                                    name="cicilan_perbulan" onKeyUp="hitung()">
                                                @error('cicilan_perbulan')
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="text-primary">Biaya Hidup</label>
                                                <input type="text"
                                                    class="form-control format-rupiah @error('biaya_perbulan') is-invalid @enderror"
                                                    placeholder="Masukkan nominal biaya hidup/bulan." id="biaya_perbulan"
                                                    name="biaya_perbulan" onKeyUp="hitung()">
                                                @error('biaya_perbulan')
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="text-primary">Sisa Penghasilan</label>
                                                <input type="text"
                                                    class="form-control @error('sisa_penghasilan') is-invalid @enderror"
                                                    placeholder="Sisa penghasilan/bulan." id="sisa_penghasilan"
                                                    name="sisa_penghasilan" readonly>
                                                @error('sisa_penghasilan')
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <label class="text-primary">Persentase Perkiraan Kemampuan Bayar</label>
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="input-group mb-3">
                                                        <input type="number" step="0.25"
                                                            class="form-control @error('perkiraan') is-invalid @enderror"
                                                            placeholder="ex.100" id="perkiraan" name="perkiraan"
                                                            onKeyUp="hitung()">
                                                        @error('perkiraan')
                                                            <span class="invalid-feedback" role="alert">
                                                                {{ $message }}
                                                            </span>
                                                        @enderror
                                                        <span class="input-group-text">%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="text-primary">Kemampuan Bayar</label>
                                                <input type="text"
                                                    class="form-control @error('kemampuan_bayar') is-invalid @enderror"
                                                    placeholder="Kemampuan Bayar Cicilan/bulan." id="kemampuan_bayar"
                                                    name="kemampuan_bayar" readonly>
                                                @error('kemampuan_bayar')
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="divider">
                                            <div class="divider-text text-primary">PENGAJUAN PINJAMAN</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="text-primary">Jumlah Pinjaman</label>
                                                <input type="text"
                                                    class="form-control format-rupiah @error('jumlah_pinjaman') is-invalid @enderror"
                                                    placeholder="Masukkan nominal pengajuan pinjaman."
                                                    id="jumlah_pinjaman" name="jumlah_pinjaman" onKeyUp="hitung()">
                                                @error('jumlah_pinjaman')
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <label class="text-primary">Jangka Waktu</label>
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="input-group mb-3">
                                                        <input type="number" step="0.25"
                                                            class="form-control @error('jangka_waktu') is-invalid @enderror"
                                                            placeholder="ex.12" id="jangka_waktu" name="jangka_waktu"
                                                            onKeyUp="hitung()">
                                                        @error('jangka_waktu')
                                                            <span class="invalid-feedback" role="alert">
                                                                {{ $message }}
                                                            </span>
                                                        @enderror
                                                        <span class="input-group-text">Bulan</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="text-primary">Asuransi</label>
                                                <input type="text"
                                                    class="form-control format-rupiah @error('asuransi') is-invalid @enderror"
                                                    placeholder="Masukkan nominal asuransi." id="asuransi"
                                                    name="asuransi" onKeyUp="hitung()">
                                                @error('asuransi')
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <label class="text-primary">Bunga</label>
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="input-group mb-3">
                                                        <input type="number" step="0.25"
                                                            class="form-control @error('bunga') is-invalid @enderror"
                                                            value="1" id="bunga" name="bunga"
                                                            onKeyUp="hitung()" readonly>
                                                        @error('bunga')
                                                            <span class="invalid-feedback" role="alert">
                                                                {{ $message }}
                                                            </span>
                                                        @enderror
                                                        <span class="input-group-text">%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="text-primary">Kapitalisasi</label>
                                                <input type="text"
                                                    class="form-control format-rupiah @error('kapitalisasi') is-invalid @enderror"
                                                    placeholder="Kapitalisasi (5% dari pinjaman)." id="kapitalisasi"
                                                    name="kapitalisasi" readonly>
                                                @error('kapitalisasi')
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="text-primary">Total Angsuran</label>
                                                <input type="text"
                                                    class="form-control format-rupiah @error('total_angsuran') is-invalid @enderror"
                                                    placeholder="Total angsuran/bulan." id="total_angsuran"
                                                    name="total_angsuran" readonly>
                                                @error('total_angsuran')
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="text-primary">Angsuran Pokok</label>
                                                <input type="text"
                                                    class="form-control format-rupiah @error('angsuran_pokok') is-invalid @enderror"
                                                    placeholder="Angsuran pokok/bulan." id="angsuran_pokok"
                                                    name="angsuran_pokok" readonly>
                                                @error('angsuran_pokok')
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="text-primary">Angsuran Bunga</label>
                                                <input type="text"
                                                    class="form-control format-rupiah @error('angsuran_bunga') is-invalid @enderror"
                                                    placeholder="Angsuran bunga/bulan." id="angsuran_bunga"
                                                    name="angsuran_bunga" readonly>
                                                @error('angsuran_bunga')
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="text-primary">Pinjaman yang Diterima</label>
                                                <input type="text"
                                                    class="form-control format-rupiah @error('total_pinjaman') is-invalid @enderror"
                                                    placeholder="Total pinjaman yang diterima." id="total_pinjaman"
                                                    name="total_pinjaman" readonly>
                                                @error('total_pinjaman')
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="text-primary">Keterangan</label>
                                                <textarea name="keterangan" id="keterangan" cols="30" rows="3"
                                                    class="form-control @error('keterangan') is-invalid @enderror" placeholder="Masukkan Keterangan."></textarea>
                                                @error('keterangan')
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                            <a type="button" href="{{ route('pp-pengajuan') }}"
                                                class="btn btn-light-secondary me-1 mb-1">Keluar</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- // Basic multiple Column Form section end -->
    </div>
@endsection

@section('pageScript')
    <script src="{{ asset('assets/admin') }}/js/siakku-custom/pengajuan.js"></script>
@endsection
