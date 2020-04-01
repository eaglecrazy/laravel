<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">

        {{-- Логотип        --}}
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'MyNews') }}
        </a>

        {{-- Кнопка разворацивания меню        --}}
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                @yield('menu-left')
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                @yield('menu-right')
            </ul>
        </div>
    </div>
</nav>
