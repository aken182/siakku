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
                        <h2 class="mb-4">Seamlessly Communicate</h2>
                        <p class="mb-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tenetur at reprehenderit
                            optio, laudantium eius quod, eum maxime molestiae porro omnis. Dolores aspernatur delectus
                            impedit incidunt dolore mollitia esse natus beatae.</p>
                        <p><a href="#">Read More</a></p>
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
                        <h2 class="mb-4">Gather Feedback</h2>
                        <p class="mb-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tenetur at reprehenderit
                            optio, laudantium eius quod, eum maxime molestiae porro omnis. Dolores aspernatur delectus
                            impedit incidunt dolore mollitia esse natus beatae.</p>
                        <p><a href="#">Read More</a></p>
                    </div>
                    <div class="col-md-6" data-aos="fade-right">
                        <img src="{{ asset('assets/landing-page') }}/img/undraw_svg_3.svg" alt="Image" class="img-fluid">
                    </div>
                </div>
            </div>
        </section>

        <section class="section pb-0">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-4 me-auto">
                        <h2 class="mb-4">Present Designs Inspiration</h2>
                        <p class="mb-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tenetur at reprehenderit
                            optio, laudantium eius quod, eum maxime molestiae porro omnis. Dolores aspernatur delectus
                            impedit incidunt dolore mollitia esse natus beatae.</p>
                        <p><a href="#">Read More</a></p>
                    </div>
                    <div class="col-md-6" data-aos="fade-left">
                        <img src="{{ asset('assets/landing-page') }}/img/undraw_svg_3.svg" alt="Image" class="img-fluid">
                    </div>
                </div>
            </div>
        </section>

        <section class="section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-4 ms-auto order-2">
                        <h2 class="mb-4">Powerful App Design </h2>
                        <p class="mb-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tenetur at reprehenderit
                            optio, laudantium eius quod, eum maxime molestiae porro omnis. Dolores aspernatur delectus
                            impedit incidunt dolore mollitia esse natus beatae.</p>
                        <p><a href="#">Read More</a></p>
                    </div>
                    <div class="col-md-6" data-aos="fade-right">
                        <img src="{{ asset('assets/landing-page') }}/img/undraw_svg_4.svg" alt="Image" class="img-fluid">
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
