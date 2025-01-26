<menu class="active">
    <ul>
        <li>
            <a class="btn-menu" href="{{ route('home')}}" {{ Request::routeIs('home') ? 'nav-active=true' : '' }}>
                <i class="fa-solid fa-house-fire"></i> Home</a>
        </li>
        <li>
            @can('admin_access')
                <a class="btn-menu" href="{{ route('user.index')}}" {{ Request::routeIs('user*') ? 'nav-active=true' : '' }}>
                    <i class="fa-solid fa-user-group"></i> Usuários</a>
            @endcan
        </li>
    </ul>
</menu>
