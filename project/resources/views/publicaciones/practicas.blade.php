{{-- Pantalla pública: publicaciones categoría Prácticas profesionalizantes.
        URL: /practicas
        La lista de publicaciones la obtiene por AJAX a /publicaciones?categoria=capacitaciones
--}}
@extends('layouts.base')

@section('title')
    Prácticas profesionalizantes
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
            list: "{{ route('publicaciones_public_list',['categoria' => 'practicas']) }}",
            show: "{{ route('publicacion_show') }}"
        };
    </script>
@endsection

@section('content')
<div class="container">
    <main class="contenido-practicas gap-header-acceso">

        <section class="info-general">
            <div class="row">
                <div class="col-xs-12"><h2 class="texto-azul">Prácticas Profesionalizantes</h2></div>
                <div class="col-md-10 col-xs-12 clearfix">

                    <figure class="container-foto-seccion pull-left">
                        <img src="{{ url('img/foto-home-porque.png') }}" alt="¿Por qué es necesario Mi Primer Trabajo" class="img-responsive">
                    </figure>
                    <p>Las Prácticas Profesionalizantes (PP) tienen como propósito articular de modo sustancial
                        la
                        formación académica con los requerimientos y emergentes del sector socio-productivo. Se
                        busca a través de estas prácticas integrar los escenarios teóricos y prácticos,
                        articulando
                        el conocimiento adquirido con las habilidades que serán indispensables en el mundo del
                        trabajo. </p>
                    <p>En Provincia de Buenos Aires forman parte del Diseño Curricular, y contemplan un mínimo
                        de
                        200 horas de práctica en empresas o dentro del mismo establecimiento. Para los futuros
                        egresados la experiencia de participar activamente de la rutina diaria de una
                        organización
                        del sector productivo, los introduce en el mundo concreto del trabajo, los invita a
                        seguir
                        aprendiendo y generar estrategias para resolver las situaciones que se vayan
                        presentando.
                        También para las empresas constituye una experiencia desafiante, donde salen a la luz la
                        proactividad y creatividad de los jóvenes, planteándose posibilidades de enriquecimiento
                        mutuo. </p>
                    <p>Ser parte del desarrollo, formación y aprendizaje de los futuros Técnicos de nuestra
                        ciudad
                        es formar parte de la cadena de valor de la educación en su máxima expresión.</p>
                </div>
            </div>
        </section>

        <section class="notas-informativas">
            @include('publicaciones.publicaciones_categoria')
        </section>

    </main> <!--/contenido-practicas-->
</div>
@endsection