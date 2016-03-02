{{-- Pantalla instituciones. URL: /instituciones --}}
@extends('layouts.base')

@section('title')
    Instituciones educativas participantes
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
                <h3 class="texto-azul">Instituciones educativas participantes</h3>
                <p>Las siguientes instituciones educativas participan activamente en el proyecto, con la
                    intención de brindarle a sus egresados una mejor posibilidad de inserción en le mercado
                    laboral:</p>
            </div>
        </div>

        <div class="contenedor-lista vista-listado listado-instituciones">
            <ul class="list-unstyled lista-2col">
            @foreach ($escuelas as $escuela)
                <li class="item">
                    @if ($escuela->foto)
                        {{-- Si hay foto, indico background_image: concateno el url de fotos recibido de parametro, y el nombre de archivo de la foto --}}
                        <figure class="foto-bg foto-item foto-no-link foto-institucion" style="background-image: url('{{$escuela->getUrlFoto()}}'); border-radius: 0;"></figure>
                    @else
                        {{-- Si no hay foto, se muestra foto generica desde CSS. --}}
                        <figure class="foto-bg foto-item foto-no-link foto-institucion sin-foto"></figure>
                    @endif

                    <div class="info-item">
                        <h4 class="texto-azul">{{$escuela->name}}</h4>

                        <div class="item-datos">
                            <p><strong>Ciudad:</strong> {{$escuela->localidad}}</p>
                            @if($escuela->direccion)
                            <p><strong>Dirección:</strong> {{$escuela->direccion}}</p>
                            @endif
                            @if($escuela->telefono)
                            <p><strong>Teléfono:</strong> {{$escuela->telefono}}</p>
                            @endif
                            @if($escuela->email)
                            <p><strong>Email:</strong> {{$escuela->email}}</p>
                            @endif
                        </div>
                    </div>
                </li>
            @endforeach
            </ul>
        </div> <!--/.contenedor-lista-->

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <p class="text-center texto-especial"><em>Si usted es <strong>directivo de una institución
                    educativa</strong> y
                    desea participar de la plataforma <strong>Mi Primer Trabajo</strong>, contáctese desde
                    aquí:</em></p>

                <a class="btn btn-registro" href="{{url('/solicitar-acceso')}}">Solicitar acceso a la plataforma</a>
            </div>
        </div>

    </main> <!--/contenido-instituciones-->
</div>
@endsection