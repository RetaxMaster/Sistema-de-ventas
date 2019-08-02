@extends('template/template')

@section('style')
<link rel="stylesheet" href="{{ asset(env("css")."user.css") }}">
@endsection

@section("title", "Usuario");

@section('content')
<div class="content" id="UserForm">
    <form class="card" action="#" method="post">
        <h1><i class="fas fa-user"></i> Inicia sesión</h1>
        <div class="form-group">
            <label for="Username">Nombre de usuario:</label>
            <input type="text" class="form-control" id="Username" placeholder="Nombre de usuario">
        </div>
        <div class="form-group">
            <label for="Password">Contraseña:</label>
            <input type="text" class="form-control" id="Password" placeholder="Contraseña">
        </div>
        <div class="form-group">
            <label for="Rol">Tipo de venta:</label>
            <select class="form-control" id="Rol">
                <option value="1" selected>Vendedor</option>
                <option value="2">Administrador</option>
            </select>
        </div>
        <div class="button-container">
            <button class="btn btn-primary btn-lg btn-block">Iniciar sesión</button>
        </div>
    </form>
</div>
@endsection
