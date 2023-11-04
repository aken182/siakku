@extends('layouts.landingMaster')
@section('title', "$title")
@section('content')

    <main id="main">

        <!-- ======= Features Section ======= -->

        <section class="hero-section inner-page">
            <div class="wave">

                <svg width="1920px" height="265px" viewBox="0 0 1920 265" version="1.1" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink">
                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g id="Apple-TV" transform="translate(0.000000, -402.000000)" fill="#FFFFFF">
                            <path
                                d="M0,439.134243 C175.04074,464.89273 327.944386,477.771974 458.710937,477.771974 C654.860765,477.771974 870.645295,442.632362 1205.9828,410.192501 C1429.54114,388.565926 1667.54687,411.092417 1920,477.771974 L1920,667 L1017.15166,667 L0,667 L0,439.134243 Z"
                                id="Path"></path>
                        </g>
                    </g>
                </svg>

            </div>

            <div class="container">
                <div class="row align-items-center">
                    <div class="col-12">
                        <div class="row justify-content-center">
                            <div class="col-md-7 text-center hero-text">
                                <h1 data-aos="fade-up" data-aos-delay="">Features</h1>
                                <p class="mb-5 text-capitalize" data-aos="fade-up" data-aos-delay="100">Fitur - fitur dalam
                                    sistem informasi & keuangan KPRI Usaha Jaya</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>

        <section class="section pb-0">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-4 me-auto">
                        <h2 class="mb-4">Unit Simpan Pinjam</h2>
                        <p class="mb-4  link-dark">Unit ini merupakan unit yang mengelola simpanan dan pinjaman anggota
                            koperasi.
                            Fitur - fitur besar dalam unit ini adalah sebagai berikut.</p>
                        <ul class="link-dark">
                            <li>Pengelolaan Simpanan</li>
                            <li>Pengelolaan Simpanan Sukarela Berbunga</li>
                            <li>Pengelolaan Pinjaman</li>
                            <li>Pengelolaan Belanja</li>
                            <li>Pengelolaan Pengelolaan Aktiva Tetap</li>
                            <li>Pengelolaan Pendapatan</li>
                            <li>Laporan Keuangan</li>
                        </ul>
                    </div>
                    <div class="col-md-6" data-aos="fade-left">
                        <img src="{{ asset('assets/landing-page') }}/img/siakku_1.png" alt="Image" class="img-fluid">
                    </div>
                </div>
            </div>
        </section>

        <section class="section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-4 ms-auto order-2">
                        <h2 class="mb-4">Unit Pertokoan</h2>
                        <p class="mb-4 link-dark">Unit ini merupakan unit yang mengelola penjualan persediaan pertokoan
                            dan simpanan
                            pertokoan.
                            Fitur - fitur besar dalam unit ini adalah sebagai berikut.</p>
                        <ul class="link-dark">
                            <li>Pengelolaan Penjualan Toko</li>
                            <li>Pengelolaan Persediaan Toko</li>
                            <li>Pengelolaan Belanja Barang & Belanja Lainnya</li>
                            <li>Pengelolaan Pendapatan</li>
                            <li>Pengelolaan Pengelolaan Aktiva Tetap</li>
                            <li>Laporan Keuangan</li>
                        </ul>
                    </div>
                    <div class="col-md-6" data-aos="fade-right">
                        <img src="{{ asset('assets/landing-page') }}/img/siakku_2.png" alt="Image" class="img-fluid">
                    </div>
                </div>
            </div>
        </section>

        <section class="section pb-0">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-4 me-auto">
                        <h2 class="mb-4">Import, Export PDF dan Excel </h2>
                        <p class="mb-4 link-dark">Menampilkan laporan dalam bentuk pdf, mengexport laporan dalam bentuk
                            excel, serta
                            mengimport laporan dalam bentuk excel ke dalam database.</p>
                    </div>
                    <div class="col-md-6" data-aos="fade-left">
                        <img src="{{ asset('assets/landing-page') }}/img/excelPdf.png" alt="Image" class="img-fluid">
                    </div>
                </div>
            </div>
        </section>

        <section class="section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-4 ms-auto order-2">
                        <h2 class="mb-4">Estimasi SHU </h2>
                        <p class="mb-4 link-dark">Estimasi SHU merupakan perkiraan atau proyeksi terkait dengan seberapa
                            besar
                            Sisa Hasil Usaha yang mungkin akan diperoleh oleh koperasi dalam periode tertentu. Ini
                            penting untuk perencanaan keuangan dan pengambilan keputusan strategis,
                            karena membantu dalam menentukan sejauh mana kinerja perusahaan tersebut dan seberapa besar laba
                            yang dapat diharapkan dalam waktu yang akan datang. Dengan kata lain, estimasi SHU adalah upaya
                            untuk memprediksi potensi keuntungan yang akan koperasi berdasarkan analisis dan asumsi tertentu
                        </p>
                    </div>
                    <div class="col-md-6" data-aos="fade-right">
                        <img src="{{ asset('assets/landing-page') }}/img/siakku_3.png" alt="Image" class="img-fluid">
                    </div>
                </div>
            </div>
        </section>

        @include('content.landing-page.content-footer')

    </main><!-- End #main -->
@endsection
@section('pageScript')
    <!-- Template Main JS File -->
    <script src="{{ asset('assets/landing-page') }}/js/main.js"></script>
@endsection
