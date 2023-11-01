@extends('layouts.landingMaster')
@section('title', "$title")
@section('pageStyle')
    <meta name="description" content="{{ $berita->deskripsi_berita }}">
    <!-- Meta tags for Open Graph -->
    <meta property="og:title" content="{{ $berita->judul_berita }}">
    <meta property="og:description" content="{{ $berita->deskripsi_berita }}">
    <meta property="og:image" content="{{ asset('storage/berita/' . $berita->gambar_berita) }}">
    <meta property="og:url" content="{{ route('blog.show', $berita->slug_berita) }}">
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
                                <h1 data-aos="fade-up" data-aos-delay="">{{ $title }}</h1>
                                <p class="mb-5" data-aos="fade-up" data-aos-delay="100">{{ $berita->judul_berita }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
        <!-- ======= Blog Single Section ======= -->
        <section id="blog" class="blog">
            <div class="container" data-aos="fade-up">

                <div class="row">

                    <div class="col-lg-8 entries">

                        <article class="entry entry-single">

                            <div class="entry-img">
                                <img src="{{ asset('storage/berita/' . $berita->gambar_berita) }}" alt=""
                                    class="img-fluid">
                            </div>

                            <h2 class="entry-title">
                                <a href="{{ route('blog.show', $berita->slug_berita) }}">{{ $berita->judul_berita }}</a>
                            </h2>
                            <div class="entry-meta">
                                <ul>
                                    <li class="d-flex align-items-center"><i class="bi bi-person"></i> <a
                                            href="{{ route('blog.show', $berita->slug_berita) }}">{{ $berita->penulis }}</a>
                                    </li>

                                    @php
                                        $bulan = bulan_indonesia(date('m', strtotime($berita->tgl_berita)));
                                        $hari = date('d', strtotime($berita->tgl_berita));
                                        $tahun = date('Y', strtotime($berita->tgl_berita));
                                    @endphp
                                    <li class="d-flex align-items-center"><i class="bi bi-clock"></i> <a
                                            href="{{ route('blog.show', $berita->slug_berita) }}"><time
                                                datetime="2020-01-01">{{ "$hari $bulan, $tahun" }}</time></a></li>
                                </ul>
                            </div>

                            <div class="entry-content">
                                {!! $berita->isi_berita !!}
                            </div>

                        </article><!-- End blog entry -->

                    </div><!-- End blog entries list -->

                    <div class="col-lg-4">

                        <div class="sidebar">

                            <h3 class="sidebar-title">Search</h3>
                            <div class="sidebar-item search-form">
                                <form action="">
                                    <input type="text">
                                    <button type="submit"><i class="bi bi-search"></i></button>
                                </form>
                            </div><!-- End sidebar search formn-->

                            <h3 class="sidebar-title">Recent Posts</h3>
                            <div class="sidebar-item recent-posts">
                                @foreach ($blogs as $blog)
                                    @php
                                        $bulanBlog = bulan_indonesia(date('m', strtotime($blog->tgl_berita)));
                                        $hariBlog = date('d', strtotime($blog->tgl_berita));
                                        $tahunBlog = date('Y', strtotime($blog->tgl_berita));
                                    @endphp
                                    <div class="post-item clearfix">
                                        <img src="{{ asset('storage/berita/' . $blog->gambar_berita) }}" alt="">
                                        <h4><a
                                                href="{{ route('blog.show', $blog->slug_berita) }}">{{ $blog->judul_berita }}</a>
                                        </h4>
                                        <time datetime="2020-01-01">{{ "$hariBlog $bulanBlog, $tahunBlog" }}</time>
                                    </div>
                                @endforeach

                            </div><!-- End sidebar recent posts-->

                        </div><!-- End sidebar -->

                    </div><!-- End blog sidebar -->

                </div>

            </div>
        </section><!-- End Blog Single Section -->

        @include('content.landing-page.content-footer')


    </main><!-- End #main -->
@endsection
@section('pageScript')
    <!-- Template Main JS File -->
    <script src="{{ asset('assets/landing-page') }}/js/main.js"></script>
@endsection
