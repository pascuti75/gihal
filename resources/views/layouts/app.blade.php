{{-- Plantilla base --}}
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ URL::to('/') }}/favicon.ico">

    <title>GIHAL</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- bootstrap -->
    <link rel="stylesheet" type="text/css" href="{{ url('/bootstrap/bootstrap.css') }}">
    <script src="{{ url('/bootstrap/bootstrap.js')}}"></script>

    <!-- estilos estaticos -->
    <link rel="stylesheet" type="text/css" href="{{ url('/css/app.css') }}">
    <!-- campos de tipo calendario-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- Scripts -->
    <script src="{{ url('/scripts/jquery-3.6.3/jquery-3.6.3.min.js')}}"></script>
    <script src="{{ url('/scripts/init.js')}}"></script>
    <!-- campos de tipo calendario-->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>

    <!-- @vite(['resources/sass/app.scss', 'resources/js/app.js'])-->

</head>

<body class="mb-4">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container-fluid">

                {{-- Logo y titulo de la aplicacion --}}
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                    <img class="me-2" src="{{ URL::to('/') }}/images/logo.png" width="50" height="50" alt="">
                    <span class="h2 m-0">
                        GIHAL
                    </span>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                    <span class="navbar-toggler-icon"></span>
                </button>

                {{-- Las opciones del menu se cargan en funcion del perfil de acceso asignado al usuario autentificado --}}
                <div id="navMenu" class="collapse navbar-collapse">
                    @if(Auth::check())

                    <ul class="navbar-nav me-auto">
                        {{-- Opciones para usuarios con nivel de acceso administrador --}}
                        @if(Auth::user()->es_administrador)
                        <li class="nav-item dropdown">
                            <a id="navbarAdministracion" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Administración
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarAdministracion">
                                <a class="dropdown-item" href="{{ route('usuario.index') }}">{{ __('Usuarios') }}</a>
                            </div>
                        </li>
                        @endif
                        {{-- Opciones para usuarios con nivel de acceso gestor --}}
                        @if(Auth::user()->es_gestor)
                        <li class="nav-item dropdown">
                            <a id="navbarGestion" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Gestiones
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarGestion">
                                <a class="dropdown-item" href="{{ route('ubicacion.index') }}">{{ __('Ubicaciones') }}</a>
                                <a class="dropdown-item" href="{{ route('persona.index') }}">{{ __('Personas') }}</a>
                                <a class="dropdown-item" href="{{ route('contratacion.index') }}">{{ __('Contrataciones') }}</a>
                                <a class="dropdown-item" href="{{ route('tipo_equipo.index') }}">{{ __('Tipos de Equipo') }}</a>
                                <a class="dropdown-item" href="{{ route('equipo.index') }}">{{ __('Equipos') }}</a>
                            </div>
                        </li>
                        @endif
                        {{-- Opciones para usuarios con nivel de acceso tecnico --}}
                        @if(Auth::user()->es_tecnico)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('operacion.index') }}">{{ __('Operaciones') }}</a>
                        </li>
                        @endif
                        {{-- Opciones para usuarios con nivel de acceso consultor --}}
                        @if(Auth::user()->es_consultor)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('consulta.index') }}">{{ __('Consultas') }}</a>
                        </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="{{ URL::to('/ayuda') }}">{{ __('Ayuda') }}</a>
                        </li>
                    </ul>
                    @endif

                    {{-- Definicion de botones de login y cerrar sesion --}}
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @endif

                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->username }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Cerrar sesión') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4">
            {{-- Muestra el contenido del extent content --}}
            @yield('content')
        </main>
    </div>
</body>
<footer class="text-center text-lg-start fixed-bottom">

    <div class="text-center">
        © 2023 GIHAL. Gestión de Inventario Hardware para Admininistraciones Locales.
    </div>
</footer>

</html>