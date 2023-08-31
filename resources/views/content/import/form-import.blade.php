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
                            <h4 class="card-title">Form Import</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form" action="{{ route($routeStore) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row mb-1">
                                        <div class="col-md-6 col-12">
                                            <span class="text-success">Petunjuk : Format file excel harus sesuai dengan
                                                template dibawah ini!</span>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6 col-12">
                                            <a type="button"
                                                class="btn btn-outline-success icon dripicons dripicons-cloud-download"
                                                href="{{ route($routeTemplate) }}" target="_blank">&nbsp;Unduh
                                                Template !</a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="text-primary">File Excel</label>
                                                <input type="file"
                                                    class="form-control @error('file') is-invalid @enderror" name="file">
                                                @if ($errors->any())
                                                    @foreach ($errors->all() as $error)
                                                        <span class="text-danger">{{ $error }}</span><br>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @if (session()->has('failures'))
                                        <div class="row">
                                            <div class="col-md-12 col-12">
                                                <small>
                                                    <table class="table table-danger dataTable">
                                                        <thead>
                                                            <tr>
                                                                <td>Baris</td>
                                                                <td>Nama Kolom</td>
                                                                <td>Pesan Error</td>
                                                                <td>Isi Kolom</td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach (session()->get('failures') as $v)
                                                                <tr>
                                                                    <td>{{ $v->row() }}</td>
                                                                    <td>{{ $v->attribute() }}</td>
                                                                    <td>
                                                                        <ul>
                                                                            @foreach ($v->errors() as $e)
                                                                                <li>
                                                                                    @if (session()->has('customValidationMessages') &&
                                                                                            isset(session('customValidationMessages')[$v->attribute() . '.' . $e]))
                                                                                        {{ session('customValidationMessages')[$v->attribute() . '.' . $e][0] }}
                                                                                    @else
                                                                                        {{ $e }}
                                                                                    @endif
                                                                                </li>
                                                                            @endforeach
                                                                        </ul>
                                                                    </td>
                                                                    <td>{{ $v->values()[$v->attribute()] }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </small>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                            <a type="button" href="{{ route($routeMain) }}"
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
