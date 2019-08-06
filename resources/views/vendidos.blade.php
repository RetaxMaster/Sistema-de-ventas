@extends('template/template')

@section('style')
<link rel="stylesheet" href="{{ asset(env("css")."vendidos.css") }}">
<link rel="stylesheet" href="{{ asset(env("css")."queries-vendidos.css") }}">
@endsection

@section("title", "Vendidos")

@section('scripts')
<script src="{{ asset(env("js")."output/vendidos.bundle.js") }}"></script>    
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
                <div class="modal-card" id="sold-products">
                    <h2>Comentario</h2>
                    <p class="description">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Delectus nemo recusandae velit nam similique aperiam nisi sequi odit, rerum illo ipsam officiis molestias vel? In animi quis possimus est maiores.</p>
                    <h2>Productos</h2>
                    <div class="all-products">
                    </div>
                    <div class="button-container">
                        <a href="#" id="edit"><button class="btn btn-primary">Editar</button></a>
                        <button class="btn btn-success">Descargar ticket</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-1 close-modal"></div>
        </div>
    </div>
</div>
<div class="content" id="Vendidos">
    <h1>Productos vendidos</h1>
    <section class="card" id="AllProducts">
        <div class="search">
            <div class="row">
                <div class="col-12 col-md-6">        
                    <input type="text" id="StartDate" class="form-control" placeholder="Fecha de inicio">
                </div>
                <div class="col-12 col-md-6">                            
                    <input type="text" id="EndDate" class="form-control" placeholder="Fecha de fin" disabled>
                </div>
            </div>
        </div>
        <div class="all-products">
            @forelse ($sales as $sale)
                <article class="sale" id="s{{ $sale->id }}">
                    <div class="sect">
                        <h3>{{ $sale->userinfo->username }} vendió:</h3>
                        <span>{{ count($sale->solds) }} productos</span>
                    </div>
                    <div class="sect">
                        <h3>Fecha:</h3>
                        <span>{{ get_short_date_from_timestamp($sale->created_at) }} a las {{ get_time_from_timestamp($sale->created_at) }}</span>
                    </div>
                    <div class="sect">
                        <h3>Importe:</h3>
                        <span class="price">{{ parse_money($sale->total) }} ARS</span>
                    </div>
                </article>
            @empty
            <article class="no-products">
                No hay ventas aún
            </article>
            @endforelse
        </div>
    </section>
    @if ($showPagination)
    <nav>
        <ul class="pagination">
            @if ($prev != null)
            <li class="page-item disabled">
                <a class="page-link" href="#">&laquo;</a>
            </li>
            @endif
            @for ($i = $start_for, $j=0; $i <= $totalPages && $j < 5; $i++, $j++)    
            <li class="page-item {{ ($page == $i) ? "active" : "" }}">
                <a class="page-link" href="{{ route("vendidos", ["page" => $i]) }}">{{ $i }}</a>
            </li>
            @endfor
            @if ($next != null)
            <li class="page-item">
                <a class="page-link" href="#">&raquo;</a>
            </li>
            @endif
        </ul>
    </nav>
    @endif
</div>
@endsection