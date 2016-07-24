{{-- Pantalla instituciones. URL: /empresas
        NO UTILIZADA (route deshabilitado)
 --}}
@extends('layouts.base')

@section('title')
    Empresas asociadas a la UIBB
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
                <h2 class="texto-azul">Empresas Asociadas</h2>
                <p>Las siguientes empresas asociadas a la UIBB hacen uso de la plataforma <strong>Mi Primer
                    Empleo</strong>, como parte de su estrategia de búsqueda de recursos humanos calificados:</p>
            </div>
        </div>

        <div class="contenedor-lista vista-listado listado-instituciones">
            <ul class="list-unstyled lista-2col">
                {{-- <li class="item">
                    {{- Si hay foto, indico background_image: concateno el url de fotos recibido de parametro, y el nombre de archivo de la foto -}}
                    <figure class="foto-bg foto-item foto-no-link foto-asociado" style="background-image: url('{{$empresa->getUrlFoto()}}');"></figure>
                    {{- Si no hay foto, se muestra foto generica desde CSS. -}}
                    <figure class="foto-bg foto-item foto-no-link foto-asociado sin-foto"></figure>

                    <div class="info-item">
                        <h4 class="texto-azul"></h4>

                        <div class="item-datos">
                            <p><strong>Ciudad:</strong> </p>
                            <p><strong>Dirección:</strong> </p>
                            <p><strong>Teléfono:</strong> </p>
                            <p><strong>Email:</strong> </p>
                        </div>
                    </div>
                </li> --}}
            </ul>
        </div> <!--/.contenedor-lista-->

    {{-- Link solicitar acceso: pantalla deshabilitada
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <p class="text-center texto-especial"><em>Si usted es <strong>asociado a la UIBB</strong> y
                    desea participar de la plataforma <strong>Mi Primer Trabajo</strong>, contáctese desde
                    aquí:</em></p>

                <a class="btn btn-registro" href="{{url('/solicitar-acceso')}}">Solicitar acceso a la plataforma</a>
            </div>
        </div>
    --}}

    </main>
</div>
@endsection