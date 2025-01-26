<menu class="active">
    <ul>
        <li>
            <a class="btn-menu" href="{{ route('home') }}" {{ Request::routeIs('home') ? 'nav-active=true' : '' }}>
                <i class="fa-solid fa-house-fire"></i> Home</a>
        </li>
        @can('admin_access')
            <li>
                <a class="btn-menu" href="{{ route('user.index') }}" {{ Request::routeIs('user*') ? 'nav-active=true' : '' }}>
                    <i class="fa-solid fa-user-group"></i> Usuários</a>
            </li>
        @endcan
        <li>
            <a class="btn-menu" href="{{ route('tasks.index') }}" {{ Request::routeIs('tasks*') ? 'nav-active=true' : '' }}>
                <i class="fa-solid fa-clipboard-list"></i> Tarefas</a>
        </li>
    </ul>
</menu>
