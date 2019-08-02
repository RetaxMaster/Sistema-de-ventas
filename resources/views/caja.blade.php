@extends('template/template')

@section('style')
<link rel="stylesheet" href="{{ asset(env("css")."caja.css") }}">
<link rel="stylesheet" href="{{ asset(env("css")."queries-caja.css") }}">
@endsection

@section("title", "Caja")

@section('scripts')
<script src="{{ asset(env("js")."output/caja.bundle.js") }}"></script>    
@endsection

@section('content')
<div class="content" id="Caja">
    <section>
        <h2><i class="fas fa-cash-register"></i> Caja</h2>
        <div class="card">
            <div class="row">
                <div class="col-12 col-sm-6 form-group">
                    <label for="withdrawals">Retirar dinero:</label>
                    <input type="text" id="withdrawals" class="form-control" placeholder="Ej. 200.00">
                    <div class="button-container action-button">
                        <button class="btn btn-success" id="Retirar">Retirar</button>
                    </div>
                </div>
                <div class="col-12 col-sm-6 form-group">
                    <label for="setInitial">Establecer monto inicial:</label>
                    <input type="text" id="setInitial" class="form-control" placeholder="Ej. 200.00">
                    <div class="button-container action-button">
                        <button class="btn btn-success" id="Establecer">Establecer</button>                        
                    </div>
                </div>
            </div>
            <div class="balance">
                <span class="price">$<span id="Total">100.00</span> ARS</span>
            </div>
            <div class="button-container">
                <button class="btn btn-success btn-lg" id="close-cash-register">Cerrar caja</button>
                <button class="btn btn-success btn-lg hidden" id="open-cash-register">Abrir caja</button>
            </div>
        </div>
    </section>
    <section>
        <h2><i class="fas fa-redo-alt"></i> Historial</h2>
        <div class="card" id="AllLogs">
            <article class="no-logs">
                Aún no hay registros
            </article>
            {{-- <article class="log">
                <div class="Info">
                    <span class="user">Usuario:</span>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi eius natus ea dolorum, nemo eligendi labore iusto consequuntur iure, eveniet nisi? Iusto ipsum eligendi cupiditate minima. Tempora impedit nulla facere!</p>
                </div>
                <time datetime="">
                    30/07/2019 <br> 8:00 a.m
                </time>
            </article> --}}
        </div>
    </section>
</div>
@endsection