@extends('layouts.blankLayout')
@section('pageStyle')
    <link rel="stylesheet" href="{{ asset('assets/admin') }}/css/pages/error.css">
@endsection
@section('title', 'Error - Hak Akses')
@section('content')
    <div id="error">
        <div class="error-page container">
            <div class="col-md-8 col-12 offset-md-2 mt-0">
                <div class="text-center">
                    <h3 class="error-title text-dark">Tidak Ditemukan !</h3>
                    <p class='fs-5 text-dark'>Oops! 😖 Anda tidak memiliki akses ke halaman ini.</p>
                    <a href="javascript:history.back()" class="btn btn-lg btn-outline-primary mt-3">Kembali</a>
                </div>
                <img class="img-error" style="width:69%" src="{{ asset('assets/admin') }}/images/samples/error-404.png"
                    alt="Not Found">
            </div>
        </div>
    </div>
@endsection
