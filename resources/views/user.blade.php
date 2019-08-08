    @extends('template/template')

@section('style')
<link rel="stylesheet" href="{{ asset(env("css")."user.css") }}">
<link rel="stylesheet" href="{{ asset(env("css")."queries-user.css") }}">
@endsection

@section("title", "Usuario")

@section('content')
<div class="content" id="UserForm">
    <form class="card" action="{{ route("$mode") }}" method="post">
        {{ csrf_field() }}
        @if ($mode == "register")
        <h1><i class="fas fa-user-plus"></i> Registrar un usuario</h1>        
        @else
        <h1><i class="fas fa-user"></i> Inicia sesión</h1>
        @endif
        <div class="form-group">
            <label for="Username">Nombre de usuario:</label>
            <input type="text" name="username" class="form-control {{ $errors->has("username") ? 'is-invalid' : '' }}" id="Username" placeholder="Nombre de usuario">
            <div class="invalid-feedback">
                Por favor escribe un usuario válido
            </div>
        </div>
        <div class="form-group">
            <label for="Password">Contraseña:</label>
            <input type="password" name="password" class="form-control {{ $errors->has("password") ? 'is-invalid' : '' }}" id="Password" placeholder="Contraseña">
            <div class="invalid-feedback">
                Por favor escribe una contraseña
            </div>
        </div>
        @if ($mode == "register")
        <div class="form-group">
            <label for="Rol">Tipo de venta:</label>
            <select class="form-control" id="Rol" name="rol">
                <option value="1" selected>Vendedor</option>
                <option value="2">Administrador</option>
            </select>
        </div>
        @endif
        @if ($mode == "register")
        <div class="button-container">
            <button class="btn btn-primary btn-lg btn-block" id="Register">Registrar</button>
        </div>
        @else
        <div class="button-container">
            <button class="btn btn-primary btn-lg btn-block" id="Login">Iniciar sesión</button>
        </div>
        @endif
        @if ($errors->has("login_failed"))
            <br>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {!! $errors->first("login_failed", ":message") !!}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (session()->has("registered"))
            <br>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get("registered") }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    </form>
</div>
@endsection
