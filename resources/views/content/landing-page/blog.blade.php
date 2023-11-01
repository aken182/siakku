@extends('layouts.landingMaster')
@section('title', "$title")
@section('pageStyle')

@endsection
@section('content')
    <main id="main">

        <!-- ======= Blog Section ======= -->
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
                                <h1 data-aos="fade-up" data-aos-delay="">Blog Posts</h1>
                                <p class="mb-5" data-aos="fade-up" data-aos-delay="100">Halaman Berita KPRI
                                    Usaha Jaya Larantuka</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>

        <section class="section">
            <div class="container">
                <div class="row mb-5" data-aos="fade-right">
                    @foreach ($blogs as $blog)
                        <div class="col-md-4">
                            <div class="post-entry">
                                <a href="blog-single.html" class="d-block mb-4">
                                    <img src="{{ asset('storage/berita/' . $blog->gambar_berita) }}" alt="Image"
                                        class="img-fluid">
                                </a>
                                <div class="post-text">
                                    @php
                                        $bulan = bulan_indonesia(date('m', strtotime($blog->tgl_berita)));
                                        $hari = date('d', strtotime($blog->tgl_berita));
                                        $tahun = date('Y', strtotime($blog->tgl_berita));
                                    @endphp
                                    <span class="post-meta">{{ "$hari $bulan, $tahun" }} &bullet; By <a
                                            href="#">{{ $blog->penulis }}</a></span>
                                    <h3><a href="{{ route('blog.show', $blog->slug_berita) }}">{{ $blog->judul_berita }}</a>
                                    </h3>
                                    <p>{{ substr(strip_tags($blog->isi_berita), 0, 100) }}...</p>
                                    <p><a href="{{ route('blog.show', $blog->slug_berita) }}" class="readmore">Baca
                                            selengkapnya</a></p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="row">
                    <div class="col-12 d-flex justify-content-center">
                        {{ $blogs->links() }}
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
