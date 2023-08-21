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
                    <h4 class="card-title">Form Edit</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('profil-koperasi.update', $profil->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="table table-responsive">
                            <table class="table table-hover">
                                <tr>
                                    <td>Koperasi</td>
                                    <td> <input type="text" value="{{ $profil->nama }}" class="form-control"
                                            name="nama" /></td>
                                </tr>
                                <tr>
                                    <td>Nomor Badan Hukum Pendirian</td>
                                    <td><input type="text" value="{{ $profil->badan_hukum }}" class="form-control"
                                            name="badan_hukum" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tanggal Badan Hukum Pendirian</td>
                                    <td><input type="date" value="{{ $profil->tgl_badan_hukum }}" class="form-control"
                                            name="tgl_badan_hukum" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Nomor Perubahan Anggaran Dasar (Terbaru)</td>
                                    <td><input value="{{ $profil->nmr_pad }}" class="form-control" name="nmr_pad" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tanggal Perubahan Anggaran Dasar (Terbaru)</td>
                                    <td><input value="{{ $profil->tgl_pad }}" class="form-control" name="tgl_pad" /></td>
                                </tr>
                                <tr>
                                    <td>Tanggal RAT Terakhir</td>
                                    <td><input value="{{ $profil->tgl_rat }}" class="form-control" name="tgl_rat" /></td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td><input value="{{ $profil->alamat }}" class="form-control" name="alamat" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Kelurahan/Desa</td>
                                    <td><input value="{{ $profil->kelurahan }}" class="form-control" name="kelurahan" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Kecamatan</td>
                                    <td><input value="{{ $profil->kecamatan }}" class="form-control" name="kecamatan" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Kabupaten</td>
                                    <td><input value="{{ $profil->kabupaten }}" class="form-control" name="kabupaten" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Provinsi</td>
                                    <td><input value="{{ $profil->provinsi }}" class="form-control" name="provinsi" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Bentuk Koperasi</td>
                                    <td><input value="{{ $profil->bentuk_koperasi }}" class="form-control"
                                            name="bentuk_koperasi" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Jenis Koperasi</td>
                                    <td><input value="{{ $profil->jenis }}" class="form-control" name="jenis" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Kelompok Koperasi</td>
                                    <td><input value="{{ $profil->kelompok_koperasi }}" class="form-control"
                                            name="kelompok_koperasi" /></td>
                                </tr>
                                <tr>
                                    <td>Sektor Usaha</td>
                                    <td><input value="{{ $profil->sektor }}" class="form-control" name="sektor" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Nomor Induk Koperasi (NIK)</td>
                                    <td><input value="{{ $profil->nik }}" class="form-control" name="nik" /></td>
                                </tr>
                                <tr>
                                    <td>Status NIK</td>
                                    <td><input value="{{ $profil->status_nik }}" class="form-control" name="status_nik" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Status Grade</td>
                                    <td><input value="{{ $profil->status_grade }}" class="form-control"
                                            name="status_grade" />
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                                <a type="button" href="{{ route('profil-koperasi') }}"
                                    class="btn btn-sm btn-secondary">Keluar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
