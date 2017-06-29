{{-- Pantalla instituciones. URL: /instituciones-educativas --}}
@extends('layouts.base')

@section('title')
    Instituciones educativas participantes
@endsection

@section('header')
    @include('layouts.header_menu')
@endsection

@section('content')
<div class="container">
    <main class="contenido-instituciones gap-header-acceso">

        <div class="row">
            <div class="col-md-8 col-sm-10">
                <!--<div class="col-xs-12">-->
                <h2 class="texto-azul">Instituciones educativas participantes</h2>
                <p>Las siguientes instituciones educativas participan activamente en el proyecto, con la
                    intención de brindarle a sus egresados una mejor posibilidad de inserción en le mercado
                    laboral:</p>
            </div>
        </div>

        <div class="contenedor-lista vista-listado listado-instituciones">
            <ul class="list-unstyled lista-2col">
            @foreach ($instituciones as $institucion)
                <li class="item">
                    @if ($institucion->foto)
                        {{-- Si hay foto, indico background_image: concateno el url de fotos recibido de parametro, y el nombre de archivo de la foto --}}
                        <figure class="foto-bg foto-item foto-no-link foto-institucion" style="background-image: url('{{$institucion->getUrlFoto()}}'); border-radius: 0;"></figure>
                    @else
                        {{-- Si no hay foto, se muestra foto generica desde CSS. --}}
                        <figure class="foto-bg foto-item foto-no-link foto-institucion sin-foto"></figure>
                    @endif

                    <div class="info-item">
                        <h4 class="texto-azul">{{$institucion->name}}</h4>
                        <p class="subtitulo">{{$institucion->getTipoLabel()}}</p>

                        <div class="item-datos">
                            @if($institucion->localidad)
                            <p><strong>Localidad:</strong> {{$institucion->localidad}}</p>
                            @endif
                            @if($institucion->direccion)
                            <p><strong>Dirección:</strong> {{$institucion->direccion}}</p>
                            @endif
                            @if($institucion->telefono)
                            <p><strong>Teléfono:</strong> {{$institucion->telefono}}</p>
                            @endif
                            @if($institucion->email)
                            <p><strong>Email:</strong> {{$institucion->email}}</p>
                            @endif
                        </div>
                    </div>
                </li>
            @endforeach
            </ul>
        </div> <!--/.contenedor-lista-->

    {{-- Link solicitar acceso: pantalla deshabilitada
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <p class="text-center texto-especial"><em>Si usted es <strong>directivo de una institución
                    educativa</strong> y
                    desea participar de la plataforma <strong>Mi Primer Trabajo</strong>, contáctese desde
                    aquí:</em></p>

                <a class="btn btn-registro" href="{{url('/solicitar-acceso')}}">Solicitar acceso a la plataforma</a>
            </div>
        </div>
    --}}

    </main> <!--/contenido-instituciones-->
</div>
@endsection