@extends('layouts.base')

@section('title')
    Error
@endsection

@section('header')
    @include('layouts.header_simple')
@endsection


@section('content')
<div class="container">
    <main class="error-acceso">
        <div class="row">

            <div class="col-md-6 col-md-offset-3 col-sm-10 col-sm-offset-1">
                <!--<h3 class="texto-azul">Acceso no-->
                <!--autorizado</h3>-->
                <!--<div class="panel-bg-color panel-error">-->
                    <!---->
                <!--</div>-->

                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="text-center">Error en el servidor</h3>
                    </div>
                    <div class="panel-body bg-danger">
                        <strong class="text-center">La página a la que desea acceder no existe y no tiene permitido el acceso.</strong>
                    </div>
                </div>

                <a href="{{url('/listado-alumnos')}}" class="btn-acceder btn-linea-azul btn-max-360" role="button">
                    Acceder a la Plataforma <span class="glyphicon glyphicon-arrow-right"></span>
                </a>
                {{-- si es escuela: URL acceso-escuelas, o poner otro link --}}

                <a href="{{url('/')}}" class="text-center center-block link-home">
                    Volver a la página de Inicio
                </a>

            </div>

            <!--<div class="col-md-8 col-md-offset-2 col-sm-12">-->
                <!--<p>Si uted es <strong>asociado de la UIBB o es directivo de una institución educativa</strong> y-->
                    <!--desea participar de la plataforma Mi Primer Trabajo, contáctese con nosotros:</p>-->

                <!--<a class="btn btn-registro" href="#">Solicitar acceso a la plataforma</a>-->
            <!--</div>-->
        </div>
    </main><!--/.contenido-login-->
</div>
@endsection