{{-- Pantalla contacto. URL: /contacto --}}
@extends('layouts.base')

@section('title')
    Solicitar acceso a la plataforma
@endsection

@section('header')
    @include('layouts.header_simple_acceso')
@endsection

@section('scripts')
    @parent
    <script>
        $(function () {
            // mostrar spinner
            $('form').submit(function() {
                $('.spinner-container').show();
            });
        });
    </script>
@endsection

@section('content')
<div class="container">
    <main class="contenido-registro">
        <div class="row">

            <div class="col-md-8 col-md-offset-2">
                <h3 class="texto-azul">Solicitar Acceso</h3>
                <p>Si usted es <strong>asociado de la UIBB o es directivo de una institución educativa</strong>
                    y desea participar de la plataforma
                    Mi Primer Trabajo, contáctese con nosotros a través del siguiente formulario.
                    Personal del departamento de <strong>Responsabilidad Social Empresaria de la Unión
                        Industrial
                        Bahía Blanca</strong>
                    se contactará a la brevedad para proporcionarle los datos necesarios.</p>
            </div>
            <!--<div class="col-md-6 col-md-offset-3 col-sm-10 col-sm-offset-1">-->
            <div class="col-md-8 col-md-offset-2">

                <ul id="recuTabs" class="nav nav-tabs form-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#recuAsociados" aria-controls="asociados" role="tab" data-toggle="tab">Asociados</a>
                    </li>
                    <li role="presentation">
                        <a href="#recuInstituciones" aria-controls="instituciones" role="tab" data-toggle="tab">Instituciones Educativas</a>
                    </li>
                </ul> <!--.nav-tab-->

                <div class="tab-content form-tab-content">
                    <div role="tabpanel" class="tab-pane panel-bg-color active" id="recuAsociados">
                        <form action="{{url('/solicitar-acceso/empresa')}}" method="POST"  role="form" class="recu-form asociados-recu form-mpt form-invertido">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label class="sr-only input-label small" for="razonSocial">Razón social</label>
                                <input type="text" class="form-control" name="nombre" id="razonSocial"
                                       placeholder="Razón Social" required>
                            </div><!--/input Nombre-->
                            <div class="form-group">
                                <label class="sr-only input-label small" for="cuit">CUIT</label>
                                <input type="text" class="form-control" name="cuit" id="cuit"
                                       placeholder="CUIT" required>
                            </div><!--/input Apellido-->
                            <div class="form-group">
                                <label class="sr-only input-label small" for="emailAsociado">Email de
                                    contacto</label>
                                <input type="email" class="form-control" name="email"
                                       id="emailAsociado" placeholder="Email de contacto" required>
                            </div><!--/input Nombre-->

                            <div class="contenedor-btns">
                                <button type="submit" class="btn btn-primary btn-login center-block">Enviar
                                </button>
                            </div>
                        </form>
                    </div>


                    <div role="tabpanel" class="tab-pane panel-bg-color" id="recuInstituciones">
                        <form action="{{url('/solicitar-acceso/escuela')}}" method="POST" role="form"
                              class="recu-form instituciones-recu form-mpt form-invertido">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label class="sr-only input-label small" for="institucionEducativa">Institución
                                    Educativa</label>
                                <input type="text" class="form-control" name="nombre"
                                       id="institucionEducativa" placeholder="Institución Educativa" required>
                            </div><!--/input Nombre-->
                            <div class="form-group">
                                <label class="sr-only input-label small" for="docente">Docente a cargo</label>
                                <input type="text" class="form-control" name="docente" id="docente"
                                       placeholder="Docente a cargo" required>
                            </div><!--/input Apellido-->
                            <div class="form-group">
                                <label class="sr-only input-label small" for="emailInstitucion">Email de
                                    contacto</label>
                                <input type="email" class="form-control" name="email"
                                       id="emailInstitucion" placeholder="Email de contacto">
                            </div><!--/input Nombre-->

                            <div class="contenedor-btns">
                                <button type="submit" class="btn btn-primary btn-login center-block">Enviar
                                </button>
                            </div>
                        </form>
                    </div> <!--/form tab content #recuinstituciones-->
                </div> <!--.tab-content-->

            </div>

        </div>
    </main>
</div>
@include('layouts.spinner')
@endsection