{{-- Pantalla instituciones. URL: /empresas --}}
@extends('layouts.base')

@section('title')
    Empresas asociadas a la UIBB
@endsection

@section('header')
    @include('layouts.header_simple_acceso')
@endsection

@section('content')
<div class="container">
    <main class="contenido-instituciones gap-header-acceso">

        <div class="row">
            <div class="col-md-8 col-sm-10">
                <!--<div class="col-xs-12">-->
                <h3 class="texto-azul">Empresas Asociadas</h3>
                <p>Las siguientes empresas asociadas a la UIBB hacen uso de la plataforma <strong>Mi Primer
                    Empleo</strong>, como parte de su estrategia de búsqueda de recursos humanos calificados:</p>
            </div>
        </div>

        <div class="contenedor-lista vista-listado listado-instituciones">
            <ul class="list-unstyled lista-2col">
            @foreach ($empresas as $empresa)
                <li class="item">
                    @if ($empresa->foto)
                        {{-- Si hay foto, indico background_image: concateno el url de fotos recibido de parametro, y el nombre de archivo de la foto --}}
                        <figure class="foto-bg foto-item foto-no-link foto-asociado" style="background-image: url('{{$empresa->getUrlFoto()}}');"></figure>
                    @else
                        {{-- Si no hay foto, se muestra foto generica desde CSS. --}}
                        <figure class="foto-bg foto-item foto-no-link foto-asociado sin-foto"></figure>
                    @endif

                    <div class="info-item">
                        <h4 class="texto-azul">{{$empresa->name}}</h4>

                        <div class="item-datos">
                            <p><strong>Ciudad:</strong> {{$empresa->localidad}}</p>
                            @if($empresa->direccion)
                            <p><strong>Dirección:</strong> {{$empresa->direccion}}</p>
                            @endif
                            @if($empresa->telefono)
                            <p><strong>Teléfono:</strong> {{$empresa->telefono}}</p>
                            @endif
                            @if($empresa->email)
                            <p><strong>Email:</strong> {{$empresa->email}}</p>
                            @endif
                        </div>
                    </div>
                </li>
            @endforeach
            </ul>
        </div> <!--/.contenedor-lista-->

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <p class="text-center texto-especial"><em>Si usted es <strong>asociado a la UIBB</strong> y
                    desea participar de la plataforma <strong>Mi Primer Trabajo</strong>, contáctese desde
                    aquí:</em></p>

                <a class="btn btn-registro" href="{{url('/solicitar-acceso')}}">Solicitar acceso a la plataforma</a>
            </div>
        </div>

    </main>
</div>
@endsection