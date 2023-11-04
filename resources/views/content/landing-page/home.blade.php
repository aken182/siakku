@extends('layouts.landingMaster')
@section('title', "$title")
@section('content')
    <!-- ======= Hero Section ======= -->
    <section class="hero-section" id="hero">

        <div class="wave">

            <svg width="100%" height="355px" viewBox="0 0 1920 355" version="1.1" xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink">
                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <g id="Apple-TV" transform="translate(0.000000, -402.000000)" fill="#FFFFFF">
                        <path
                            d="M0,439.134243 C175.04074,464.89273 327.944386,477.771974 458.710937,477.771974 C654.860765,477.771974 870.645295,442.632362 1205.9828,410.192501 C1429.54114,388.565926 1667.54687,411.092417 1920,477.771974 L1920,757 L1017.15166,757 L0,757 L0,439.134243 Z"
                            id="Path"></path>
                    </g>
                </g>
            </svg>

        </div>

        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 hero-text-image">
                    <div class="row">
                        <div class="col-lg-8 text-center text-lg-start">
                            <h1 data-aos="fade-right">Aplikasi Akuntansi & Keuangan</h1>
                            <p class="mb-5" data-aos="fade-right" data-aos-delay="100">Sistem Informasi Akuntansi &
                                Keuangan KPRI Usaha Jaya - Larantuka</p>
                            <p data-aos="fade-right" data-aos-delay="200" data-aos-offset="-500"><a
                                    href="{{ route('login') }}" class="btn btn-outline-white">Login</a></p>
                        </div>
                        <div class="col-lg-4 iphone-wrap">
                            <img src="{{ asset('assets/landing-page') }}/img/siakku_1.png" alt="Image" class="phone-1"
                                data-aos="fade-right">
                            <img src="{{ asset('assets/landing-page') }}/img/siakku_2.png" alt="Image" class="phone-2"
                                data-aos="fade-right" data-aos-delay="200">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- End Hero -->

    <main id="main">

        <!-- ======= Home Section ======= -->
        <section class="section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-4 me-auto">
                        <h2 class="mb-4">Mengelola Simpanan</h2>
                        <p class="mb-4">Pengguna dapat menginput transaksi simpanan anggota dan sistem mengelola transaksi
                            tersebut menjadi informasi dalam bentuk laporan simpanan anggota.</p>
                        <p><a href="{{ route('features') }}" class="btn btn-primary">Selengkapnya</a></p>
                    </div>
                    <div class="col-md-6" data-aos="fade-left">
                        <img src="{{ asset('assets/landing-page') }}/img/undraw_svg_2.svg" alt="Image" class="img-fluid">
                    </div>
                </div>
            </div>
        </section>

        <section class="section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-4 ms-auto order-2">
                        <h2 class="mb-4">Mengelola Pinjaman</h2>
                        <p class="mb-4">Pengguna dapat menginput transaksi pinjaman anggota dan sistem mengelola transaksi
                            tersebut menjadi informasi dalam bentuk laporan pinjaman anggota.</p>
                        <p><a href="{{ route('features') }}" class="btn btn-primary">Selengkapnya</a></p>
                    </div>
                    <div class="col-md-6" data-aos="fade-right">
                        <img src="{{ asset('assets/landing-page') }}/img/undraw_svg_3.svg" alt="Image" class="img-fluid">
                    </div>
                </div>
            </div>
        </section>

        @include('content.landing-page.content-footer')

    </main>
    <!-- End #main -->
@endsection
@section('pageScript')
    <!-- Template Main JS File -->
    <script src="{{ asset('assets/landing-page') }}/js/main.js"></script>
@endsection
