<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ URL::asset('images/icon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ URL::asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/nicepage.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>@yield('title') | Conton</title>
</head>
<body>
<div class="wrapper">
    <header class="p-2 bg-white text-muted border-bottom header-base">
        <div class="px-4">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="{{ route('index') }}" class="d-flex align-items-center mb-2 mb-lg-0 me-5 text-white text-decoration-none logo" style="width: 135px">
                    <img src="{{ URL::asset('images/logo.png') }}" alt="Conton" style="width: 125px">
                </a>
                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0 text-decoration-none">
                    <li><a href="{{ route('index') }}" class="nav-link px-2 {{ request()->routeIs('index') ? 'text-active fw-bold' : null }}">Главная</a></li>
                    <li><a href="{{ route('about') }}" class="nav-link px-2 {{ request()->routeIs('about') ? 'text-active fw-bold' : null }}">О нас</a></li>
                    @auth
                        <li><a href="{{ route('order.add') }}" class="nav-link px-2 {{ request()->routeIs('order.add') ? 'text-active fw-bold' : null }}">Сделать заказ</a></li>
                        <li><a href="{{ route('travel') }}" class="nav-link px-2 {{ request()->routeIs('travel') ? 'text-active fw-bold' : null }}">Доставить заказ</a></li>
                    @endauth
                </ul>
                @guest
                    <div class="text-end">
                        <a class="btn btn-outline-dark me-2" href="{{ route('login') }}">Авторизация</a>
                        <a class="btn btn-outline-dark" href="{{ route('register') }}">Регистрация</a>
                    </div>
                @endguest
                @auth
                    <div class="link-lk ms-3">
                        <div class="auth-photo">
                            <button class="d-flex align-items-center link-menu" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                                <img src="{{ Auth::user()->photo_profile_path ? Storage::url(Auth::user()->photo_profile_path) : URL::asset('images/lk/user.png') }}" class="profile_photo object-fit-cover me-2" alt="profile_photo">
                                {{ Auth::user()->first_name }}
                            </button>
                        </div>
                    </div>
                    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                        <div class="offcanvas-header mt-3">
                            <button type="button" class="fa-solid fa-arrow-right fa-xl menu-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body d-flex flex-column">
                            <ul class="nav nav-pills flex-column mb-auto" id="menu">
                                <li class="nav-item menu-item">
                                    <a href="{{ route('user.settings') }}" class="d-flex btn btn-lg w-100 justify-content-between align-items-center">
                                        Настройки
                                        <i class="fa-solid fa-gear fa-lg"></i>
                                    </a>
                                </li>
                                <li class="nav-item menu-item">
                                    <a href="{{ route('user.trips') }}" class="d-flex btn btn-lg w-100 justify-content-between align-items-center">
                                        Поездки
                                        <i class="fa-solid fa-route fa-lg"></i>
                                    </a>
                                </li>
                                <li class="nav-item menu-item">
                                    <a href="{{ route('user.orders') }}" class="d-flex btn btn-lg w-100 justify-content-between align-items-center">
                                        Заказы
                                        <i class="fa-solid fa-bag-shopping fa-lg"></i>
                                    </a>
                                </li>
                            </ul>
                            <div class="dropdown menu-item">
                                <form action="{{ route('logout') }}" method="POST" class="form-inline">
                                    @csrf
                                    <button type="submit" class="btn-logout d-flex btn btn-lg w-100 justify-content-between align-items-center">
                                        Выйти из аккаунта
                                        <i class="fa-solid fa-arrow-right-from-bracket fa-rotate-180 fa-lg"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </header>
    <main class="main">
        @yield('main')
    </main>
    <div class="container">
        <footer class="row row-cols-1 row-cols-sm-2 row-cols-md-5 py-5 border-top">
            <div class="col mb-3 d-flex flex-column justify-content-between">
                <a href="/" class="d-flex align-items-center mb-3 link-dark text-decoration-none">
                    <img src="{{ URL::asset('images/logo.png') }}" alt="Conton" style="width: 125px">
                </a>
                <p class="footer_copy">&#169;2022 Conton, Inc. Все права защищены.</p>
            </div>
            <div class="col mb-3">
            </div>
            <div class="col mb-3">
            </div>
            <div class="col mb-3">
                <ul class="nav flex-column link">
                    <li class="nav-item mb-2 footer-link"><a href="{{ route('index') }}" class="p-0 link_item">Главная</a></li>
                    <li class="nav-item mb-2 footer-link"><a href="{{ route('about') }}" class="p-0 link_item">О нас</a></li>
                    <li class="nav-item mb-2 footer-link"><a href="{{ route('home') }}" class="p-0 link_item">Действия</a></li>
                    <li class="nav-item mb-2 footer-link"><a href="{{ route('terms') }}" class="p-0 link_item">Условия использования</a></li>
                    <li class="nav-item mb-2 footer-link"><a href="{{ route('policy') }}" class="p-0 link_item">Политика конфиденциальности</a></li>

                </ul>
            </div>
            <div class="col mb-3">
                <ul class="list-unstyled d-flex">
                    <li class="ms-3"><a class="link_item" href="https://twitter.com/kokhnovets" target="_blank"><i class="fa-brands fa-twitter fa-xl"></i></a></li>
                    <li class="ms-3"><a class="link_item" href="https://instagram.com/kokhnovets" target="_blank"><i class="fa-brands fa-instagram fa-xl"></i></a></li>
                    <li class="ms-3"><a class="link_item" href="https://facebook.com/kokhnovets" target="_blank"><i class="fa-brands fa-facebook fa-xl"></i></a></li>
                    <li class="ms-3"><a class="link_item" href="https://vk.com/kokhnovets" target="_blank"><i class="fa-brands fa-vk fa-xl"></i></a></li>
                    <li class="ms-3"><a class="link_item" href="https://youtube.com/" target="_blank"><i class="fa-brands fa-youtube fa-xl"></i></a></li>
                </ul>
            </div>
        </footer>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<script src="https://unpkg.com/imask"></script>
<script src="{{ URl::asset('js/app.js') }}"></script>
<script src="https://kit.fontawesome.com/4ca289f29e.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
</body>
</html>
