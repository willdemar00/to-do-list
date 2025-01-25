<header>
    <nav>
        <section class="d-flex align-items-center gap-1">
            <button id="menu-toggle" class="icon-menu btn-menu" >
                <i class="fa-solid fa-bars" style="font-size: 1.1rem;"></i>
            </button>
            <a class="d-flex align-items-center gap-1" href="{{ route('home') }}">
                <img class="logo" src="{{ asset('build/assets/img/logo.png') }}" alt="logo">
                <span class="logo-text">TaskFlow</span>
            </a>
        </section>
        <section>
            <div class="search-icon">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input id="seach-input" type="text" name="" placeholder="O que você procura?">
                {{-- 
                <div class="list-itens">
                    <div class="itens-search gap-10" loading="infinite">
                        <div class="conteiner-img">
                            <img height="100px" src="https://via.placeholder.com/100" alt="icons">
                        </div>
                        <h4>Sem descrição disponível</h4>
                        <p>Sem descrição disponível</p>
                    </div>
                </div> --}}
            </div>
        </section>
        <section>
            <div class="user-icon" hide-toggle="sidebar">
                <img src="{{ empty(Auth::user()) ? asset('build/assets/img/Profile_avatar_placeholder.png') : Auth::user()->path_image }}"
                    alt="">
            </div>
            @include('frontend.layout.partials.sidebar')
        </section>
    </nav>
</header>
