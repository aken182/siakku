<header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex justify-content-between align-items-center">

        <div class="logo">
            <h1><a href="{{ route('home') }}">KPRI Usaha Jaya</a></h1>
            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <a href="{{ route('home') }}"><img src="assets/landing-page/img/logo.png" alt="" class="img-fluid"></a>-->
        </div>

        <nav id="navbar" class="navbar">
            @php
                $route = Route::currentRouteName();
            @endphp
            <ul>
                <li><a class="{{ $route === 'home' ? 'active' : '' }}" href="{{ route('home') }}">Home</a></li>
                <li><a class="{{ $route === 'features' ? 'active' : '' }}" href="{{ route('features') }}">Features</a>
                </li>
                <li><a class="{{ $route === 'blog' ? 'active' : '' }}" href="{{ route('blog') }}">Blog</a></li>
                <li><a class="{{ $route === 'profil' ? 'active' : '' }}" href="{{ route('profil') }}">Profil</a></li>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->

    </div>
</header>
