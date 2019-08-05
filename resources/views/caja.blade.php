@extends('template/template')

@section('style')
<link rel="stylesheet" href="{{ asset(env("css")."caja.css") }}">
<link rel="stylesheet" href="{{ asset(env("css")."queries-caja.css") }}">
@endsection

@section("title", "Caja")

@section('scripts')
<script>
let total = {{ $ammount }};
</script>
<script src="{{ asset(env("js")."output/caja.bundle.js") }}"></script>    
@endsection

@section('content')
<div class="modal" id="modal">
    <div class="modal-main">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-1 close-modal"></div>
            <div class="col-lg-6 col-md-6 col-sm-10 col-xs-12 close-modal">
                <div class="modal-card" id="loading">
                    <div class="preloader"></div>
                    <span class="tag">Cargando...</span>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-1 close-modal"></div>
        </div>
    </div>
</div>
<div class="content" id="Caja">
    <section>
        <h2><i class="fas fa-cash-register"></i> Caja</h2>
        <div class="card">
            <div class="row">
                <div class="col-12 col-sm-6 form-group">
                    <label for="withdrawals">Retirar dinero:</label>
                    <input type="text" id="withdrawals" class="form-control" placeholder="Ej. 200.00" {{ $disabled }}>
                    <div class="button-container action-button">
                        <button class="btn btn-success" id="Retirar" {{ $disabled }}>Retirar</button>
                    </div>
                </div>
                <div class="col-12 col-sm-6 form-group">
                    <label for="setInitial">Establecer monto inicial:</label>
                    <input type="text" id="setInitial" class="form-control" placeholder="Ej. 200.00" {{ $disabled }} >
                    <div class="button-container action-button">
                        <button class="btn btn-success" id="Establecer" {{ $disabled }}>Establecer</button>  
                    </div>
                </div>
            </div>
            <div class="balance">
                <span class="price"><span id="Total">{{ parse_money($ammount) }}</span> ARS</span>
            </div>
            <div class="button-container">
                <button class="btn btn-success btn-lg {{ $close_cash_register }}" id="close-cash-register">Cerrar caja</button>
                <button class="btn btn-success btn-lg {{ $open_cash_register }}" id="open-cash-register">Abrir caja</button>
            </div>
        </div>
    </section>
    <section>
        <h2><i class="fas fa-redo-alt"></i> Historial</h2>
        <div class="card" id="AllLogs">
            @forelse ($logs as $log)
            <article class="log" id="{{ $log->id }}">
                <div class="Info">
                    <span class="user">{{ $log->userinfo->username }}:</span>
                    <p>{{ $log->action }}</p>
                </div>
                <time datetime="{{ $log->created_at }}">
                    {{ get_short_date_from_timestamp($log->created_at) }} <br> {{ get_time_from_timestamp($log->created_at) }}
                </time>
            </article>
            @empty
            <article class="no-logs">
                Aún no hay registros
            </article>
            @endforelse
        </div>
        @if ($allLogs > 10)
            <div class="see-more">
                <span>Ver más</span>    
            </div>
        @endif
    </section>
</div>
@endsection