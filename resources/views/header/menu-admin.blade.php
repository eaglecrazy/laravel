<li class="nav-item">
    <a class="nav-link" href="{{ route('Home', null, false) }}">Главная</a>
</li>
<li class="nav-item {{ request()->routeIs('admin.users.index') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.users.index', null, false) }}">Пользователи</a>
</li>
<li class="nav-item
    {{ request()->routeIs(['admin.news.index', 'admin.news.create', 'admin.news.edit']) ? 'active' : '' }}"
>
    <a class="nav-link" href="{{ route('admin.news.index', null, false) }}">Новости</a>
</li>


