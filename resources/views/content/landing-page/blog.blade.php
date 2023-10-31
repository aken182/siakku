@extends('layouts.landingMaster')
@section('title', "$title")
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
                <div class="row mb-5">
                    <div class="col-md-4">
                        <div class="post-entry">
                            <a href="blog-single.html" class="d-block mb-4">
                                <img src="{{ asset('assets/landing-page') }}/img/img_1.jpg" alt="Image"
                                    class="img-fluid">
                            </a>
                            <div class="post-text">
                                <span class="post-meta">December 13, 2019 &bullet; By <a href="#">Admin</a></span>
                                <h3><a href="#">Chrome now alerts you when someone steals your password</a></h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem, optio.</p>
                                <p><a href="#" class="readmore">Read more</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="post-entry">
                            <a href="blog-single.html" class="d-block mb-4">
                                <img src="{{ asset('assets/landing-page') }}/img/img_2.jpg" alt="Image"
                                    class="img-fluid">
                            </a>
                            <div class="post-text">
                                <span class="post-meta">December 13, 2019 &bullet; By <a href="#">Admin</a></span>
                                <h3><a href="#">Chrome now alerts you when someone steals your password</a></h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem, optio.</p>
                                <p><a href="#" class="readmore">Read more</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="post-entry">
                            <a href="blog-single.html" class="d-block mb-4">
                                <img src="{{ asset('assets/landing-page') }}/img/img_3.jpg" alt="Image"
                                    class="img-fluid">
                            </a>
                            <div class="post-text">
                                <span class="post-meta">December 13, 2019 &bullet; By <a href="#">Admin</a></span>
                                <h3><a href="#">Chrome now alerts you when someone steals your password</a></h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem, optio.</p>
                                <p><a href="#" class="readmore">Read more</a></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="post-entry">
                            <a href="blog-single.html" class="d-block mb-4">
                                <img src="{{ asset('assets/landing-page') }}/img/img_4.jpg" alt="Image"
                                    class="img-fluid">
                            </a>
                            <div class="post-text">
                                <span class="post-meta">December 13, 2019 &bullet; By <a href="#">Admin</a></span>
                                <h3><a href="#">Chrome now alerts you when someone steals your password</a></h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem, optio.</p>
                                <p><a href="#" class="readmore">Read more</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="post-entry">
                            <a href="blog-single.html" class="d-block mb-4">
                                <img src="{{ asset('assets/landing-page') }}/img/img_3.jpg" alt="Image"
                                    class="img-fluid">
                            </a>
                            <div class="post-text">
                                <span class="post-meta">December 13, 2019 &bullet; By <a href="#">Admin</a></span>
                                <h3><a href="#">Chrome now alerts you when someone steals your password</a></h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem, optio.</p>
                                <p><a href="#" class="readmore">Read more</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="post-entry">
                            <a href="blog-single.html" class="d-block mb-4">
                                <img src="{{ asset('assets/landing-page') }}/img/img_2.jpg" alt="Image"
                                    class="img-fluid">
                            </a>
                            <div class="post-text">
                                <span class="post-meta">December 13, 2019 &bullet; By <a href="#">Admin</a></span>
                                <h3><a href="#">Chrome now alerts you when someone steals your password</a></h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem, optio.</p>
                                <p><a href="#" class="readmore">Read more</a></p>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-12 text-center">
                        <span class="p-3 active text-primary">1</span>
                        <a href="#" class="p-3">2</a>
                        <a href="#" class="p-3">3</a>
                        <a href="#" class="p-3">4</a>
                    </div>
                </div>
            </div>

        </section>

        <!-- ======= CTA Section ======= -->
        <section class="section cta-section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 me-auto text-center text-md-start mb-5 mb-md-0">
                        <h2>Starts Publishing Your Apps</h2>
                    </div>
                    <div class="col-md-5 text-center text-md-end">
                        <p><a href="#" class="btn d-inline-flex align-items-center"><i
                                    class="bx bxl-apple"></i><span>App store</span></a> <a href="#"
                                class="btn d-inline-flex align-items-center"><i class="bx bxl-play-store"></i><span>Google
                                    play</span></a></p>
                    </div>
                </div>
            </div>
        </section><!-- End CTA Section -->

    </main><!-- End #main -->
@endsection
@section('pageScript')
    <!-- Template Main JS File -->
    <script src="{{ asset('assets/landing-page') }}/js/main.js"></script>
@endsection
