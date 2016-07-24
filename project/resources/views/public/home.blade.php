@extends('layouts.base', ['home' => true])

@section('header')
    @include('layouts.header_home')
@endsection

@section('content')
    <main class="contenido-home">
        <div class="container">
            <section class="row info-home info--que">
                <div class="col-sm-3 col-sm-push-9">
                    <img src="img/foto-home-que.png" alt="¿Qué es Mi Primer Trabajo?"
                         class="img-responsive foto--seccion-info">
                </div>
                <div class="col-sm-9 col-sm-pull-3">
                    <h2 class="texto-azul titulo-seccion">¿Qué es Mi Primer Trabajo?</h2>
                    <p>Mi Primer Trabajo es una Plataforma virtual de Integración Laboral, con datos relevantes de
                        todos los alumnos/as egresados de escuelas técnicas e Institutos de Enseñanza Superior de la
                        ciudad de Bahía Blanca, puestos a disposición de todas las empresas que requieran técnicos calificados.</p>
                    <p>Funciona como un nexo entre el sector productivo, las instituciones educativas y los alumnos
                        egresados, con aspiraciones de ingresar al mundo laboral.</p>
                </div>
            </section>{{-- /.info-que --}}

            <section class="row info-home info--por-que">
                <div class="col-sm-3">
                    <img src="img/foto-home-porque.png" alt="¿Por qué es necesario Mi Primer Trabajo"
                         class="img-responsive foto--seccion-info">
                </div>
                <div class="col-sm-9">
                    <h2 class="texto-azul titulo-seccion">¿Por qué es necesaria esta plataforma?</h2>
                    <p>Los cambios en los procesos de trabajo en el sector industrial, producto de la globalización
                        y avances tecnológicos de los últimos tiempos, han influido en la formación y habilidades
                        laborales que se demandan a los aspirantes a nuevos puestos.</p>
                    <p>A su vez, cada año, miles de jóvenes egresan de las instituciones educativas, ambicionando
                        continuar su formación y/o acceder a oportunidades de trabajo que les generen una
                        posibilidad de ascenso y estabilidad social.</p>
                    <p>En este contexto, Mi Primer Trabajo busca funcionar como un trampolín que vincule a ambos
                        sectores, ayudando a satisfacer las mutuas necesidades.</p>
                </div>
            </section>{{-- /.info-por-que --}}

            <section class="row info-home info--quienes">
                <div class="col-sm-3 col-sm-push-9">
                    <img src="img/foto-home-quienes.png" alt="¿Quienes desarrollan Mi Primer Trabajo"
                         class="img-responsive foto--seccion-info">
                </div>
                <div class="col-sm-9 col-sm-pull-3">
                    <h2 class="texto-azul titulo-seccion">¿Quienes llevan adelante este proyecto?</h2>
                    <p>La Mesa de Responsabilidad Social Empresaria de la Unión Industrial Bahía Blanca y la
                        Jefatura Distrital de Educación son las instituciones que ponen a disposición la plataforma,
                        buscando generar los nexos entre las instituciones educativas, sus equipos de conducción,
                        docentes y alumnos, y las empresas asociadas a la UIBB.</p>
                    <p>A su vez, serán las encargadas de retroalimentar la plataforma, asegurando su mantenimiento y
                        actualización de las bases de datos.</p>
                    <!--<p>A su vez, algunas empresas con base local, como DOW y Profertil, acompañana esta iniciativa.</p>-->
                </div>

                <div class="col-xs-12">
                    <div class="row logos-organizadores">
                        <div class="col-sm-4">
                            <a href="http://uibb.org.ar/" target="_blank" class="link-organizador">
                                <img src="img/logo-uibb-full.png" alt="Unión Industrial Bahía Blanca"
                                     class="img-responsive logo-img">
                            </a>
                        </div>
                        <div class="col-sm-4">
                            <a href="http://www.bahiablanca.gov.ar/" target="_blank" class="link-organizador">
                                <img src="img/logo-municipio-bahia-blanca.png" alt="Municipio de Bahía Blanca"
                                     class="img-responsive logo-img">
                            </a>
                        </div>
                        <div class="col-sm-4">
                            <a href="http://www.abc.gov.ar/" target="_blank" class="link-organizador">
                                <img src="img/logo-bsas.png"
                                     alt="Dirección General de Educación de la Provincia de Buenos Aires"
                                     class="img-responsive logo-bsas">
                            </a>
                        </div>
                    </div> {{-- /.logos-organizadores --}}

                    <h4 class="texto-azul text-center text-uppercase subtitulo-empresas">Acompañan el proyecto</h4>
                    <div class="row logos-organizadores">
                        <div class="col-sm-4 col-sm-offset-2">
                            <a href="http://www.profertil.com.ar/" target="_blank" class="link-organizador">
                                <img src="img/logo-profertil.png" alt="Profertil"
                                     class="img-responsive logo-profertil">
                            </a>
                        </div>
                        <div class="col-sm-4">
                            <a href="http://www.dow.com/es/argentina" target="_blank" class="link-organizador">
                                <img src="img/logo-dow.png" alt="Dow"
                                     class="img-responsive logo-img">
                            </a>
                        </div>
                        <!--<div class="col-sm-4">-->
                        <!--<a href="#" class="link-organizador">-->
                        <!--<img src="img/logo-educacion.png" alt="Dirección General de Educación de la Provincia de Buenos Aires" class="img-responsive logo-img">-->
                        <!--</a>-->
                        <!--</div>-->
                    </div> <!--/.logos-organizadores-->

                </div>
            </section>{{-- /.info-quienes --}}

            <section class="row info--participantes">
                <div class="col-xs-12">
                    <h2 class="texto-azul titulo-seccion">¿Quiénes participan de Mi Primer Trabajo?</h2>
                </div>
            {{-- Link a sección empresas - deshabilitado
                <div class="col-sm-6">
                    <a href="{{ url('/empresas')}}" class="btn-banner banner-asociados" role="button">
                        <svg viewBox="0 0 100 100" class="banner-icono">
                            <use xlink:href="#iconoAsociados"></use>
                        </svg>
                        <div class="banner-texto">
                            <h4 class="texto-azul">Asociados a la UIBB</h4>
                            <p class="texto-negro">Conozca a las Empresas Asociadas a la UIBB que participan de Mi Primer Empleo </p>
                        </div>
                    </a>
                </div>
            --}}
                <div class="col-xs-12 col-sm-6 col-lg-7 sub-sec-acceso">
                    <p>En una primera etapa, la plataforma Mi Primer Trabajo está orientada a
                        vincular a los alumnos egresados de Escuelas Técnias e Institutos de Enseñanza superior de
                        Bahía Blanca, con las PyMES y empresas que requieran técnicos calificados.</p>
                </div>
                <div class="col-xs-12 col-sm-6 col-lg-5">
                    <a href="{{ url('/instituciones-educativas')}}" class="btn-banner banner-instituciones" role="button">
                        <svg viewBox="0 0 100 100" class="banner-icono">
                            <use xlink:href="#iconoEducacion"></use>
                        </svg>
                        <div class="banner-texto">
                            <h4 class="texto-azul">Instituciones Educativas</h4>
                            <p class="texto-negro">Conozca a las Instituciones Educativas que forman parte de Mi Primer Empleo </p>
                        </div>
                    </a>
                </div>
            {{-- Link solicitar acceso: pantalla deshabilitada
                <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 sub-sec-acceso">
                    <p class="text-center">Si usted es asociado de la UIBB o es directivo de una institución
                        educativa y desea participar de la plataforma Mi Primer Trabajo, contáctese con nosotros</p>
                    <a href="{{url('/solicitar-acceso')}}" class="btn-acceder btn-full-azul btn-max-360 btn-h-celeste" role="button">
                        Solicitar Acceso
                    </a>
                </div>
            --}}
            </section>{{-- /.info-participantes --}}
        </div>

        <div class="jumbotron panel-bg-color">
            <div class="container">
                <section class="info-contacto">
                    <div class="row">
                        <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
                            <p class="texto-especial text-center">
                                <em>Si desea obtener más información, o hacernos llegar su comentario, acerca de la plataforma <strong>Mi Primer Trabajo</strong>:</em>
                            </p>
                            <a href="{{url('/contacto')}}" class="btn-acceder btn-linea-azul btn-contacto btn-max-360 btn-h-celeste text-uppercase" role="button">
                                Contáctese con nosotros
                            </a>
                        </div>
                    </div>
                </section>{{-- /.info-contacto --}}
            </div>
        </div>{{-- /.jumbotron.panel-bg-color --}}
    </main>
@endsection