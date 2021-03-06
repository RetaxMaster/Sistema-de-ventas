<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset(env("css")."bootstrap.min.css") }}">
    <link rel="stylesheet" href="{{ asset(env("css")."flatpickr.css") }}">
    <link rel="stylesheet" href="{{ asset(env("css")."style.css") }}">
    <link rel="stylesheet" href="{{ asset(env("css")."grid.css") }}">
    <link rel="stylesheet" href="{{ asset(env("css")."modal.css") }}">
    <link rel="stylesheet" href="{{ asset(env("css")."queries.css") }}">
    @yield('style', '')
    <title>@yield('title', 'Ventas')</title>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <a class="navbar-brand" href="{{ route("ventas") }}">
                <div class="image-container">
                    <img src="{{ asset(env("site_images")."logo.jpg") }}" alt="Logo">
                </div>
            </a>

            @if (auth()->user())
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01"
                aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        
            <div class="collapse navbar-collapse" id="navbarColor01">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route("ventas") }}">Ventas</a>
                    </li>
                    @if (auth()->user()->rol == 2)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route("products") }}">Productos</a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route("caja") }}">Caja</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route("vendidos", ["page" => 1]) }}">Vendidos</a>
                    </li>
                    @if (auth()->user()->rol == 2)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route("register") }}">Registrar usuario</a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route("logout") }}">
                            <i class="fas fa-power-off"></i>
                        </a>
                    </li>
                </ul>
            </div>
            @endif
        </nav>
    </header>

    @yield('content', '')

    @routes
    <script>
        const ajaxRequests = "/ajax-requests";
        const uploaded_images = "{{ env("uploaded_images") }}";
        const product_route = "{{ route("product", ["product" => 1]) }}".slice(0, -1);
    </script>
    <script src="{{ asset(env("js")."/lib/all.min.js") }}"></script>
    <script src="{{ asset(env("js")."/lib/bootstrap.min.js") }}"></script>
    <script src="{{ asset(env("js")."/lib/modifiers.js") }}"></script>

    @yield('scripts', '')

</body>
</html>