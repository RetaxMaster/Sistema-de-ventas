@extends('template/template')

@section('style')
<link rel="stylesheet" href="css/caja.css">
@endsection

@section("title", "Caja");

@section('content')
<div class="content" id="Caja">
    <section>
        <h2><i class="fas fa-cash-register"></i> Caja</h2>
        <div class="card">
            <div class="row">
                <div class="col-12 col-sm-6 form-group">
                    <label for="withdrawals">Retirar dinero:</label>
                    <input type="text" id="withdrawals" class="form-control" placeholder="Ej. 200.00">
                </div>
                <div class="col-12 col-sm-6 form-group">
                    <label for="setInitial">Establecer monto inicial:</label>
                    <input type="text" id="setInitial" class="form-control" placeholder="Ej. 200.00">
                </div>
            </div>
            <div class="balance">
                <span class="price">$1,000.00 USD</span>
            </div>
            <div class="button-container">
                <button class="btn btn-success btn-lg">Cerrar caja</button>
            </div>
        </div>
    </section>
    <section>
        <h2><i class="fas fa-redo-alt"></i> Historial</h2>
        <div class="card" id="AllLogs">
            <article class="log">
                <div class="Info">
                    <span class="user">Usuario:</span>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi eius natus ea dolorum, nemo eligendi labore iusto consequuntur iure, eveniet nisi? Iusto ipsum eligendi cupiditate minima. Tempora impedit nulla facere!</p>
                </div>
                <time datetime="">
                    30/07/2019 <br> 8:00 a.m
                </time>
            </article>
        </div>
    </section>
</div>
@endsection