<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">

        {{-- Логотип        --}}
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'MyNews') }}
        </a>

        {{-- Кнопка разворацивания меню        --}}
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

                {{-- Меню для всех пользователей --}}
                <li class="nav-item {{ request()->routeIs('Home') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('Home', null, false) }}">Главная</a>
                </li>

                <li class="nav-item @if(preg_match("/^news./", request()->route()->getName())) active @endif">
                    <a class="nav-link" href="{{ route('news.all', null, false) }}">Новости</a>
                </li>

                @if(Auth::user() && Auth::user()->role)
                    <li class="nav-item btn-group @if(preg_match("/^admin./", request()->route()->getName())) active @endif ">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Админка</a>
                        <ul class="dropdown-menu">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.news.index', null, false) }}">Новости</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.users', null, false) }}">Пользователи</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.news.import', null, false) }}">Импорт новостей</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.news.export', null, false) }}">Экспорт новостей</a>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->

                @guest
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}"
                           href="{{ route('login') }}">{{ __('Войти') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('register') ? 'active' : '' }}"
                               href="{{ route('register') }}">{{ __('Регистрация') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown my-auto">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('user.show', Auth::user()) }}">Профиль</a>

                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Выход') }}</a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                    @if(Auth::user()->avatar)
                        <img src="{{ Auth::user()->avatar }}" alt="аватар" class="rounded-circle" height="50" width="50">
                    @endif
                @endguest

            </ul>
        </div>
    </div>
</nav>
