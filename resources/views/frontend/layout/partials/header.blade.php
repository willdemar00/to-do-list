<header>
    <nav>
        <section class="d-flex align-items-center gap-1">
            <button id="menu-toggle" class="icon-menu btn-menu" >
                <i class="fa-solid fa-bars" style="font-size: 1.1rem;"></i>
            </button>
            <a class="d-flex align-items-center gap-1" href="{{ route('home') }}">
                <img class="logo" src="{{ asset('assets/img/logo.png') }}" alt="logo">
                <span class="logo-text">TaskFlow</span>
            </a>
        </section>
        <section>
            <div class="user-icon" hide-toggle="sidebar">
                <img src="{{ empty(Auth::user()) ? asset('assets/img/Profile_avatar_placeholder.png') : Auth::user()->path_image }}"
                    alt="">
            </div>
            @include('frontend.layout.partials.sidebar')
        </section>
    </nav>
</header>
