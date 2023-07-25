<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="#">{{ env('APP_NAME') }}</a>
        </div>

        <div class="sidebar-brand sidebar-brand-sm">
            <a href="#"><img src="{{ asset('assets/img/ball-192.png') }}" width="40%"></a>
        </div>

        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{ Request::routeIs('index') ? "active" : "" }}">
                <a class="nav-link" href="{{ route('index') }}">
                    <i class="fas fa-th"></i> <span>Dashboard</span>
                </a>
            </li>

            <li class="menu-header">Menu</li>
            <li class="{{ Request::routeIs('club.*') ? "active" : "" }}">
                <a class="nav-link" href="{{ route('club.index') }}">
                    <i class="fas fa-people-group"></i> <span>Klub</span>
                </a>
            </li>
            <li class="{{ Request::routeIs('match.*') ? "active" : "" }}">
                <a class="nav-link" href="{{ route('match.index') }}">
                    <i class="fas fa-gamepad"></i> <span>Pertandingan</span>
                </a>
            </li>

            <li class="{{ Request::routeIs('standings.*') ? "active" : "" }}">
                <a class="nav-link" href="{{ route('standings.index') }}">
                    <i class="fas fa-ranking-star"></i> <span>Klasemen</span>
                </a>
            </li>
        </ul>
    </aside>
</div>
