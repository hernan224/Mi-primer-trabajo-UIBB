{{-- NO USADO
Pantalla ayuda. URL: /ayuda - no estaba en requerimientos --}}
@extends('layouts.base')

@section('title')
    Ayuda y soporte
@endsection

@section('header')
    @include('layouts.header_simple')
@endsection

@section('content')
<div class="container">
    <main class="contenido-soporte gap-header-acceso">
        <div class="row">

            <div class="col-md-8 col-md-offset-2">
            <!--<div class="col-xs-12">-->
                <h3 class="texto-azul">Ayuda y Soporte</h3>
                <p>Si tiene algun inconveniente con el funcionamiento de la plataforma, o alguna duda sobre la
                    utilización de la misma, contáctese con nosotros a traves del siguiente formulario de
                    soporte.
                    Personal a cargo del mantenimiento del sistema se pondrá en contacto con usted a la
                    brevedad. Muchas Gracias</p>
            </div>
            <!--<div class="col-md-6 col-md-offset-3 col-sm-10 col-sm-offset-1">-->
            <div class="col-md-8 col-md-offset-2">

                <form action="" role="form"
                      class="soporte-form instituciones-soporte form-mpt panel-bg-color form-invertido">

                    <div class="form-group cargado">
                        <label class="sr-only input-label small" for="institucion">Institución / Asociado</label>
                        <!--SE COMPLETA AUTOMATICAMENTE CON LA INSTITUCION/ASOCIADO LOGUEADO-->
                        <input type="text" class="form-control" name="institucion-educativa"
                               id="institucion" placeholder="Institución / Asociado" value="Escuela de Educación Técnica N°1" disabled>
                    </div><!--/input Institucion-->

                    <div class="form-group cargado">
                        <label class="sr-only input-label small" for="personaContacto">Persona de contacto</label>
                        <!--SI ES UNA ESCUELA, SE CARGA POR DEFECTO EL DOCENTE LOGUEADO.
                        SI ES UN ASOCIADO, SE HABILITA EL CAMPO PARA SER COMPLETADO (QUITAR CLASE "cargado" al form-group)-->
                        <input type="text" class="form-control" name="persona-contacto"
                               id="personaContacto" placeholder="Persona de contacto" value="Juana Ana Triana" disabled>
                    </div><!--/input Persona de contacto-->

                    <div class="form-group">
                        <label class="sr-only input-label small" for="emailContacto">Email de
                            contacto</label>
                        <!--SI EXISTE MAIL DE CONTACTO EN BASE DE DATOS, SE PODRÍA COMPLETAR AUTOMATICAMENTE-->
                        <input type="email" class="form-control" name="email-contacto"
                               id="emailContacto" placeholder="Email de contacto">
                    </div><!--/input Email de contacto-->

                    <div class="form-group">
                        <label class="sr-only input-label small" for="asunto">Asunto</label>
                        <input type="text" class="form-control" name="asunto"
                               id="asunto" placeholder="Asunto">
                    </div><!--/input Asunto-->

                    <div class="form-group">
                        <label class="sr-only input-label small" for="consulta">Mensaje</label>
                        <textarea name="consulta" class="form-control" id="consulta" rows="4" placeholder="Consulta"></textarea>
                    </div> <!--/textarea Mensaje-->

                    <div class="contenedor-btns">
                        <button type="submit" class="btn btn-primary btn-login center-block">Enviar
                        </button>
                    </div>

                </form>

            </div>


        </div>
    </main>
</div>
@endsection