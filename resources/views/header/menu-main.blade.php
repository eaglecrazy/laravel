<li class="nav-item {{ request()->routeIs('Home') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('Home', null, false) }}">Главная</a>
</li>
<li class="nav-item {{ (request()->routeIs('news.all') || request()->routeIs('news.category')) ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('news.all', null, false) }}">Новости</a>
</li>
<li class="nav-item {{ request()->routeIs('Home') ? 'admin.index' : '' }}">
    <a class="nav-link" href="{{ route('admin.index', null, false) }}">Админка</a>
</li>
