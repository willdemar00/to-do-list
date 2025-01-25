<div class="sidebar close" area-hide-toggle="sidebar">
    <ul>
        <li>
            <a class="btn-menu" href="{{ route('profile.edit') }}">
                <i class="fa-solid fa-user"></i> Perfil
            </a>
        </li>
        <li class="line-divides"></li>
        <li>
            <form action="{{ route('logout') }}" method="post" class="p-0 w-100">
                @csrf
                <button class="btn-menu w-100" href="" type="submit">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i> Sair
                </button>
            </form>
        </li>
    </ul>
</div>
