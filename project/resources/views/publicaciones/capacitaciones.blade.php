{{-- Pantalla pública: publicaciones categoría Capacitaciones.
        URL: /capacitaciones
        La lista de publicaciones la obtiene por AJAX a /publicaciones?categoria=capacitaciones
--}}
@extends('layouts.base')

@section('title')
    Capacitaciones
@endsection

@section('header')
    @include('layouts.header_menu')
@endsection

@section('content')
<div class="container">
    <main class="contenido-capcitaciones gap-header-acceso">

        <div class="row">
            <div class="col-md-8 col-sm-10">
                <!--<div class="col-xs-12">-->
                <h2 class="texto-azul">Capacitaciones</h2>
                <p>Uno de los pilares de esta propuesta intersectorial es posibilitar y ofrecer capacitaciones
                    para el desarrollo de competencia y habilidades sociales. Una entrevista laboral o la
                    elaboración de un Curriculum Vitae enfrenta a los flamantes egresados a un escenario que
                    requiere resolver situaciones desconocidas. En el mundo del trabajo muchas veces no alcanzan
                    los conocimientos teóricos incorporados durante la formación académica, el contexto laboral
                    requiere de habilidades y capacidades que permitan óptimas relaciones interpersonales,
                    inteligencia emocional y social y destrezas en resolución de situaciones conflictivas. </p>
            </div>
        </div>

        <!--/.contenedor-lista-->

    </main> <!--/contenido-capacitaciones-->
</div>
@endsection