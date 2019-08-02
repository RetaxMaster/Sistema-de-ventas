<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset(env("css")."bootstrap.min.css") }}">
    <link rel="stylesheet" href="{{ asset(env("css")."all.min.css") }}">
    <link rel="stylesheet" href="{{ asset(env("css")."style.css") }}">
    <link rel="stylesheet" href="{{ asset(env("css")."grid.css") }}">
    @yield('style', '')
    <title>@yield('title', 'Ventas')</title>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01"
                aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        
            <div class="collapse navbar-collapse" id="navbarColor01">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route("ventas") }}">Ventas<span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route("products") }}">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route("caja") }}">Caja</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route("vendidos") }}">Vendidos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route("register") }}">Registrar usuario</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-power-off"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    @yield('content', '')

    <script src="{{ asset(env("js")."all.min.js") }}"></script>

</body>
</html>