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

{{-- Agrego estilos y scripts --}}
@section('scripts')
    @parent
    <script src="{{ url('js/listado_publicaciones.js') }}"></script>
    <script>
        var urls = {
            list: "{{ route('publicaciones_public_list', ['categoria' => 'capacitaciones']) }}",
            show: "{{ route('publicacion_show') }}"
        };
    </script>
@endsection

@section('content')
<div class="container">
    <main class="contenido-capacitaciones gap-header-acceso">

        <section class="info-general">
            <div class="row">
                <div class="col-xs-12"><h2 class="texto-azul">Capacitaciones</h2></div>
                <div class="col-md-10 col-xs-12 clearfix">
                    <figure class="container-foto-seccion pull-left">
                        <img src="{{ url('img/foto-home-porque.png') }}" alt="¿Por qué es necesario Mi Primer Trabajo" class="img-responsive">
                    </figure>
                    <p>Uno de los pilares de esta propuesta intersectorial es posibilitar y ofrecer
                        capacitaciones
                        para el desarrollo de competencia y habilidades sociales. Una entrevista laboral o la
                        elaboración de un Curriculum Vitae enfrenta a los flamantes egresados a un escenario que
                        requiere resolver situaciones desconocidas. En el mundo del trabajo muchas veces no
                        alcanzan
                        los conocimientos teóricos incorporados durante la formación académica, el contexto
                        laboral
                        requiere de habilidades y capacidades que permitan óptimas relaciones interpersonales,
                        inteligencia emocional y social y destrezas en resolución de situaciones
                        conflictivas. </p>
                </div>
            </div>
        </section>

        <section class="notas-informativas">
            @include('publicaciones.publicaciones_categoria')
        </section>
    </main> <!--/contenido-capacitaciones-->
</div>
@endsection