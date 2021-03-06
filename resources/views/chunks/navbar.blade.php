<nav class="navbar navbar-expand-md navbar-light navbar-laravel">
    <div class="container">
        @admin
        <a class="navbar-brand" href="{{ url('/admin') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        @endadmin
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                @admin
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.report.index') }}">Доклады</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.expert.index') }}">Жюри</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbar-dropdown"
                       role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Оценки
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbar-dropdown">
                        <a class="dropdown-item" href="{{ route('admin.results.index') }}">
                            Оценки конкурсной и экспертной комиссий
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.results.viewers') }}">Оценки зрителей</a>
                    </div>
                </li>
                @endadmin
                <li class="nav-item">
                    <a class="nav-link">Гостей
                        зарегистрировано: {{ \App\User::whereIsExpert(false)->whereIsAdmin(false)->count() }}</a>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    <li class="nav-item">
                        @if (Route::has('register'))
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        @endif
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('signout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('signout') }}" method="POST"
                                  style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>